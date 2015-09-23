var app = angular.module('app',[
	'ngRoute', 'angular-oauth2', 'app.controllers', 'app.services', 'app.filters',
	'ui.bootstrap.typeahead', 'ui.bootstrap.datepicker', 'ui.bootstrap.tpls'
]);

angular.module('app.controllers',['ngMessages', 'angular-oauth2']);

angular.module('app.services',['ngResource']);

angular.module('app.filters',[]);

app.provider('appConfig', ['$httpParamSerializerProvider', function($httpParamSerializerProvider){
	var config = {
		baseUrl: 'http://localhost:8000',
		project:{
			status: [
				{value: 1, label: 'Não iniciado'},
				{value: 2, label: 'Iniciado'},
				{value: 3, label: 'Concluído'}
			]
		},
		utils:{
			transformRequest: function(data){
				if(angular.isObject(data)){
					return $httpParamSerializerProvider.$get()(data);
				}
				return data;
			},
			transformResponse: function(data, headers){
				var headersGetter = headers();
				//console.log(data);
				//console.log(headers);

				if(headersGetter['content-type'] == 'application/json' ||
					headersGetter['content-type'] == 'text/json'){

					var dataJson = JSON.parse(data);
					if(dataJson.hasOwnProperty('data')){
						dataJson = dataJson.data;
					}
					return dataJson;
				}

				return data;
			}
		}
	};

	return {
		config: config,
		$get: function(){
			return config;
		}
	}
}]);

app.config([
	'$routeProvider', '$httpProvider', 'OAuthProvider',
	'OAuthTokenProvider', 'appConfigProvider',
	function(
		$routeProvider, $httpProvider, OAuthProvider,
		OAuthTokenProvider, appConfigProvider){

		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
		$httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

	$httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

	$httpProvider.defaults.transformRequest = appConfigProvider.config.utils.transformRequest;

	$routeProvider
		.when('/login',{
			templateUrl: 'build/views/login.html',
			controller: 'LoginController'
		})
		.when('/home',{
			templateUrl: 'build/views/home.html',
			controller: 'HomeController'
		})


		.when('/clients',{
			templateUrl: 'build/views/client/list.html',
			controller: 'ClientListController'
		})
		.when('/clients/new',{
			templateUrl: 'build/views/client/new.html',
			controller: 'ClientNewController'
		})
		.when('/clients/:id/edit',{
			templateUrl: 'build/views/client/edit.html',
			controller: 'ClientEditController'
		})
		.when('/clients/:id/remove',{
			templateUrl: 'build/views/client/remove.html',
			controller: 'ClientRemoveController'
		})

		.when('/project/:id/notes',{
			templateUrl: 'build/views/project-note/list.html',
			controller: 'ProjectNoteListController'
		})
		.when('/project/:id/notes/:idNote/show',{
			templateUrl: 'build/views/project-note/show.html',
			controller: 'ProjectNoteShowController'
		})
		.when('/project/:id/notes/new',{
			templateUrl: 'build/views/project-note/new.html',
			controller: 'ProjectNoteNewController'
		})
		.when('/project/:id/notes/:idNote/edit',{
			templateUrl: 'build/views/project-note/edit.html',
			controller: 'ProjectNoteEditController'
		})
		.when('/project/:id/notes/:idNote/remove',{
			templateUrl: 'build/views/project-note/remove.html',
			controller: 'ProjectNoteRemoveController'
		})
		;

	OAuthProvider.configure({
		baseUrl: appConfigProvider.config.baseUrl,
		clientId: 'app',
		clientSecret: 'secret', // optional
		grantPath: 'oauth/access_token'
	});

	OAuthTokenProvider.configure({
      name: 'token',
      options: {
        secure: false
      }
    });
}]);



app.run(['$rootScope', '$window', 'OAuth', function($rootScope, $window, OAuth) {

    $rootScope.$on('oauth:error', function(event, rejection) {

      if ('invalid_grant' === rejection.data.error) {
        return;
      }

      if ('invalid_token' === rejection.data.error) {
        return OAuth.getRefreshToken();
      }

      return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
  }]);