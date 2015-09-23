angular.module('app.controllers')
	.controller('ClientEditController',
	['$scope', '$location', '$routeParams', 'client',
		function($scope, $location, $routeParams, Client){
		$scope.client = Client.get({id: $routeParams.id});

		//console.log($scope.client);
		
		$scope.save = function(){

			if($scope.form.$valid){
				Client.update({id: $scope.client.id}, $scope.client, function(){
					$location.path('/clients');
				});
			}
		}
}]);