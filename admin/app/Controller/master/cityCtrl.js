app.controller('cityCtrl', function($scope, $rootScope, $routeParams,
		$location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked = !$scope.addNewClicked;

	$scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [])
			.withOption('responsive', true);

	$scope.init = function() {
		$scope.getCity();
	};

	$scope.addCity = function(city) {
		//alert(JSON.stringify(city));return;
		Data.post('Master/addCity', city).then(function(results) {
			//alert(JSON.stringify(results));
			Data.toast(results);
			if (results.status == "success") {
				$scope.city.push(results.newCity);
				$scope.addNewClicked = false;
				$scope.newCity = {
					name : '',
					country_id : '',
					state_id : '',
					isActive : true
				};
			}
		});

	}
	$scope.getCity = function() {

		Data.get('Master/getCity', {}).then(function(results) {
			//alert(JSON.stringify(results));
			$scope.city = results.city;
			$scope.Country = results.Country;
			$scope.city.selected = {
				name : '',
				country_id : '',
				state_id : '',
				isActive : ''
			};
			;
		});
	};

	$scope.getCityTemplate = function(contact) {

		if (contact.id === $scope.city.selected.id)
			return 'editCity';
		else
			return 'displayCity';
	};

	$scope.editCity = function(contact) {
		$scope.progress = 0;

		$scope.city.selected = angular.copy(contact);
	};

	$scope.saveEditCity = function(idx, editCity) {
		//alert(JSON.stringify(editCity));return;
		Data.post('Master/updateCity', editCity).then(function(results) {
			Data.toast(results);
			if (results.status == "success") {
				//$scope.city[idx] = angular.copy($scope.city.selected);
				$scope.city[idx] = results.city;
				$scope.reset();
			}
		});
	};

	$scope.reset = function() {
		$scope.city.selected = {};
	};

	$scope.init();

});
