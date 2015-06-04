'use strict';
(function(w){
/* Services */
var UNAUTHORIZED = 401;
var FORBIDEN = 403;
var NOT_FOUND = 404;
var STR_DELIMITER = '.#.';
var CUtils=angular.module('CUtils',[]);
CUtils.factory('CUtils', [
'$resource', '$rootScope', '$timeout', '$q', 'toastr', 'localStorageService',
function($resource, $rootScope, $timeout, $q, toastr, localStorageService){
    var CSRFToken = $('[name="_token"]').val();;
    var pageTitle = $('title');
    var defaultPerPage = 10;
    var maxItemsPerPage = 150;
    function toggleGlobalLoading(show){
        show = typeof show == 'undefined' ? true : show;
        if(show){
            $('#global-loading').show();
        }else{
            $('#global-loading').hide();
        }
    }

    var toggleFormLoading = function(formId, show){
        show = typeof show == 'undefined' ? true : show;
        if(show){
            $('#' + formId + ' .form-loading').show();
        }else{
            $('#' + formId + ' .form-loading').hide();
        }
    };

    var emptyForm = function(fields){
        for(var field in fields){
            fields[field].value = fields[field].init;
        }
        return fields;
    };

    function popMessage(message, messageType){
        messageType = typeof messageType == 'undefined' ? 'success' : messageType;
        if(message !== null){
            message = typeof message == 'object' ? message.common : message;
        }
        if(!message) return;
        switch(messageType){
            case 'success':
                toastr.success(message);
            break;
            case 'info':
                toastr.info(message);
            break;
            case 'warning':
                toastr.warning(message);
            break;
            case 'error':
                toastr.error(message);
            break;
            default:
                toastr.success(message);
            break;
        }
    };

    var goToState = function(state, params, refresh){
        $('.modal-backdrop').hide();
        if(typeof params === 'undefined'){
            $state.go(state);
        }else{
            refresh = typeof refresh === 'undefined' ? false : refresh;
            $state.go(state, params, {reload: refresh});
        }
    };

    var checkStatus = function(result){
        toggleGlobalLoading(false);
        var status = result.data.status_code;
        switch(status){
            case UNAUTHORIZED:
                Auth.setToken(null);
                Auth.setProfile(null);
                goToState('blank.login');
                return result.data;
            break;
            case FORBIDEN:
                goToState('blank.login');
                return result.data;
            break;
            /*
            case NOT_FOUND:
                goToState('anon.not-found');
            break;
            */
        }
        return result.data;
    };

    var transform = function(data){
        var result = {};
        for(var i in data){
            if(typeof(data[i]) !== 'function'){
                result[i] = data[i];
            }
        }
        return $.param(result);
    };

    var transformFile = function (data) {
        var formData = new FormData();
        /*
        //need to convert our json object to a string version of json otherwise
        // the browser will do a 'toString()' on the object which will result
        // in the value '[Object object]' on the server.
        formData.append("model", angular.toJson(data.model));
        //now add all of the assigned files
        for (var i = 0; i < data.files; i++) {
            //add each file to the form data and iteratively name them
            formData.append("file" + i, data.files[i]);
        }
        */
        for(var i in data){
            var item = data[i];
            if(typeof item == 'object'){
                formData.append(i, item);
            }else{
                formData.append(i, angular.toJson(item));
            }
        }
        return formData;
    };

    var serviceReturnObj = function(verb, headers, includedFile){
        var upperVerb = null;
        switch(verb){
            case 'get':
                upperVerb = 'GET';
            break;
            case 'save':
                upperVerb = 'POST';
            break;
            case 'query':
                upperVerb = 'GET';
            break;
            case 'remove':
                upperVerb = 'DELETE';
            break;
            case 'delete':
                upperVerb = 'DELETE';
            break;
        }

        var returnObj = {
            method: upperVerb,
            headers: headers,
            transformRequest: transform,
            interceptor: {
                response: function (result) {
                    return checkStatus(result);
                },
                responseError: function (result) {
                    return checkStatus(result);
                }
            }
        };

        if(w.requestPayloadType == 'json' && !includedFile){
            delete returnObj.transformRequest;
        }
        /*
        if(includedFile){
            returnObj.headers['Content-Type'] = undefined;
        }
        */
        if(includedFile){
            // returnObj.transformRequest = angular.identity;
            returnObj.headers['Content-Type'] = undefined;
            returnObj.transformRequest = transformFile;
        }
        if(verb == 'query'){
            returnObj.isArray = true;
        }

        return returnObj;
    };

    var parseTitle = function(title, titleParams){
        title = typeof title == 'undefined' ? '' : title;
        titleParams = typeof titleParams == 'undefined' ? {} : titleParams;
        var titleArr = title.split('%s');
        for(var i in titleParams){
            var titleParamItem = titleParams[i];
            titleArr[i] += titleParamItem;
        }
        title = titleArr.join('');
        return title;
    };

    var makeRequest = function(url, method, params, inputKeys){
        if(typeof url != 'string'){
            var result = {
                success: false,
                message: 'URL rỗng hoặc không phải là string! Vui lòng kiểm tra lại.'
            };
            return $q(function(resolve, reject){
                resolve(result);
            });
        }
        method = typeof method == 'undefined' ? 'get' : method;
        params = typeof params == 'undefined' ? null : params;
        inputKeys = typeof inputKeys == 'undefined' ? [] : inputKeys;
        return $q(function(resolve, reject){
            // model.toggleGlobalLoading(true);
            var ResultItem = model.obj(url, model.checkObjExist(params));
            var resultItem = model.setParams(ResultItem, inputKeys, params);
            switch(method){
                case 'save':
                    ResultItem.save(resultItem, function(result){resolve(result);}, function(result){resolve(result);});
                break;
                case 'query':
                    ResultItem.query(resultItem, function(result){resolve(result);}, function(result){resolve(result);});
                break;
                case 'delete', 'remove':
                    ResultItem.delete(resultItem, function(result){resolve(result);}, function(result){resolve(result);});
                break;
                default:
                    ResultItem.get(resultItem, function(result){resolve(result);}, function(result){resolve(result);});
                break;
            };
        });
    };

    var model = {
        defaultPerPage: defaultPerPage,
        maxItemsPerPage: maxItemsPerPage,
        popMessage: popMessage,
        obj: function(apiUrl, includedFile){
            includedFile = typeof includedFile === 'undefined' ? false : includedFile;
            var headers = {
                'Accept': '*/*',
                'X-Requested-With': 'XMLHttpRequest'
            };
            switch(w.requestPayloadType){
                case 'json':
                    headers['Content-type'] = 'application/json';
                    break;
                case 'url_encode':
                    headers['Content-type'] = 'application/x-www-form-urlencoded';
                    break;
                default:
                    headers['Content-type'] = 'application/x-www-form-urlencoded';
                    break;
            }
            if(includedFile){
                headers['Content-type'] = undefined;
            }
            /*
            if(Auth.getToken()){
                headers.Authorization = 'Bearer ' + Auth.getToken();
            }
            */
            headers['X-CSRFToken'] = CSRFToken;

            return $resource(apiUrl, {}, {
                get: serviceReturnObj('get', headers, includedFile),
                save: serviceReturnObj('save', headers, includedFile),
                query: serviceReturnObj('query', headers, includedFile),
                remove: serviceReturnObj('remove', headers, includedFile),
                'delete': serviceReturnObj('delete', headers, includedFile)
            });
        },

        toggleGlobalLoading: toggleGlobalLoading,
        toggleFormLoading: toggleFormLoading,
        emptyForm: emptyForm,

        goToState: function(state, params, refresh){
            refresh = typeof refresh === 'undefined' ? false : refresh;
            goToState(state, params, {reload: refresh});
        },

        storage: {
            setKey: function(key, value){
                localStorageService.set(key, value);
            },
            getKey: function(key){
                return localStorageService.get(key);
            },
            removeKey: function(key){
                localStorageService.remove(key);
            },
        },

        getRef: function(inputList){
            var refList = {};
            for(var i in inputList){
                var item = inputList[i];
                refList[item.id] = item;
            }
            return refList;
        },

        checkObjExist: function(input){
            for(var i in input){
                var item = input[i];
                if(item !== null && typeof item == 'object'){
                    return true;
                }
            }
            return false;
        },

        parseTitle: function(title, titleParams){
            return parseTitle(title, titleParams);
        },

        setPageInfo: function(titleObj){
            if(typeof titleObj != 'object'){
                if(typeof titleObj == 'string'){
                    titleObj = {
                        title: titleObj,
                        params: []
                    }
                }else{
                    titleObj = {
                        title: '',
                        params: []
                    }
                }
            }
            var title = parseTitle(titleObj.title, titleObj.params);
            $rootScope.PAGE_TITLE = title;
            pageTitle.html($rootScope.PAGE_TITLE);
        },

        setFormData: function(formObj, data){
            for(var i in formObj){
                if(typeof data[i] !== 'undefined'){
                    formObj[i].value = data[i];
                }
            }
            return formObj;
        },

        makeRequest: makeRequest
    };

    model.setParams = function(ResourceObj, inputKeys, params){
        var listItem = new ResourceObj();
        if(params == null) return listItem;
        for(var i in inputKeys){
            var key = inputKeys[i];
            if(key in params){
                listItem[key] = params[key];
            }else{
                listItem[key] = null;
            }
        }
        return listItem;
    };

    model.niceUrl = function(str) {
        str= str.toLowerCase();
        str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
        str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
        str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
        str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
        str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
        str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
        str= str.replace(/đ/g,"d");
        str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
        /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
        str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-
        str= str.replace(/^\-+|\-+$/g,"");
        //cắt bỏ ký tự - ở đầu và cuối chuỗi
        return str;
    };

    model.getTransKey = function(str){
        // str = str.replace(STR_DELIMITER, 'x');
        var strArray = str.split(STR_DELIMITER);
        str = strArray.join('x');
        return model.niceUrl(str);
    };

    model.index = function(obj, i){
        if(typeof obj !== 'object') return {};
        return obj[i];
    };

    model.dotNotation = function(input, obj){
        return input.split('.').reduce(model.index, obj);
    };

    model.translateReplace = function(input, param1, param2, param3, param4, param5){
        param1 = typeof param1 === 'undefined' ? '' : param1;
        param2 = typeof param2 === 'undefined' ? '' : param2;
        param3 = typeof param3 === 'undefined' ? '' : param3;
        param4 = typeof param4 === 'undefined' ? '' : param4;
        param5 = typeof param5 === 'undefined' ? '' : param5;

        var paramsArray = [];
        if(param1 != '') paramsArray.push(param1);
        if(param2 != '') paramsArray.push(param2);
        if(param3 != '') paramsArray.push(param3);
        if(param4 != '') paramsArray.push(param4);
        if(param5 != '') paramsArray.push(param5);
        if(input){
            if(param1 === '' && param2 === '' && param3 === '' & param4 === '' && param5 === ''){
                // No replace
                return input;
            }else{
                // Must to replace
                for(var i in paramsArray){
                    input = input.replace(STR_DELIMITER, paramsArray[i])
                }
                return input;
            }
        }
        return '';
    };

    model.translate = function(input, param1, param2, param3, param4, param5){
        if(typeof input === 'object'){
            for(var i in input){
                input[i] = input[i].replace(/\./gi, '_');
            }
            input = input.join('.');
        }else if(typeof input === 'string'){
            input = input;
        }else{
            return '';
        }
        return model.translateReplace(model.dotNotation(input, w[$rootScope.lang]), param1, param2, param3, param4, param5);
    };

    model.getListTranslate = function(stateName){
        stateName = typeof stateName !== 'undefined' ? stateName.replace(/\./gi, '_') : 'blank';
        if(!$rootScope.lang) $rootScope.lang = 'vi';
        var globalTrans = w[$rootScope.lang]['global'];
        var currentTrans = w[$rootScope.lang][stateName];
        for(var i in globalTrans){
            currentTrans[i] = globalTrans[i]
        }
        return currentTrans;
    };

    model.generateQr = function(destination, text, size){
        size = size || 128;
        var qrcode = new QRCode(destination, {
            text: text,
            width: size,
            height: size,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
        // qrcode.clear(); // clear the code.
        // qrcode.makeCode("http://naver.com"); // make another code.
    };

    model.checkLanguageEnable = function(language){
        $rootScope.langEnable = {};
        $rootScope.langEnable[$rootScope.lang] = true;
    };

    model.getCurrentUrl = function(){
        var currentUrl = document.URL;
        var currentUrlArr = currentUrl.split('#');
        currentUrlArr.pop();
        currentUrl = currentUrlArr.join('#');
        return currentUrl;
    };

    model.formData = function(form){
        var result = {};
        form = form.fields;
        for(var i in form){
            result[i] = form[i].value;
        }
        return result;
    };

    model.firstKey = function(obj){
        for (var firstKey in  obj) break;
        return firstKey;
    };

    model.focusFirst = function(obj, formName){
        console.log('form[name="' + formName + '"] #' + ' input[name="' + model.firstKey(obj) + '"]');
        $('form[name="' + formName + '"] #' + ' input[name="' + model.firstKey(obj) + '"]').focus();
    };

    model.toggleModal = function(form, formName, isOpen){
        isOpen = typeof isOpen == 'undefined' ? true : isOpen;
        var modal = $('form[name="' + formName + '"]').parent('.modal');
        if(isOpen){
            modal.modal('show');
            /*
            modal.on('shown.bs.modal', function () {
                firstInput.focus();
            });
            */
        }else{
            modal.modal('hide');
        }
    };

    model.getIndexFromId = function(inputList, id){
        for (var i in inputList){
            var item = inputList[i];
            if(item.id == id){
                return i;
            }
        }
        return null;
    };

    model.objToSelectize = function(input, key, value, order){
        key = typeof key == 'undefined' ? 'id' : key;
        value = typeof value == 'undefined' ? 'title' : value;
        order = typeof order == 'undefined' ? key : order;
        var result = [];
        var inputType = typeof input;
        if(inputType == 'string') return {};
        inputType = Array.isArray(input) ? 'array' : 'object';
        var counter = 0;
        for(var i in input){
            var item = input[i];
            if(inputType == 'object'){
                console.log('case 1');
                var selectizeItem = {
                    id: i,
                    title: item,
                    order: i,
                }
            }else if(inputType == 'array'){
                var selectizeItem = {
                    id: item[key],
                    title: item[value],
                    order: item[order],
                }
            }else{
                return [];
            }
            if(!model.isnum(selectizeItem.order)){
                selectizeItem.order = counter;
            }
            result.push(selectizeItem);
            counter++;
        }
        return result;
    };

    model.selectizeSort = function(input, key){
        key = typeof key == 'undefined' ? 'order' : key;
        if(!input) return [];
        return input.sort(function(a, b) { return parseInt(a[key]) - parseInt(b[key]) } );
    };

    model.selectizeDefaultConf = {
        // optgroups = typeof optgroups == 'undefined' ? null : optgroups;
        maxItems : 1,
        valueField: 'id',
        labelField: 'title',
        searchField : ['id', 'title', 'uid'],
        sortField: [{field: 'order', direction: 'asc'}],
        delimiter: '|',
        /*
        optgroups: [
            {value: 'group1', title: 'Group 1'},
            {value: 'group2', title: 'Group 2'},
        ],
        */
        optgroupField: 'group',
        render: {
            optgroup_header: function(data, escape){
                return '<div class="optgroup-header"><strong>' + escape(data.title) + '</strong></div>';
            }
        }
    };

    model.selectizeUidConf = {
        // optgroups = typeof optgroups == 'undefined' ? null : optgroups;
        maxItems : 1,
        valueField: 'id',
        labelField: 'title',
        searchField : ['id', 'title', 'uid'],
        sortField: [{field: 'order', direction: 'asc'}],
        delimiter: '|',
        /*
        optgroups: [
            {value: 'group1', title: 'Group 1'},
            {value: 'group2', title: 'Group 2'},
        ],
        */
        optgroupField: 'group',
        render: {
            item: function(data, escape){
                if(data.hasOwnProperty('uid')){
                    var result = '<div>' + data.uid + ': ' + data.title + '</div>';
                }else{
                    var result = '<div>' +  data.title + '</div>';
                }
                return result;
            },
            option: function(data, escape){
                if(data.hasOwnProperty('uid')){
                    var result = '<div>' + data.uid + ': ' + data.title + '</div>';
                }else{
                    var result = '<div>' +  data.title + '</div>';
                }
                return result;
            },
            optgroup_header: function(data, escape){
                return '<div class="optgroup-header"><strong>' + escape(data.title) + '</strong></div>';
            }
        }
    };

    model.isnum = function(input){
        return $.isNumeric(input);
    };


    return model;
}]);

}(window));
