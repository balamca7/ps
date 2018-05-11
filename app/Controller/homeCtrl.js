app
		.controller(
				'homeCtrl',
				function($scope, $rootScope, $routeParams, $location, $http,
						Data, $interval, $localStorage) {
					// alert("homeCtrl");
					$scope.leftSidebarURL = 'partials/leftsidebar.html';
					$scope.beep = new Audio('dist/audio/beep.ogg');
					$scope.lastChatMessageId = null;
					$scope.pidMessages = null;

					$scope.init = function() {
						 $scope.displayChat=false;
						// $scope.getContacts();
						 //$scope.getGroupcontacts();
						//$scope.volunteerHoursStars();
                        // $scope.getQuestionNotifiy();
                        /* $rootScope.quesNotify = $interval(function() {
                                        $scope.getQuestionNotifiy()
        					}, 5000);
        					*/
					};

                                        $scope.getQuestionNotifiy = function(){

        	Data.get('Dashboard/getQuestionNotify', {
                }).then(function (results) {
                	//alert(JSON.stringify(results));
                	$scope.questionNotify = results.NotificationCount;
                	$scope.scheduleNotification = results.scheduleNotification;
                    });
        };

					$scope.chatUsers = function(sent_id) {
						
						$scope.displayChat = true;
						$scope.getChatMessage(sent_id);
					};

					$scope.getChatMessage = function(sent_id,
							wasListingForMySubmission) {
						if (sent_id != "" && sent_id != undefined) {
							Data
									.post('Chatcontroller/getChatMessage', {
										chatuserId : sent_id
									})
									.then(
											function(results) {
												// alert(JSON.stringify(results));
												$scope.allMessage = results;

												/*
												 * angular.element(document).ready(
												 * function () { var wtf =
												 * $(".div_Chat .box-body
												 * .direct-chat-messages"); var
												 * height = wtf[0].scrollHeight;
												 * wtf.scrollTop(height); });
												 */

												// $scope.allMessage.push(results);
												var chatmessages = document
														.querySelector(".div_Chat .box-body .direct-chat-messages");
												setTimeout(
														function() {
															chatmessages.scrollTop = chatmessages.scrollHeight;
														}, 10);
												// alert(JSON.stringify($scope.lastChatMessageId)+"==get1")
												var lastMessage = $scope
														.getLastChatMessage();
												var lastMessageId = lastMessage
														&& lastMessage.chat_id;
												// alert($scope.lastChatMessageId+"
												// !== "+lastMessageId)
												// $scope.playAudio();
												if ($scope.lastChatMessageId !== lastMessageId) {
													$scope
															.onNewMessage(wasListingForMySubmission);
												}
												$scope.lastChatMessageId = lastMessageId;
												// alert(JSON.stringify($scope.lastChatMessageId)+"==get2")
											});

						}
					};

					$scope.getLastChatMessage = function() {

						return $scope.allMessage.recMessage[$scope.allMessage.recMessage.length - 1];
					};

					$scope.playAudio = function() {
						$scope.beep && $scope.beep.play();
					};
					$scope.onNewMessage = function(wasListingForMySubmission) {
						// $scope.playAudio();
						// alert(wasListingForMySubmission
						// +"--"+$scope.lastChatMessageId);
						if ($scope.lastChatMessageId
								&& !wasListingForMySubmission) {
							$scope.playAudio();
							// $scope.pageTitleNotificator.on('New message');
							// $scope.notifyLastMessage();
						}
					};

					$scope.sendMessage = function(user_id, message) {

						if (message != "" && message != undefined) {
							Data
									.post('Chatcontroller/sentchatMessage', {
										userId : user_id,
										message : message
									})
									.then(
											function(results) {
												// alert(JSON.stringify(results));
												if (results.status == "success") {
													// alert(JSON.stringify(results.recMessage));
													$scope.allMessage.recMessage
															.push(results.recMessage);
													// alert(JSON.stringify($scope.lastChatMessageId)+"==send1")
													var lastMessage1 = results.recMessage;
													// alert(lastMessage1.chat_id);
													var lastMessageId1 = lastMessage1
															&& lastMessage1.chat_id;
													$scope.lastChatMessageId = lastMessageId1;
													// alert(JSON.stringify($scope.lastChatMessageId)+"==send2");

													// $scope.allMessage =
													// getChatMessage(user_id);
													$scope.allMessage.message = "";

													var chatmessages = document
															.querySelector(".div_Chat .box-body .direct-chat-messages");
													setTimeout(
															function() {
																chatmessages.scrollTop = chatmessages.scrollHeight;
															}, 10);

												}

											});
						}
					};

					$scope.chatInterval = $interval(function() {
						var sent_id = $(".div_Chat .box-title").html();
						if (sent_id != undefined && sent_id != "")
							$scope.getChatMessage(sent_id);

					}, 5000);
					// stops the interval
					$scope.volunteerHoursStars = function() {
						Data
								.get('Dashboard/getRatingVolunteerHours', {})
								.then(
										function(results) {
										 //alert(JSON.stringify(results));
											$scope.volunteerHours = results.volunteerHours;
											$scope.userRating = results.userRating;

										});
					};
					
					$scope.makeVideoCall = function(sent_id) {

						$('#income_call').modal('show');

					};

					// getMsgNotification();
					
					/*$scope.notifyInterval = $interval(function(){
					getMsgNotification(); }, 5000);
					*/
					function getMsgNotification() {
						Data.post('getMsgNotification', {}).then(
								function(results) {
									// alert(JSON.stringify(results)+"~~~~~~~~~~~");
									$scope.MsgNotification = results;
								});
					}

					$scope.chatInterval = $interval(function() {
						var sent_id = $(".div_Chat .box-title").html();
						if (sent_id != undefined && sent_id != "")
							getChatMessage(sent_id);

					}, 5000);
					// stops the interval

					/*
					 * $scope.scrollToBottom = function() { var
					 * uuid_last_message =
					 * _.last($scope.allMessage.recMessage).uuid;
					 * alert(uuid_last_message);
					 * $anchorScroll(uuid_last_message); };
					 * 
					 * $scope.autoScrollDown = true; var hasScrollReachedBottom =
					 * function() { return element.scrollTop() +
					 * element.innerHeight() >= element.prop('scrollHeight') };
					 * var watchScroll = function() { scope.autoScrollDown =
					 * hasScrollReachedBottom() }; var init = function() { // …
					 * element.bind("scroll", _.throttle(watchScroll, 250)); };
					 * $scope.listDidRender = function(){
					 * if($scope.autoScrollDown) $scope.scrollToBottom(); };
					 */

					$scope.changeChatModel = function() {
						$scope.displayChat = false;
						$interval.cancel($scope.chatInterval);
					}

					
					$scope.init();
				});