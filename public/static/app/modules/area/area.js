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
var ctrlName = 'Area';
angular.module('App')
.controller(ctrlName,
['$scope', '$rootScope', 'CUtils', 'FormHelpers', 'AreaService', 'DeviceService',
function($scope, $rootScope, CUtils, FormHelpers, AreaService, DeviceService){
    var vm = this; // jshint ignore:line
    vm.model = AreaService;
    vm.DeviceService = DeviceService;
    if(typeof js_vars !== 'undefined'){
        if(typeof js_vars['list_item'] != 'undefined'){
            vm.model.vars.listItem = js_vars['list_item'];
        }else{
            vm.model.vars.listItem = []
        }
        if(typeof js_vars['devices'] != 'undefined'){
            vm.model.refs.devices = js_vars['devices'];
        }else{
            vm.model.refs.devices = []
        }
        /*
        if(typeof js_vars['init_data'] != 'undefined'){
            vm.model.vars.initData = js_vars['init_data'];
            for(var i in vm.model.refs.devices){
                var id = vm.model.refs.devices[i].id;
                if(typeof vm.model.vars.initData[id] !== 'undefined'){
                    vm.model.refs.devices[i].value = vm.model.vars.initData[id];
                }else{
                    vm.model.refs.devices[i].value = 0;
                }
            }
        }else{
            vm.model.vars.initData = [];
        }
        */
    }else{
        vm.model.vars.areaData = null;
    }

    /* Handle init components */

    $(".dial").knob({
        'release' : function(value){ 
            // console.log($(".dial").val());
            // console.log(value);
            if(vm.model.vars.currentValue == value) return;
            vm.model.acts.setValue(parseInt(value)).then(function(data){
                console.log(data);
                // Set data here
            });
        }
    });
    vm.model.vars.switch = $("[name='my-checkbox']").bootstrapSwitch();
    $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, value) {
        value = value?100:0;
        console.log(value);
        vm.model.acts.setValue(value).then(function(data){
            console.log(data);
        });
    });

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