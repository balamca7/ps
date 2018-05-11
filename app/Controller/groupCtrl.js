app
		.controller(
				'groupCtrl',
				function($scope, $rootScope, $routeParams, $location, $http,
						ngDialog, Data, $interval) {
					// initially set those objects to null to avoid undefined
					// error
					// alert("groupCtrl");
					var groupID = $routeParams.id;
					var usergroup = $routeParams.usergroup;
					//$scope.groups = getGroupProfile(groupID);
					 $scope.beep = new Audio('dist/audio/beep.ogg');
					 $scope.lastMessageId = null;
					 $scope.pidMessages = null;

					$scope.init = function() {
						$scope.getGroupProfile(groupID);
						$scope.getGroupMessage();
						// $scope.getGroupMessage();
	    				 $rootScope.groupMessages = $interval(function() {
							 $scope.getGroupMessage();
    					}, 5000);
					};

					$scope.getGroupProfile = function(groupID) {

						Data.post('Usergroup/groupProfile', {
							groupId : groupID
						}).then(function(results) {
							// alert(JSON.stringify(results));
							$scope.groups = {
								"groupInfo" : results
							};
						});
					}
					;

					// getGroupMessage(groupID);
					$scope.getGroupMessage = function(wasListingForMySubmission) {
						//alert(groupID);
						Data.post('Usergroup/getGroupMessage', {
									groupId : groupID
								})
								.then(
										function(results) {
											// alert(JSON.stringify(results));
											$scope.groups.Groupchat = results;
											// $scope.groups = {"groupInfo"
											// :results};
											 var lastMessage = $scope.getLastMessage();
								             var lastMessageId = lastMessage && lastMessage.chat_id;
								            // alert(JSON.stringify(lastMessageId))
								             //$scope.playAudio();
								            if ($scope.lastMessageId !== lastMessageId) {
							                    $scope.onNewMessage(wasListingForMySubmission);
							                }
							                $scope.lastMessageId = lastMessageId;


											var chatmessages = document
													.querySelector(".div_groupChat .box-body");
											setTimeout(
													function() {
														chatmessages.scrollTop = chatmessages.scrollHeight;
													}, 10);

										});
					};

					 $scope.playAudio = function() {
				            $scope.beep && $scope.beep.play();
				        };


					$scope.getLastMessage = function() {
			            return $scope.groups.Groupchat[$scope.groups.Groupchat.length - 1];
			        };

			        $scope.onNewMessage = function(wasListingForMySubmission) {
			        	//$scope.playAudio();
			        	//alert(wasListingForMySubmission +"--"+$scope.lastMessageId);
			            if ($scope.lastMessageId && !wasListingForMySubmission) {
			                $scope.playAudio();
			                //$scope.pageTitleNotificator.on('New message');
			                //$scope.notifyLastMessage();
			            }

			            //$scope.scrollDown();
			            window.addEventListener('focus', function() {
			                $scope.pageTitleNotificator.off();
			            });
			        };

/*			        $scope.scrollDown = function() {
			            var pidScroll;
			            pidScroll = window.setInterval(function() {
			                $('.direct-chat-messages').scrollTop(window.Number.MAX_SAFE_INTEGER * 0.001);
			                window.clearInterval(pidScroll);
			            }, 100);
			        };
*/



			        $scope.pageTitleNotificator = {
			                vars: {
			                    originalTitle: window.document.title,
			                    interval: null,
			                    status: 0
			                },
			                on: function(title, intervalSpeed) {
			                    var self = this;
			                    if (! self.vars.status) {
			                        self.vars.interval = window.setInterval(function() {
			                            window.document.title = (self.vars.originalTitle == window.document.title) ?
			                            title : self.vars.originalTitle;
			                        },  intervalSpeed || 500);
			                        self.vars.status = 1;
			                    }
			                },
			                off: function() {
			                    window.clearInterval(this.vars.interval);
			                    window.document.title = this.vars.originalTitle;
			                    this.vars.status = 0;
			                }
			            };


					/*
					 * $scope.showModal = false; $scope.open = function(index){
					 * $scope.showModal = !$scope.showModal; };
					 */
					$scope.modelInculdeFile = "";
					$scope.UplodPhoto = function() {
						$('#myModal').modal('show');
						$scope.modelInculdeFile = "templates/home/uploadPhoto.html";
						// ngDialog.open({template:
						// 'partials/uploadPhoto.html'});
					};

					$scope.ViewGroupMember = function() {
						$("#txtselectedUser").val("");
						$('#myModal').modal('show');
						$scope.modelInculdeFile = "templates/home/ViewGroupMember.html";

					};

					$scope.sendGroupMessage = function(groupID, message) {

						if (message != "") {
							Data
									.post('Usergroup/sentGroupMessage', {
										groupID : groupID,
										groupMessage : message
									})
									.then(
											function(results) {
												//alert(JSON.stringify(results));
												if (results.status == "success") {
													$scope.groups.Groupchat
															.push(results.recMessage);
													var lastMessage = results.recMessage;
													 var lastMessageId = lastMessage && lastMessage.chat_id;
													 $scope.lastMessageId = lastMessageId;

													$scope.groups.message = "";
													var chatmessages = document
															.querySelector(".div_groupChat .box-body");
													setTimeout(
															function() {
																chatmessages.scrollTop = chatmessages.scrollHeight;
															}, 10);

												}

											});
						}

					};
					$scope.init();
				});