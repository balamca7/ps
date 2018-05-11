app.controller('gradeCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getGrade();
      };
      
      
      $scope.addGrade = function(grade){
    	  
        	Data.post('subjectMaster/addGrade', grade).then(function (results) {
            	//alert(JSON.stringify(results));
        		Data.toast(results);
            	$scope.grade.push(results.newGrade);
            	$scope.addNewClicked = false; 
            	$scope.newGrade = {name:'', from:'', to:'', isActive:true};
                });

    	  
      }
  	$scope.getGrade = function(){

      	Data.get('subjectMaster/getGrades', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.grade = results;
              	$scope.grade.selected = {name:'', from: '', to:'', isActive:''};;
                  });
      };

		    $scope.getGradeTemplate = function (contact) {
		    	
		        if (contact.id === $scope.grade.selected.id) return 'editGrade';
		        else return 'displayGrade';
		    };

		    $scope.editGrade = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.grade.selected = angular.copy(contact);
		    };

		    $scope.saveEditGrade = function (idx, editGrade) {
		    	//alert(JSON.stringify(editGrade));
	        	Data.post('subjectMaster/updateGrade', editGrade).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	        			$scope.grade[idx] = angular.copy($scope.grade.selected);
	        			$scope.reset();
	        		}
            	});
		    };

		    $scope.reset = function () {
		        $scope.grade.selected = {};
		    };

		      $scope.init();

});

