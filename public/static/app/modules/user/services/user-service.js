'use strict';
(function(w){
/* Services */
var serviceName = 'UserService';
angular.module(serviceName, []).factory(serviceName, [
'$rootScope', '$q', 'CUtils', 'FormHelpers',
function($rootScope, $q, CUtils, FormHelpers){
    var apiUrls = {
        profile: $rootScope.BASE_URL + 'back/manage/user/profile',
        editProfile: $rootScope.BASE_URL + 'back/manage/user/edit_profile',
        editPassword: $rootScope.BASE_URL + 'back/manage/user/edit_password',

        obj: $rootScope.BASE_URL + 'back/manage/user/obj',
        add: $rootScope.BASE_URL + 'back/manage/user/add',
        edit: $rootScope.BASE_URL + 'back/manage/user/edit',
        remove: $rootScope.BASE_URL + 'back/manage/user/remove',
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
        loginForm:{
            name: 'passwordForm',
            fields: {
                email: {
                    name: 'email',
                    label: 'Email',
                    value: '',
                    init: ''
                },
                password: {
                    name: 'password1',
                    label: 'Mat khau',
                    value: '',
                    init: ''
                },
            }
        },

        profileForm:{
            name: 'profileForm',
            fields: {
                name: {
                    name: 'name',
                    label: 'Họ va ten',
                    value: null,
                    init: null
                }
            }
        },
        passwordForm:{
            name: 'passwordForm',
            fields: {
                password: {
                    name: 'password',
                    label: 'Mật khẩu cũ',
                    error: null,
                    value: null,
                    init: null
                },
                newPassword: {
                    name: 'newPassword',
                    label: 'Mật khẩu mới',
                    error: null,
                    value: null,
                    init: null
                },
                newPasswordAgain: {
                    name: 'newPasswordAgain',
                    label: 'Nhập lại mật khẩu mới',
                    error: null,
                    value: null,
                    init: null
                },
            }
        },

        mainForm:{
            id: null,
            fields: {
                email: {
                    name: 'email',
                    label: 'Email',
                    error: null,
                    value: null,
                    init: null
                },
                name: {
                    name: 'name',
                    label: 'Tên người dùng',
                    error: null,
                    value: null,
                    init: null
                },
                password: {
                    name: 'password',
                    label: 'Mật khẩu',
                    error: null,
                    value: null,
                    init: null
                },
                passwordAgain: {
                    name: 'password',
                    label: 'Nhập lại mật khẩu',
                    error: null,
                    value: null,
                    init: null
                },
                role: {
                    name: 'role',
                    label: 'Admin',
                    error: null,
                    value: false,
                    init: false
                },
            }
        },
    };

    var fields = {

    };

    var refs = {};

    var acts = {};

    acts.getInfo = function(){
        var formName = 'profile';
        var method = 'profile';
        CUtils.toggleGlobalLoading();
        return $q(function(resolve, reject){
            CUtils.makeRequest(
                apiUrls[method]
            ).then(function(result){
                CUtils.toggleGlobalLoading(false);
                if(result.success){
                    resolve(result);
                }else{
                    CUtils.popMessage(result.message, 'error');
                    resolve(false);
                }
            });
        });
    }

    acts.editProfile = function(){
        var formName = 'profileForm';
        var method = 'editProfile';
        FormHelpers.toggleFormLoading(formName);
        return $q(function(resolve, reject){
            CUtils.makeRequest(
                apiUrls[method], 'save',
                CUtils.formData(forms[formName]),
                ['name']
            ).then(function(result){
                FormHelpers.toggleFormLoading(formName, false);
                if(result.success){
                    var data = result.data;
                    vars.userData.name = data.name;
                    acts.emptyForm(formName);
                    FormHelpers.hideFormErrors(formName);
                    CUtils.popMessage(result.message);
                    acts.toggleModal(formName, false);
                    resolve(result);
                }else{
                    FormHelpers.hideFormErrors(formName);
                    // acts.emptyForm(formName, false);
                    FormHelpers.showFormErrors(formName, result.message);
                    CUtils.popMessage(result.message, 'error');
                    resolve(false);
                }
            });
        });
    };

    acts.editPassword = function(){
        var formName = 'passwordForm';
        var method = 'editPassword';
        if(forms[formName].fields.newPassword.value != forms[formName].fields.newPasswordAgain.value){
            FormHelpers.showCommonError(formName, 'Mật khẩu mới và mật khẩu mới nhập lại chưa khớp.');
            return;
        }
        FormHelpers.toggleFormLoading(formName);
        return $q(function(resolve, reject){
            CUtils.makeRequest(
                apiUrls[method], 'save',
                CUtils.formData(forms[formName]),
                ['password', 'newPassword']
            ).then(function(result){
                FormHelpers.toggleFormLoading(formName, false);
                if(result.success){
                    var data = result.data;
                    acts.emptyForm(formName);
                    FormHelpers.hideFormErrors(formName);
                    CUtils.popMessage(result.message);
                    acts.toggleModal(formName, false);
                    resolve(result);
                }else{
                    FormHelpers.hideFormErrors(formName);
                    var errorData = angular.copy(result.message);
                    errorData.controller = 'User';
                    errorData.formName = formName;
                    $rootScope.$emit($rootScope.FORM_ERROR_EVENT, errorData);
                    FormHelpers.showFormErrors(formName, result.message);
                    CUtils.popMessage(result.message, 'error');
                    resolve(false);
                }
            });
        });
    };

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
                    vars.modalName = 'Add new user';
                    forms[formName].id = null;
                }else{
                    // Edit
                    vars.modalName = 'Edit user';
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
                            forms[formName].fields = CUtils.setFormData(forms[formName].fields, data);
                            if(forms[formName].fields.role.value == 'ADMIN'){
                                forms[formName].fields.role.value = 1;
                            }else{
                                forms[formName].fields.role.value = 0;
                            }
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

    acts.emptyForm = function(formName, emptyError){
        emptyError = typeof emptyError == 'undefined' ? true : emptyError;
        if(emptyError){
            FormHelpers.hideFormErrors(formName);
        }
        forms[formName].fields = FormHelpers.clearFormInput(forms[formName].fields);
    }

    acts.submitForm = function(formName){
        if(formName == 'mainForm'){
            var id = forms[formName].id;
            if(id === null){
                // Add
                var method = 'add';
                if(forms[formName].fields.password.value != forms[formName].fields.passwordAgain.value){
                    FormHelpers.showCommonError(formName, 'Mật khẩu và mật khẩu nhập lại chưa khớp.');
                    return;
                }
                CUtils.toggleGlobalLoading();
                CUtils.makeRequest(
                    apiUrls[method],
                    'save',
                    CUtils.formData(forms[formName]),
                    ['name', 'email', 'password', 'role']
                ).then(function(result){
                    CUtils.toggleGlobalLoading(false);
                    if(result.success){
                        var data = result.data;
                        vars.listItem.unshift(data);
                        acts.toggleModal(formName, false);
                    }else{
                        var errorData = angular.copy(result.message);
                        errorData.controller = 'User';
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
                    ['id', 'name', 'email', 'password', 'role']
                ).then(function(result){
                    CUtils.toggleGlobalLoading(false);
                    if(result.success){
                        var data = result.data;
                        var index = CUtils.getIndexFromId(vars.listItem, data.id);
                        vars.listItem[index] = data;
                        acts.toggleModal(formName, false);
                    }else{
                        var errorData = angular.copy(result.message);
                        errorData.controller = 'User';
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