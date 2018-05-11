app.controller('calendarCtrl',	function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout, DTOptionsBuilder, DTColumnBuilder, $compile,uiCalendarConfig) {
    //initially set those objects to null to avoid undefined error
  //  alert("calendarCtrl");
  	var columnDefs = [{ className: 'control', orderable: false, targets: -1 }];
      $scope.dtOptions = DTOptionsBuilder.newOptions()
    .withOption('order', [1, 'asc'])
    .withOption('columnDefs', columnDefs)
     .withOption('bInfo', false)
//        .withPaginationType('full_numbers')
        // Active Responsive plugin
        .withOption('responsive', true);
    
        $scope.init = function()
        {
        	$scope.events = [];
			$scope.getevents();
			
            /* event sources array*/
            $scope.eventSources = [$scope.events];
            //$scope.eventSources = [$scope.calEventsExt, $scope.eventsF, $scope.events];
            //$scope.eventSources.push($scope.events);
        };

        $scope.getevents = function() {
			Data.get('Schedule/getScheduleEventByUser', {})
					.then(function(results) {
						//alert(JSON.stringify(results));
						var accepted = results.Accepted;
						 for(var i = 0; i < accepted.length; i++)
						{
						   
							$scope.events[i] = { 
													title: " - T"+accepted[i].id+" - "+accepted[i].title,
													start: new Date(accepted[i].start), 
												//	end: new Date(accepted[i].end),
													color : accepted[i].color,
												      stick:true ,
												     // description :  "T"+accepted[i].id+" - Title :"+ accepted[i].title+" - Start : "+ new Date(accepted[i].start).toLocaleTimeString() +" - End : "+new Date(accepted[i].end).toLocaleTimeString()
                                                   description :    "<table><tr><td  width=70px>Request ID</td><td width=5px>:</td><td>"+ accepted[i].id+"</td><tr><td>Title</td><td>:</td><td>"+ accepted[i].title+"</td></tr><tr><td>Start</td><td> : </td><td>"+ new Date(accepted[i].start).toLocaleTimeString() +"</td></tr> <tr><td> End</td><td> :</td><td> "+new Date(accepted[i].end).toLocaleTimeString()+"</td></tr></table>"
													};
						}
						//$scope.events = results;
						 $scope.pendingList = results.Pending;
					});
		};
		
		$scope.approveAppointment = function(id, status)
		{
			Data.post('Schedule/approveAppointment', {id:id, status:status})
			.then(function(results) {
				Data.toast(results);
				if (results.status == "success") {
					$scope.pendingList = results.Pending;
					$scope.getevents();
				}
			});
		};
    
   

    /* alert on eventClick */
    $scope.alertOnEventClick = function( date, jsEvent, view){
        $scope.alertMessage = (date.title + ' was clicked ');
    };
    /* alert on Drop */
     $scope.alertOnDrop = function(event, delta, revertFunc, jsEvent, ui, view){
       $scope.alertMessage = ('Event Droped to make dayDelta ' + delta);
    };
    /* alert on Resize */
    $scope.alertOnResize = function(event, delta, revertFunc, jsEvent, ui, view ){
       $scope.alertMessage = ('Event Resized to make dayDelta ' + delta);
    };
    /* add and removes an event source of choice */
   
    /* Change View */
    $scope.changeView = function(view,calendar) {
    	
      uiCalendarConfig.calendars[calendar].fullCalendar('changeView',view);
    };
    /* Change View */
    $scope.renderCalender = function(calendar) {
      if(uiCalendarConfig.calendars[calendar]){
    	  uiCalendarConfig.calendars['calendar'].fullCalendar('rerenderEvents');
        uiCalendarConfig.calendars[calendar].fullCalendar('render');
      }
    };
     /* Render Tooltip */
    $scope.eventRender = function( event, element, view ) { 
         $(element).tooltip({title: event.description, html:true});
       /* element.attr({'tooltip': event.title,
                     'tooltip-append-to-body': true});
        $compile(element)($scope);*/
    };
    /* config object */
    $scope.uiConfig = {
      calendar:{
    	  height: "auto",
          //editable: true,
         // timezone: "America/Los_Angeles",
         //timezone: "Asia/kolkata",
         timezone:false ,
         //  locale: 'fr',
        header : {
			left : 'prev,next today',
			center : 'title',
			right : 'month,basicWeek,basicDay'		},
        eventClick: $scope.alertOnEventClick,
        eventDrop: $scope.alertOnDrop,
        eventResize: $scope.alertOnResize,
        eventRender: $scope.eventRender,
      
       /* dayClick: function() {
            alert('a day has been clicked!');
        }*/
      }
    };

   
    $scope.init();
 
});