'use strict';
(function(w){
/* Services */
var serviceName = 'SceneService';
angular.module(serviceName, []).factory(serviceName, [
'$rootScope', '$q', 'CUtils', 'FormHelpers',
function($rootScope, $q, CUtils, FormHelpers){
    var apiUrls = {
        obj: $rootScope.BASE_URL + 'back/manage/scene/obj',
        add: $rootScope.BASE_URL + 'back/manage/scene/add',
        edit: $rootScope.BASE_URL + 'back/manage/scene/edit',
        remove: $rootScope.BASE_URL + 'back/manage/scene/remove',
        applyScene: $rootScope.BASE_URL + 'back/user/scene/apply_scene',
    };

    var vars = {
        params: {},
        state: null,
        page: 1,
        reachBottom: false,
        scrollBusy: true,
        listItem: [],
    };

    var trans = {};

    var forms = {
        mainForm:{
            id: null,
            fields: {
                scene_name: {
                    name: 'scene_name',
                    label: 'Scene name',
                    error: null,
                    value: null,
                    init: null
                },
               scene_no: {
                    name: 'scene_no',
                    label: 'Scene no',
                    error: null,
                    value: null,
                    init: null
                }, 
                device_id: {
                    name: 'device_id',
                    label: 'Device ID',
                    error: null,
                    value: null,
                    init: null
                },
                channel_1_value: {
                    name: 'channel_1_value',
                    label: 'Channel 1 value',
                    error: null,
                    value: null,
                    init: null
                },
                channel_2_value: {
                    name: 'channel_2_value',
                    label: 'Channel 2 value',
                    error: null,
                    value: null,
                    init: null
                },
                channel_3_value: {
                    name: 'channel_3_value',
                    label: 'Channel 3 value',
                    error: null,
                    value: null,
                    init: null
                },
                channel_4_value: {
                    name: 'channel_4_value',
                    label: 'Channel 4 value',
                    error: null,
                    value: null,
                    init: null
                },
                channel_5_value: {
                    name: 'channel_5_value',
                    label: 'Channel 5 value',
                    error: null,
                    value: null,
                    init: null
                },
                channel_6_value: {
                    name: 'channel_6_value',
                    label: 'Channel 6 value',
                    error: null,
                    value: null,
                    init: null
                },
                channel_7_value: {
                    name: 'channel_7_value',
                    label: 'Channel 7 value',
                    error: null,
                    value: null,
                    init: null
                },
                channel_8_value: {
                    name: 'channel_8_value',
                    label: 'Channel 8 value',
                    error: null,
                    value: null,
                    init: null
                },
                status: {
                    name: 'statu',
                    label: 'Status',
                    error: null,
                    value: null,
                    init: null
                }
            }
        },
    };

    var fields = {

    };

    var refs = {};

    var acts = {};

    acts.toggleModal = function(formName, isOpen, id, emptyError){
        isOpen = typeof isOpen == 'undefined' ? true : isOpen;
        id = typeof id == 'undefined' ? null : id;
        emptyError = typeof emptyError == 'undefined' ? true : emptyError;
        CUtils.toggleModal(forms[formName], formName, isOpen);
        if(isOpen){
            FormHelpers.hideFormErrors(formName);
            if(formName == 'profileForm'){
                acts.getInfo().then(function(result){
                    forms[formName] = FormHelpers.setFormValue(forms[formName], result.data);
                });
            }else if(formName == 'mainForm'){
                acts.emptyForm(formName, emptyError);
                if(id === null){
                    // Add new
                    vars.modalName = 'Add new scene';
                    forms[formName].id = null;
                }else{
                    // Edit
                    vars.modalName = 'Edit scene';
                    forms[formName].id = id;
                    var method = 'obj';
                    CUtils.toggleGlobalLoading();
                    CUtils.makeRequest(
                        apiUrls[method],
                        'get',
                        {'id': forms[formName].id},
                        ['id']
                    ).then(function(result){
                        CUtils.toggleGlobalLoading(false);
                        if(result.success){
                            // Result here
                            var data = result.data;
                            for(var i in data){
                                if(i != 'scene_name'){
                                    data[i] = parseInt(data[i]);
                                }
                            }
                            forms[formName].fields = CUtils.setFormData(forms[formName].fields, data);
                        }else{
                            CUtils.popMessage(result.message, 'error');
                            // Error here
                        }
                    });
                }
            }else{
                acts.emptyForm(formName, emptyError);
            }
        }
    };

    

    acts.submitForm = function(formName){
        if(formName == 'mainForm'){
            var id = forms[formName].id;
            if(id === null){
                // Add
                var method = 'add';
                CUtils.toggleGlobalLoading();
                CUtils.makeRequest(
                    apiUrls[method],
                    'save',
                    CUtils.formData(forms[formName]),
                    ['scene_name', 'scene_no', 'device_id', 'channel_1_value', 'channel_2_value', 'channel_3_value', 'channel_4_value', 'channel_5_value', 'channel_6_value', 'channel_7_value', 'channel_8_value', 'status']
                ).then(function(result){
                    CUtils.toggleGlobalLoading(false);
                    if(result.success){
                        var data = result.data;
                        vars.listItem.unshift(data);
                        acts.toggleModal(formName, false);
                    }else{
                        var errorData = angular.copy(result.message);
                        errorData.controller = 'Scene';
                        errorData.formName = formName;
                        $rootScope.$emit($rootScope.FORM_ERROR_EVENT, errorData);
                        FormHelpers.showFormErrors(formName, result.message);
                        CUtils.popMessage(result.message, 'error');
                    }
                });
            }else{
                // Edit
                var method = 'edit';
                var data = CUtils.formData(forms[formName]);
                data.id = id;
                CUtils.toggleGlobalLoading();
                CUtils.makeRequest(
                    apiUrls[method],
                    'save',
                    data,
                    ['id', 'scene_name', 'scene_no', 'device_id', 'channel_1_value', 'channel_2_value', 'channel_3_value', 'channel_4_value', 'channel_5_value', 'channel_6_value', 'channel_7_value', 'channel_8_value', 'status']
                ).then(function(result){
                    CUtils.toggleGlobalLoading(false);
                    if(result.success){
                        var data = result.data;
                        var index = CUtils.getIndexFromId(vars.listItem, data.id);
                        vars.listItem[index] = data;
                        acts.toggleModal(formName, false);
                    }else{
                        var errorData = angular.copy(result.message);
                        errorData.controller = 'Scene';
                        errorData.formName = formName;
                        $rootScope.$emit($rootScope.FORM_ERROR_EVENT, errorData);
                        FormHelpers.showFormErrors(formName, result.message);
                        CUtils.popMessage(result.message, 'error');
                    }
                });
            }
        }
    }

    acts.confirmRemove = function(id){
        var formName = 'mainForm';
        var method = 'remove';
        var data = {'id': id};
        var confirmMessage = confirm('Do you want to remove this record?');
        if(confirmMessage){
            CUtils.toggleGlobalLoading();
            CUtils.makeRequest(
                apiUrls[method],
                'save',
                data,
                ['id']
            ).then(function(result){
                CUtils.toggleGlobalLoading(false);
                if(result.success){
                    var data = result.data;
                    var index = CUtils.getIndexFromId(vars.listItem, data.id);
                    vars.listItem.splice(index,1);
                    acts.toggleModal(formName, false);
                }else{
                    CUtils.popMessage(result.message, 'error');
                }
            });
        }
    }

    acts.applyScene = function(id){
        var method = 'applyScene';
        var data = {'id': id};
        CUtils.toggleGlobalLoading();
        CUtils.makeRequest(
            apiUrls[method],
            'save',
            data,
            ['id']
        ).then(function(result){
            CUtils.toggleGlobalLoading(false);
            if(result.success){
                var data = result.data;
                console.log(data);
            }else{
                CUtils.popMessage(result.message, 'error');
            }
        });
    }

    acts.emptyForm = function(formName, emptyError){
        emptyError = typeof emptyError == 'undefined' ? true : emptyError;
        if(emptyError){
            FormHelpers.hideFormErrors(formName);
        }
        forms[formName].fields = FormHelpers.clearFormInput(forms[formName].fields);
    }

    var model = {
        apiUrls: apiUrls,
        vars: vars,
        trans: trans,
        forms: forms,
        fields: fields,
        refs: refs,
        acts: acts,
    };

    return model;
}]);
}(window));