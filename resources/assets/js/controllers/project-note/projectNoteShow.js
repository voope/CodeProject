angular.module('app.controllers')
	.controller('ProjectNoteShowController',
	['$scope', '$location', '$routeParams', 'ProjectNote',
		function($scope, $location, $routeParams, ProjectNote){

			$scope.projectNote = ProjectNote.get({
				id: $routeParams.id,
				idNote: $routeParams.idNote
			});

			//console.log($scope.projectNote);
			//console.log($scope.projectNote);
			//console.log($routeParams.idNote);
			//console.log($routeParams.id);
			//console.log($scope.projectNote.id);

		}]);