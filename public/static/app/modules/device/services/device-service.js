'use strict';
(function(w){
/* Services */
var serviceName = 'DeviceService';
angular.module(serviceName, []).factory(serviceName, [
'$rootScope', '$q', 'CUtils', 'FormHelpers',
function($rootScope, $q, CUtils, FormHelpers){
    var apiUrls = {
        obj: $rootScope.BASE_URL + 'back/manage/device/obj',
        add: $rootScope.BASE_URL + 'back/manage/device/add',
        edit: $rootScope.BASE_URL + 'back/manage/device/edit',
        remove: $rootScope.BASE_URL + 'back/manage/device/remove',
        info: $rootScope.BASE_URL + 'back/user/device/info',
        setValue: $rootScope.BASE_URL + 'back/user/device/set_value',
    };

    var vars = {
        params: {},
        state: null,
        page: 1,
        reachBottom: false,
        scrollBusy: true,
        listItem: [],
        dimmerBusy: false,
        dimmerTimeout: 300,
        currentValue: 0,
    };

    var trans = {};

    var refs = {
        types: [
            {
                id: 0,
                title: 'Light',
                order: 0,
            },{
                id: 1,
                title: 'Switch',
                order: 1,
            },{
                id: 2,
                title: 'Pulp',
                order: 2,
            },{
                id: 3,
                title: 'Weather',
                order: 3,
            }
        ],
        controlTypes: [
            {
                id: 0,
                title: 'Not control',
                order: 0
            }, {
                id: 1,
                title: 'On/Off',
                order: 1 
            }, {
                id: 2,
                title: 'Dimmer',
                order: 2 
            }
        ],
        channels: [
            {id: 1, title: 'Channel 1', order: 0},
            {id: 2, title: 'Channel 2', order: 1},
            {id: 3, title: 'Channel 3', order: 2},
            {id: 4, title: 'Channel 4', order: 3},
            {id: 5, title: 'Channel 5', order: 4},
            {id: 6, title: 'Channel 6', order: 5},
            {id: 7, title: 'Channel 7', order: 6},
            {id: 8, title: 'Channel 8', order: 7},
        ],
    };

    var forms = {
        mainForm:{
            id: null,
            fields: {
                area_id: {
                    name: 'area_id',
                    label: 'Area ID',
                    error: null,
                    value: null,
                    init: null
                },
                subnet_id: {
                    name: 'subnet_id',
                    label: 'Subnet ID',
                    error: null,
                    value: null,
                    init: null
                },
                rtu_id: {
                    name: 'rtu_id',
                    label: 'RTU ID',
                    error: null,
                    value: null,
                    init: null
                },
                device_type: {
                    name: 'device_type',
                    label: 'Device type',
                    error: null,
                    value: null,
                    init: refs.types[0].id
                },
                control_type: {
                    name: 'control_type',
                    label: 'Control type',
                    error: null,
                    value: null,
                    init: refs.controlTypes[0].id
                },
                device_name: {
                    name: 'device_name',
                    label: 'Device name',
                    error: null,
                    value: null,
                    init: null
                },
                channel_id: {
                    name: 'channel_id',
                    label: 'Channel ID',
                    error: null,
                    value: null,
                    init: refs.channels[0].id
                }
            }
        },
    };

    var acts = {};

    acts.toggleModal = function(formName, isOpen, id, emptyError){
        isOpen = typeof isOpen == 'undefined' ? true : isOpen;
        id = typeof id == 'undefined' ? null : id;
        emptyError = typeof emptyError == 'undefined' ? true : emptyError;
        CUtils.toggleModal(forms[formName], formName, isOpen);
        if(isOpen){
            if(formName == 'changingForm'){
                var idArr = id.split('.');
                var subnet_id = idArr[0];
                var rtu_id = idArr[1];
                acts.getInfo(subnet_id, rtu_id).then(function(data){
                    console.log(data);
                    vars.subnetId = subnet_id;
                    vars.rtuId = rtu_id;
                    vars.modalName = data.area;
                    vars.deviceName = data.device_name;
                    vars.controlType = data.control_type;
                });
            }else if(formName == 'mainForm'){
                FormHelpers.hideFormErrors(formName);
                acts.emptyForm(formName, emptyError);
                if(id === null){
                    // Add new
                    vars.modalName = 'Add new device';
                    forms[formName].id = null;
                }else{
                    // Edit
                    vars.modalName = 'Edit device';
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
                            data.rtu_id = parseInt(data.rtu_id);
                            data.subnet_id = parseInt(data.subnet_id);
                            data.device_type = parseInt(data.device_type);
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
                    ['area_id', 'rtu_id', 'subnet_id', 'device_name', 'device_type', 'control_type', 'channel_id']
                ).then(function(result){
                    CUtils.toggleGlobalLoading(false);
                    if(result.success){
                        var data = result.data;
                        vars.listItem.unshift(data);
                        acts.toggleModal(formName, false);
                    }else{
                        var errorData = angular.copy(result.message);
                        errorData.controller = 'Device';
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
                    ['id', 'area_id', 'rtu_id', 'subnet_id', 'device_name', 'device_type', 'control_type', 'channel_id']
                ).then(function(result){
                    CUtils.toggleGlobalLoading(false);
                    if(result.success){
                        var data = result.data;
                        var index = CUtils.getIndexFromId(vars.listItem, data.id);
                        vars.listItem[index] = data;
                        acts.toggleModal(formName, false);
                    }else{
                        var errorData = angular.copy(result.message);
                        errorData.controller = 'Device';
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

    acts.getInfo = function(subnet_id, rtu_id){
        var method = 'info';
        var data = {'subnet_id': subnet_id, 'rtu_id': rtu_id};
        CUtils.toggleGlobalLoading();
        return $q(function(resolve, reject){
            CUtils.makeRequest(
                apiUrls[method],
                'get',
                data,
                ['subnet_id', 'rtu_id']
            ).then(function(result){
                CUtils.toggleGlobalLoading(false);
                if(result.success){
                    var data = result.data;
                    if(data.control_type == 1){
                        // On/Off
                        $('input[name="my-checkbox"]').bootstrapSwitch('state', parseInt(data.value)?true:false);
                    }else if(data.control_type == 2){
                        // Dimmer
                        vars.currentValue = parseInt(data.value);
                        $('.dial').val(vars.currentValue).trigger('change');
                    }
                    resolve(data);
                }else{
                    CUtils.popMessage(result.message, 'error');
                    resolve(false);
                }
            });
        });
    }

    acts.toggleDimmer = function(active){
        if(active){
            vars.currentValue = 99;
            active = 100;
        }else{
            vars.currentValue = 1;
            active = 0;
        }
        $('.dial').val(active).trigger('change');
    }

    acts.setValue = function(value){
        var method = 'setValue';
        var data = {'subnet_id': vars.subnetId, 'rtu_id': vars.rtuId, 'value': value};
        CUtils.toggleGlobalLoading();
        return $q(function(resolve, reject){
            CUtils.makeRequest(
                apiUrls[method],
                'save',
                data,
                ['subnet_id', 'rtu_id', 'value']
            ).then(function(result){
                CUtils.toggleGlobalLoading(false);
                if(result.success){
                    var data = result.data;
                    var index = CUtils.getIndexFromId(vars.listItem, data.id);
                    vars.listItem[index].value = data.value;
                    console.log(data);
                    resolve(data);
                }else{
                    CUtils.popMessage(result.message, 'error');
                    resolve(false);
                }
            });
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
        refs: refs,
        acts: acts,
    };

    return model;
}]);
}(window));