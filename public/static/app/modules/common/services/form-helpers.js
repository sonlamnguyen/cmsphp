'use strict';
(function(){
/* Services */

var CUtils=angular.module('FormHelpers',[]);
CUtils.factory('FormHelpers', [
'$timeout', 'CUtils',
function($timeout, CUtils){
    var model = {};

    model.toggleFormLoading = function(formId, show){
        show = typeof show == 'undefined' ? true : show;
        if(show){
            $('#' + formId + ' .glyphicon-refresh').show();
        }else{
            $('#' + formId + ' .glyphicon-refresh').hide();
        }
    };

    model.hideFormErrors = function(formName){
        $timeout(function(){
            $('form[name="' + formName + '"] .alert-danger').hide();
            model.toggleFormLoading(formName, false);
        }, 50);
    };

    model.clearFormInput = function(fieldList){
        for(var i in fieldList){
            fieldList[i].value = fieldList[i].init;
        }
        return fieldList;
    };

    model.showCommonError = function(formName, error){
        /*
        $('#' + formName + ' .form-group').removeClass('hass-error');
        $('#' + formName + ' .form-group').addClass('hass-success');
        */
        var errElm = $('form[name="' + formName + '"] .alert-danger');
        errElm.show();
        errElm.text(error);
    };

    model.showFormErrors = function(formId, errors){
        var errType = typeof errors == 'object' ? 'object' : 'text';
        if(errType == 'text') errors = {common: errors};

        $('#' + formId + ' .form-group').removeClass('hass-error');
        $('#' + formId + ' .form-group').addClass('hass-success');
        for(var fieldId in errors){
            var error = errors[fieldId];
            if(fieldId == 'common'){
                var errElm = $('#' + formId + ' .alert-danger');
                errElm.show();
                errElm.text(error);
            }else{
                var formGroupElm = $('#' + fieldId);
                var errElm = $('#' + formId + ' #' + fieldId + ' .text-danger');
                formGroupElm.removeClass('has-success');
                formGroupElm.addClass('has-error');
                errElm.show();
                errElm.text(error);
            }
        }
    };

    model.setFormValue = function(form, values){
        for(var key in values){
            if(typeof form.fields[key] != 'undefined'){
                form.fields[key].value = values[key];
            }
        }
        return form;
    };

    return model;
}]);
}());
