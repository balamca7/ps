app.controller('userReportCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder,Excel) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
    	  var date = new Date();
    	var currentDate = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear();
    	  $scope.monthYear = { "From" : currentDate, "To" : currentDate};
    	 /* $scope.monthYear = (date.getMonth()+1)+"/"+date.getFullYear();
    	  $scope.getUserPostReports($scope.monthYear);*/
        
      };
      
      
      $scope.getUserPostReports = function(monthYear){
    	  
        	Data.post('reports/getUserPostReports', {monthYear: monthYear
              }).then(function (results) {
              //alert(JSON.stringify(results));
              	$scope.UserPostReports = results;
              	
                  });

    	  
      }
  	$scope.getCategory = function(){

      	Data.get('subjectMaster/getCategory', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.category = results;
              	$scope.category.selected = {name:'', isActive:''};;
                  });
      };

		    $scope.getCategoryTemplate = function (contact) {
		    	
		        if (contact.id === $scope.category.selected.id) return 'editCategory';
		        else return 'displayCategory';
		    };

		    $scope.editCategory = function (contact) {
		    	$scope.progress = 0;
		    	
		        $scope.category.selected = angular.copy(contact);
		    };

		    $scope.saveEditCategory = function (idx, editCategory) {
	        	Data.post('subjectMaster/updateCategory', editCategory).then(function (results) {
	        		Data.toast(results);
	        		if(results.status == "success")
	        		{
	   
	        			$scope.category[idx] = angular.copy($scope.category.selected);
	        			$scope.reset();
	        		}
            	});
		    };
		    
		    $scope.exportToExcel=function(tableId){ 
		    	
		          var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
		          $timeout(function(){location.href=exportHref;},100); // trigger download
		      };

		    $scope.reset = function () {
		        $scope.category.selected = {};
		    };

		      $scope.init();
		      
		      
		    
});

