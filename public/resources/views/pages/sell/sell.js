'use strict';

angular.module('myApp.sell', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/sell', {
    templateUrl: 'pages/sell/sell.html',
    controller: 'SellCtrl'
  });
}])

.controller('SellCtrl', [function() {

}]);