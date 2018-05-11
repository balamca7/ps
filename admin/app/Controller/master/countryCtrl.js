app.controller('countryCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getCountry();
      };
      
      
      $scope.addCountry = function(country){
        	Data.post('Master/addCountry', country).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
        		if(results.status == "success")
        		{
            	$scope.country.push(results.newCountry);
            	$scope.addNewClicked = false; 
            	$scope.newCountry = {name:'', isActive:true};
        		}
                });

    	  
      }
  	$scope.getCountry = function(){

      	Data.get('Master/getCountry', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.country = results;
              	$scope.country.selected = {name:'', isActive:''};;
                  });
      };

		    $scope.getCountryTemplate = function (contact) {
		    	
		        if (contact.id === $scope.country.selected.id) return 'editCountry';
		        else return 'displayCountry';
		    };

		    $scope.editCountry = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.country.selected = angular.copy(contact);
		    };

		    $scope.saveEditCountry = function (idx, editCountry) {
	        	Data.post('Master/updateCountry', editCountry).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	   
	        			$scope.country[idx] = angular.copy($scope.country.selected);
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.country.selected = {};
		    };

		      $scope.init();

});

