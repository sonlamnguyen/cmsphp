'use strict';

/* App Module */

var App = angular.module("App", [
                        'ngSanitize',
                        'ngResource',
                        'ngMaterial',
                        'ngMessages',
                        'selectize',
                        'infinite-scroll',
                        'LocalStorageModule',
                        'toastr',
                        'CUtils',
                        'FormHelpers',
                        'CommonFilters',
                        'CommonFilters',
                        'UserService',
                        'AreaService',
                        'DeviceService',
                        'SceneService'
]);

App.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{$').endSymbol('$}');
});

App.run(function($rootScope){
    var baseUrl = $("title").attr("data-base-url");
    $rootScope.BASE_URL = baseUrl;
    $rootScope.STATIC_URL = baseUrl + 'static/';
    $rootScope.MEDIA_URL = baseUrl + 'media/';
    $rootScope.loadingImage = $rootScope.staticUrl+"img/loading-line.gif";
    $rootScope.defaultThumbnail = $rootScope.staticUrl+"img/default-thumbnail.jpg";

    $rootScope.FORM_ERROR_EVENT = 'FORM_ERROR_EVENT';
    $.fn.bootstrapSwitch.defaults.size = 'large';
});