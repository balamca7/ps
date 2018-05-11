app.controller('tutorReportCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder,Excel) {
  $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);

      $scope.init = function()
      {
        $scope.getTutorreport();
      };
      
      
      $scope.tutorDetails = function(Tutortype){
    	  $scope.getTutordetails(Tutortype);
      	//$scope.modelInculdeFile = "templates/admin/reports/tutorDetails.html";
  		//$('#myModal').modal('show');
      };
  	$scope.getTutorreport = function(){

      	Data.get('reports/getTutorreport', {
              }).then(function (results) {
              	//alert(JSON.stringify(results));
              	$scope.category = results;
              	//$scope.category.selected = {label:'', Value:''};;
                  });
      };

		

		    $scope.reset = function () {
		        $scope.category.selected = {};
		    };
		    
		    $scope.exportToExcel=function(tableId){ // ex: '#my-table'
		          var exportHref=Excel.tableToExcel(tableId,'WireWorkbenchDataExport');
		          $timeout(function(){location.href=exportHref;},100); // trigger download
		      };
		    
		    $scope.getTutordetails = function(Tutortype){
		    	
		    	$scope.Tutordetails = [];
		    	 $scope.Tutortype = Tutortype.label;
		      	Data.post('reports/getTutorreportdetails', {"Tutortype" : Tutortype.id
		              }).then(function (results) {
		              	//alert(JSON.stringify(results));
		              	$scope.Tutordetails = results;
		              	$('#myModal').modal('show');
		              	//$scope.category.selected = {label:'', Value:''};;
		                  });
		      };

		      $scope.init();

});

