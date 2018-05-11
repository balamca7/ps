app.controller('dashboardCtrl',	function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder) {
    //initially set those objects to null to avoid undefined error
    //alert("dashboradCtrl");
    var type = (($routeParams.type === undefined) ? '' : $routeParams.type) ;
    var type_val = (($routeParams.type_val === undefined) ? '' : $routeParams.type_val);
   //alert($location.path());
   if($location.path() == '/home/dashboard')
   {
        $scope.dtOptions = DTOptionsBuilder.newOptions()
    .withOption('order', [4, 'desc'])
    
//        .withPaginationType('full_numbers')
        // Active Responsive plugin
        .withOption('responsive', true);
   }
   else if($location.path() == 'home/resources')
   {
        $scope.dtOptions = DTOptionsBuilder.newOptions()
    .withOption('order', [1, 'asc'])
//        .withPaginationType('full_numbers')
        // Active Responsive plugin
        .withOption('responsive', true);
   }
     

        $scope.init = function()
        {
             // $scope.getDashboard();
            $scope.getDashboard(type, type_val);
          	$scope.getResources();
        };
    
    	$scope.getDashboard = function(type, type_val){
                 //	alert(JSON.stringify(type));
        	Data.post('Dashboard/dashboard', {'type' : type, 'type_val' : type_val
                }).then(function (results) {
                	//alert(JSON.stringify(results));
                	$scope.Dashboard = results.DashboardInfo;
                    });
        };
     
        
        
    	$scope.getResources = function(){
        	Data.get('Dashboard/resources', {
                }).then(function (results) {
                //	alert(JSON.stringify(results));
                	$scope.Resources = results;
                    });
        };


        $scope.init();
});