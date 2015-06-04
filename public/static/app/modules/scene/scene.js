'use strict';
(function(w){
var $ = w.jQuery;
/**
 * @ngdoc function
 * @name clientApp.controller:AboutCtrl
 * @description
 * # Home
 * Controller of the clientApp
 */
var ctrlName = 'Scene';
angular.module('App')
.controller(ctrlName,
['$scope', '$rootScope', 'CUtils', 'FormHelpers', 'SceneService',
function($scope, $rootScope, CUtils, FormHelpers, SceneService){
    var vm = this; // jshint ignore:line
    vm.model = SceneService;
    vm.CUtils = CUtils;
    if(typeof js_vars !== 'undefined'){
        if(typeof js_vars['list_item'] != 'undefined'){
            vm.model.vars.listItem = js_vars['list_item'];
        }else{
            vm.model.vars.listItem = [];
        }
        if(typeof js_vars['devices'] != 'undefined'){
            vm.model.vars.devices = js_vars['devices'];
            vm.model.refs.list_device = CUtils.objToSelectize(js_vars['devices'], 'id', 'device_name');
            /* Init dropdown */
            vm.model.forms.mainForm.fields.device_id.init = vm.model.refs.list_device[0].id;
        }else{
            vm.model.vars.devices = [];
            vm.model.refs.list_device = [];
        }
    }else{
        vm.model.vars.sceneData = null;
    }

    /* Handle toggle modal */
    vm.toggleModal = function(formName, isOpen, id, emptyError){
        isOpen = typeof isOpen == 'undefined' ? true : isOpen;
        id = typeof id == 'undefined' ? null : id;
        emptyError = typeof emptyError == 'undefined' ? true : emptyError;
        vm.model.acts.toggleModal(formName, isOpen, id, emptyError);
        if(!isOpen) return;
        var form = $scope[formName];
        for(var i in form){
            if(i.charAt(0) != '$'){
                form[i].$touched = false;
                $scope[formName][i].$setValidity("custom", true);
            }
        }
    }

    /* Handle form error display */
    $rootScope.$on($rootScope.FORM_ERROR_EVENT, function(event, data){
        if(data['controller'] == ctrlName){
            var formName = data['formName'];
            for(var i in data){
                if(i != 'controller' && i !== 'formName'){
                    if(i!=='common'){
                        vm.model.forms[formName].fields[i].error = data[i];
                        $scope[formName][i].$setValidity("custom", false);
                    }else{
                        FormHelpers.showCommonError(formName, data[i]);
                    }
                    
                }
            }
        }
    });
}]);
}(window));