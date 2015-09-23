angular.module('app.controllers')
	.controller('ClientListController', ['$scope', 'client', function($scope, Client){
		$scope.clients = Client.query();
}]);