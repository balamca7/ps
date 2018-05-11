app.controller('volunteerReportCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder,Excel) {
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
          $scope.getVolunteerhourReports($scope.monthYear);*/
      };
      
      
      $scope.exportToExcel=function(tableId){ // ex: '#my-table'
          var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
          $timeout(function(){location.href=exportHref;},100); // trigger download
      };
  	$scope.getVolunteerhourReports = function(monthYear){

      	Data.post('reports/getVolunteerhourReports', {monthYear: monthYear
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.volunteerhourReports = results;
              	
                  });
      };

		
		      $scope.init();

});

