angular.module('app.services')
.service('client', ['$resource', 'appConfig', function($resource, appConfig){
	//console.log(appConfig.baseUrl);
	//return [];
	return $resource(appConfig.baseUrl + '/client/:id', {id: '@id'}, {
		update: {
			method: 'PUT'
		}
	});
}]);