angular.module('app.services')
.service('ProjectNote', ['$resource', 'appConfig', function($resource, appConfig){
	//console.log(appConfig.baseUrl);
	//return [];
	return $resource(appConfig.baseUrl + '/project/:id/note/:idNote', {
			id: '@id',
			idNote: '@idNote',
		}, {
			update: {
				method: 'PUT'
			}

		});
}]);