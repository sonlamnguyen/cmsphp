'use strict';
(function(w){
/* Services */
var CommonFilters=angular.module('CommonFilters',[]);
CommonFilters.factory('CommonFilters', ['CUtils',function(CUtils){
    return CUtils;
}])

CommonFilters.filter('count', function(){
    return function(input) {
        if(input){
            if(typeof input == 'object'){
                if(typeof input[0] == 'undefined'){
                    return 0;
                }
            }
            return input.length;
        }
        return 0;
    }
});

CommonFilters.filter('mapLabel', function(){
    return function(input, source) {
        if(input in source){
            return source[input];
        }
        return 0;
    }
});

CommonFilters.filter('zeroFill', function(){
    return function(input) {
        if(!input){
            return 0;
        }
        return input;
    }
});

CommonFilters.filter('filterBy', function(){
    return function(input, key, value) {
        if(!input){
            return [];
        }
        var result = [];
        for(var i in input){
            if(input[i][key] == value){
                result.push(input[i]);
            }
        }
        return result;
    }
});

CommonFilters.filter('checkExistByDeviceType', function(){
    return function(device_type, devices, area_id) {
        var isExist = false;
        if(!devices){
            return isExist;
        }
        for(var i in devices){
            if(device_type == devices[i].device_type && devices[i].area_id == area_id){
                isExist = true;
                break;
            }
        }
        return isExist;
    }
});

CommonFilters.filter('checkExistByArea', function(){
    return function(area_id, devices, device_type) {
        var isExist = false;
        if(!devices){
            return isExist;
        }
        for(var i in devices){
            if(area_id == devices[i].area_id && devices[i].device_type == device_type){
                isExist = true;
                break;
            }
        }
        return isExist;
    }
});

CommonFilters.filter('checkControlType', function(){
    return function(value, type) {
        type = parseInt(type);
        switch(type){
            case 0:
                // Not control
                return null;
            break;
            case 1:
                // On/Off
                if(parseInt(value) == 0){
                    return 'OFF';
                }
                return 'ON'
            break;
            case 2:
                // Dimmer
                return value + '%';
            break;
            default:
                // Not control
                return null;
            break;
        }
    }
});

CommonFilters.filter('checkNotControl', function(){
    return function(type) {
        type = parseInt(type);
        if(type === 0){
            return true;
        }
        return false;
    }
});

CommonFilters.filter( 'filesize', function () {
    var units = [
        'bytes',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB'
    ];

    return function( bytes, precision ) {
        if ( isNaN( parseFloat( bytes )) || ! isFinite( bytes ) ) {
            return '?';
        }

        var unit = 0;

        while ( bytes >= 1024 ) {
            bytes /= 1024;
            unit ++;
        }

        return bytes.toFixed( + precision ) + ' ' + units[ unit ];
    };
});


CommonFilters.filter('fm', ['CUtils', function(CUtils){
    return function(input, vm) {
        var inputArr = input.split('.');
        var key = '';
        var formId = '';
        var fieldId = '';
        var result = null;
        if(inputArr.length == 4){
            formId = inputArr[0];
            fieldId = inputArr[1];
            return vm.model.forms[formId].field[fieldId].value;
        }else if(inputArr.length == 3){
            formId = inputArr[0];
            fieldId = inputArr[1];
            key = formId + '.fields.' + fieldId + '.label';
        }else if(inputArr.length == 2){
            formId = inputArr[0];
            fieldId = inputArr[1];
            key = formId + '.fields.' + fieldId + '.id';
        }else{
            key = input + '.id';
        }
        // vm.model.forms.login.fields.username.id
        result = CUtils.dotNotation(key, vm.model.forms);
        return result;
    }
}]);
}(window));
