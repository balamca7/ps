app
		.controller(
				'scheduleCtrl',
				function($scope, $filter, $rootScope, $routeParams, $location,
						$http, ngDialog, Data, $interval, $compile) {
					// initially set those objects to null to avoid undefined
					// error
					// alert("scheduleCtrl");
					var tutor_userid = $routeParams.id;
					var date = new Date();
					var d = date.getDate();
					var m = date.getMonth();
					var y = date.getFullYear();
					$scope.init = function() {
						$scope.events = [];
						$scope.getevents();
						//$scope.eventSources = [$scope.events,$scope.eventSource, $scope.eventsF];
											
						$scope.eventSources = [$scope.events];
						$scope.schdReq = {
							"tutor_name" : tutor_userid,
							//"title" : "Appointment 1",
							//"req_date" : "08/23/2017",
							//"start_time" : "09:00",
							"location":""
									
						};
						 $scope.schdeuleList = [];
						
					};
					
					/* event source that contains custom events on the scope */
					$scope.getevents = function() {
						Data.post('Schedule/getScheduleEvent', {tutor_userid : tutor_userid})
								.then(function(results) {
									//alert(JSON.stringify(results));
									
									 for(var i = 0; i < results.length; i++)
									{
										$scope.events[i] = { 
    										    	title: " - T"+results[i].id+" - "+results[i].title,
													start: new Date(results[i].start), 
												//	end: new Date(results[i].end),
													color : results[i].color,
												      stick:true ,
												      //description :  "T"+results[i].id+" - Title :"+ results[i].title+" - Start : "+ new Date(results[i].start).toLocaleTimeString() +" - End : "+new Date(results[i].end).toLocaleTimeString()
													    description :    "<table><tr><td  width=70px>Request ID</td><td width=5px>:</td><td>"+ results[i].id+"</td><tr><td>Title</td><td>:</td><td>"+ results[i].title+"</td></tr><tr><td>Start</td><td> : </td><td>"+ new Date(results[i].start).toLocaleTimeString() +"</td></tr> <tr><td> End</td><td> :</td><td> "+new Date(results[i].end).toLocaleTimeString()+"</td></tr></table>"		 
																};
									}
									
									//$scope.events = results;
									
								});
					};



 



			

					/* alert on eventClick */
					$scope.alertOnEventClick = function(date, jsEvent, view) {
						$scope.alertMessage = (date.title + ' was clicked ');
					};
					/* Change View */
					$scope.renderCalender = function(calendar) {
						if (uiCalendarConfig.calendars[calendar]) {
							uiCalendarConfig.calendars[calendar]
									.fullCalendar('render');
						}
					};
					/* Render Tooltip */
					$scope.eventRender = function(event, element, view) {
					 $(element).tooltip({title: event.description, html:true});
					};
					$scope.uiConfig = {
						calendar : {
							height : 450,
							editable : true,
							timezone : "America/Los_Angeles",
							header : {
								left : 'prev,next today',
								center : 'title',
								right : 'month,basicWeek,basicDay'
							},
							/*
							 * header:{ left: 'title', center: '', right: 'today
							 * prev,next' },
							 */
							eventClick : $scope.alertOnEventClick,
							eventDrop : $scope.alertOnDrop,
							eventResize : $scope.alertOnResize,
							eventRender : $scope.eventRender,
							/*dayClick : function(date, jsEvent, view) {
								$(this).css('cursor', 'hand');
								var d = new Date(date.format())
								if (!isDateValid(d)) {

									var curr_date = d.getDate();
									var curr_month = d.getMonth() + 1; // Months
																		// are
																		// zero
																		// based
									var curr_year = d.getFullYear();
									// var date = curr_date + "-" + curr_month +
									// "-" + curr_year;
									var datestring = ("0" + (d.getMonth() + 1))
											.slice(-2)
											+ "/"
											+ ("0" + d.getDate()).slice(-2)
											+ "/" + d.getFullYear();
									// alert(date + ' was clicked ');
									$scope.schdReq = {
										"tutor_name" : tutor_userid,
										"req_date" : datestring,
										"location":""
									};
									// $scope.schdReq = datestring;
									// $(!this).css('background-color',
									// 'white');
									// $(this).css('background-color', 'red');

								} else {
									alert("Not allowed to schedule the appointment")
								}

							}*/
						}
					};

					var isDateValid = function(dateTime) {
						// return $scope.model != null && $scope.model.date !=
						// null && $scope.model.date !== '';

						if (dateTime === null)
							return false;
						var day = dateTime.getDate();
						var month = dateTime.getMonth();
						var year = dateTime.getFullYear();
						var composedDate = new Date();
						return composedDate.getDate() >= day
								&& composedDate.getMonth() >= month
								&& composedDate.getFullYear() >= year;

					};
					$scope.getEndTime = function(req_date, start_time,
							no_of_hour) {
						var date = req_date + " " + start_time;
					  // var d =$filter('date')(new Date(date), 'yyyy/MM/dd');
						var d = new Date(date);
						sethour = d.getHours() + (no_of_hour * 1);
						var dd = d.setHours(sethour);
						$scope.schdReq.end_time = $filter('date')(new Date(dd),
								'HH:mm');
					};
					

					$scope.addSchedule = function(schdData) {

						var len = $scope.schdeuleList.length;
						if (len == 0) {
							$scope.schdeuleList.push(schdData);
							$scope.schdReq = {
								"tutor_name" : tutor_userid,
								"location":""
							};
							$scope.test = false;
						}
						else if(len >2)
						{
							alert("Max 3 schedule only allowed.=====");
							return;
						} else {
							angular
									.forEach(
											$scope.schdeuleList,
											function(value, key) {
												if (value.req_date == schdData.req_date
														&& (value.start_time == schdData.start_time || value.end_time == schdData.end_time)) {
													alert("Already added");
													return;
													// $scope.schdeuleList.splice(key,1);
												} else {
													if (len < 3) {
														$scope.schdeuleList
																.push(schdData);
														$scope.schdReq = {
															"tutor_name" : tutor_userid,
															"location" : ""
														};
														$scope.test = false;
													} else {
														alert("Max 3 schedule only allowed.+++");
														return;
													}
												}
											});
						}

						
					};

					$scope.remove = function(index) {
						$scope.schdeuleList.splice(index, 1);
						//delete $scope.schdeuleList[index];
					}
					$scope.submitSchedule = function(schdeuleList) {
						//alert(JSON.stringify(schdeuleList));
						Data.post('Schedule/submitSchedule', schdeuleList)
								.then(function(results) {
									//alert(JSON.stringify(results));
									Data.toast(results);
									if (results.status == "success") {
										$scope.schdeuleList = [];
										$location.path('/home/myrequest');
									}
								});
					};

					$scope.init();
				});