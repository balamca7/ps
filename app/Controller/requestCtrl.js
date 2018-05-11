app.controller('requestCtrl',	function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder, $compile,uiCalendarConfig) {
    //initially set those objects to null to avoid undefined error
   // alert("calendarCtrl");
   	var columnDefs = [{ className: 'control', orderable: false, targets: -1 }];
      $scope.dtOptions = DTOptionsBuilder.newOptions()
    .withOption('order', [0, 'asc'])
    .withOption('columnDefs', columnDefs)
     .withOption('bInfo', false)
   
//        .withPaginationType('full_numbers')
        // Active Responsive plugin
        .withOption('responsive', true);
     // var date = new Date();
     // var d = date.getDate();
     // var m = date.getMonth();
     // var y = date.getFullYear();
        $scope.init = function()
        {
        	$scope.events = [];
			$scope.getevents();
			
            /* event sources array*/
           // $scope.eventSources = [$scope.events, $scope.eventSource, $scope.eventsF];
            //$scope.eventSources = [$scope.calEventsExt, $scope.eventsF, $scope.events];
            //$scope.eventSources.push($scope.events);
        };

        $scope.getevents = function() {
             $scope.pendingList = [];
			Data.get('Schedule/getRequestSchedule', {})
					.then(function(results) {
						//alert(JSON.stringify(results));
						var accepted = results.Accepted;
						 for(var i = 0; i < accepted.length; i++)
						{
							$scope.events[i] = { 
													title: accepted[i].title,
													start: new Date(accepted[i].start), 
													end: new Date(accepted[i].end),
													
												      stick:true 
													};
						}
						// alert(JSON.stringify($scope.events));
						//$scope.events = results;
						 $scope.pendingList = results.Pending;
					});
		};
		
		
 $scope.editstatus = function (value,id, idx){
      //alert(JSON.stringify(value));
       // $scope.getevents();
       // alert(JSON.stringify(id));
       
   	Data.post('Schedule/updatestatus', {value : value, id:id} 
       ).then(function (results) {

        //	alert(JSON.stringify(results));
        if(value==0)
        {
             $scope.pendingList.splice(idx, 1);  
           
        }
        else
        {
            $scope.pendingList[idx].status = results.status;
            
        }
   // $scope.getevents();
       	    	//$location.path('/home/myrequest');
    
    }
 )
    
 };

	$scope.init();
				});
