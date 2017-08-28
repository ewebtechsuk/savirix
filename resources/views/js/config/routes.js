angular
	.module('myApp')
	.config(['$routeProvider', 'config', function($routeProvider, config) {
	      $routeProvider.when('/property', {
	        templateUrl: '../resources/views/pages/property/list-property.html',
	        controller: 'PropertyCtrl'
	      });
	}])	
	.config(['$routeProvider', 'config', function($routeProvider, config) {
	      $routeProvider.when('/add-property', {
	        templateUrl: '../resources/views/pages/property/add-property.html',
	        controller: 'PropertyCtrl'
	      });
	}])	
	.config(['$routeProvider', 'config', function($routeProvider, config) {
	      $routeProvider.when('/edit-property/:property_id', {
	        templateUrl: '../resources/views/pages/property/add-property.html',
	        controller: 'PropertyCtrl'
	      });
	}])		
	.config(['$routeProvider', function($routeProvider) {
	  $routeProvider.when('/home', {
	    templateUrl: '../resources/views/pages/home/home.html',
	    controller: 'HomeCtrl'
	  });
	}])	