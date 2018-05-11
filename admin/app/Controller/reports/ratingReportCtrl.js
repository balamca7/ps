app.controller('ratingReportCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder,Excel) {
	$scope.addNewClicked=!$scope.addNewClicked;
	
	  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
    	   $scope.ratingReports();
      };
      
      $scope.exportToExcel=function(tableId){ // ex: '#my-table'
          var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
          $timeout(function(){location.href=exportHref;},100); // trigger download
      };
     
  	$scope.ratingReports = function(){

      	Data.get('reports/getoverallRating', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.ratingReports = results;
              	
                  });
      };

		
		      $scope.init();

});

