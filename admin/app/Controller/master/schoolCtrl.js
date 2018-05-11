app.controller('schoolCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getSchool();
        
      };
      
      
      $scope.addSchool = function(school){
    	  //alert(JSON.stringify(school));return;
        	Data.post('educationMaster/addSchool', school).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
        		if(results.status == "success")
        		{
	            	$scope.school.push(results.newSchool);
	            	$scope.addNewClicked = false; 
	            	$scope.newSchool = {name:'', country_id:'', state_id:'', city_id :'', county_id:'', district_id : '', isActive:true};
	        	}
            });

    	  
      }

	    $scope.changeCountry = function(status)
	    {
	    	//alert(status);
	    	if(status == "country")
	    	$scope.school.selected.state_id = undefined;
	    	else if(status == "state")
		    {
	    		
	    		$scope.school.selected.city_id = undefined;
	    		$scope.school.selected.county_id = undefined;
	    		$scope.school.selected.district_id = undefined;
		    }

	    }
	    
      $scope.getCityCountyDistrict = function(state_id, status)
      {
    	  Data.post('educationMaster/getCityCountyDistrict', {
    		  state_id: state_id
    	        }).then(function (results) {
    	        	$scope.city = results.city;
    	        	$scope.county = results.county;
    	        	$scope.district = results.district;
    	        	if(!status)
    	        	$scope.changeCountry('state');
    	        });
      };
  	$scope.getSchool = function(){

      	Data.get('educationMaster/getSchool', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.school = results.school;
              	$scope.Country = results.Country;
              	$scope.school.selected = {name:'', country_id:'', state_id:'', city_id :'', county_id:'', district_id : '', isActive:true};
                  });
      };

		    $scope.getSchoolTemplate = function (contact) {
		    	
		        if (contact.id === $scope.school.selected.id) return 'editSchool';
		        else return 'displaySchool';
		    };

		    $scope.editSchool = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.school.selected = angular.copy(contact);
		        $scope.getCityCountyDistrict($scope.school.selected.state_id, 1);
		    };

		    $scope.saveEditSchool = function (idx, editSchool) {
		    	//alert(JSON.stringify(editSchool));return;
	        	Data.post('educationMaster/updateSchool', editSchool).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	        			//$scope.school[idx] = angular.copy($scope.school.selected);
	        			$scope.school[idx] = results.school;
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.school.selected = {};
		    };
		    

		      $scope.init();

});

