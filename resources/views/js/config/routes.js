angular
	.module('myApp')
	.config(['$routeProvider', 'config', function($routeProvider, config) {
	      $routeProvider
			  .when('/property', {
	        		templateUrl: '../resources/views/pages/property/list-property.html',
	        		controller: 'PropertyCtrl'
	      		})
              .when('/add-property', {
                  templateUrl: '../resources/views/pages/property/add-property.html',
                  controller: 'PropertyCtrl'
              })
              .when('/edit-property/:property_id', {
                  templateUrl: '../resources/views/pages/property/add-property.html',
                  controller: 'PropertyCtrl'
              })
              .when('/edit-property/:property_id', {
                  templateUrl: '../resources/views/pages/property/add-property.html',
                  controller: 'PropertyCtrl'
              });
	}]);