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
var ctrlName = 'Toolbar';
angular.module('App')
.controller(ctrlName,
['$scope', '$rootScope', '$timeout', '$mdSidenav', '$mdUtil','CUtils',
function($scope, $rootScope, $timeout, $mdSidenav, $mdUtil, CUtils){
    var vm = this; // jshint ignore:line

    vm.toggle = buildToggler('mainNavBar');
    /**
     * Build handler to open/close a SideNav; when animation finishes
     * report completion in console
     */
    function buildToggler(navID) {
      var debounceFn = $mdUtil.debounce(function(){
            $mdSidenav(navID)
              .toggle()
              .then(function () {
                //Something here
              });
          },200);
      return debounceFn;
    }

    vm.onNavSideItemClick = function(event){
        // Nothing
    }

}]);
}(window));