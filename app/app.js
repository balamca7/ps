var app = angular.module('app', ['ngRoute', 'ngAnimate', 'route-segment', 'view-segment','toaster','ui.calendar', 'ui.bootstrap','ngStorage','ngDialog','datatables', 'moment-picker']);

app.config(function($routeSegmentProvider, $routeProvider) {
    $routeSegmentProvider.options.autoLoadTemplates = true;
    $routeSegmentProvider
        .when('/login',          's1')
        .when('/home',          's2')
        .when('/home/dashboard',    's2.dashboard')
        .when('/home/dashboard/:type/:type_val',    's2.dashboard')
        .when('/home/content/:postid',      's2.content')
        .when('/home/payslip',    's2.payslip')
		.when('/home/employee',    's2.employee')
        .when('/home/usergroups',    's2.usergroups')
        .when('/home/findtutors',    's2.findtutors')
        .when('/home/profile/:id/:usergroup',    's2.profile')
        .when('/home/userSubjects',    's2.userSubjects')
        .when('/home/groups/:id/:usergroup',    's2.groups')
        .when('/home/mycalendar', 's2.mycalendar')
        .when('/home/myrequest', 's2.myrequest')
        .when('/home/resources', 's2.resources')
        .when('/home/schedulerequest/:id', 's2.schedulerequest')

        .when('/signup',          's3')
        .when('/forgetpassword',          's4')
        .when('/resetpassword/:id',          's5')
        .when('/UserActivation/:id',          's6')
         .when('/notificationlink',          's7')

        .segment('s1', {
            templateUrl: 'templates/login.html',
            controller: 'MainCtrl',
            resolve: {
                data: function($timeout) {
                    return $timeout(function() { return 'SLOW DATA CONTENT'; }, 2000);
                }
            },
            untilResolved: {
                templateUrl: 'templates/loading.html'
            }
         
        })

        .segment('s2', {
            templateUrl: 'templates/home.html',
            controller: 'MainCtrl',
            resolve: {
                data: function($timeout) {
                    return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                }
            },
            untilResolved: {
                templateUrl: 'templates/loading.html'
            }
    
        })
       .within()
            .segment('home', {
                'default': true,
                templateUrl: 'templates/home/home.html',
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 2000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
              
            })

            .segment('dashboard', {
                templateUrl: 'templates/home/dashboard.html',
                dependencies: ['type','type_val'],
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })
            .segment('content', {
                templateUrl: 'templates/home/content.html',
                dependencies: ['postid'],
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })
            .segment('payslip', {
                templateUrl: 'templates/home/payslip.html',
				//dependencies : [ 'id' ],
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })
				
				 .segment('employee', {
                templateUrl: 'templates/home/employee.html',
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })

            .segment('usergroups', {
                templateUrl: 'templates/home/usergroup.html',
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })
            .segment('findtutors', {
                templateUrl: 'templates/home/findTutor.html',resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
            }).segment('schedulerequest', {
						templateUrl : 'templates/home/schedulerequest.html',
						dependencies : [ 'id' ],
						resolve : {
							data : function($timeout) {
								return $timeout(function() {
									return 'SLOW DATA CONTENT';
								}, 1000);
							}
						},
						untilResolved : {
							templateUrl : 'templates/loading.html'
						}
            }).segment('mycalendar', {
						templateUrl : 'templates/home/mycalendar.html',
						
						resolve : {
							data : function($timeout) {
								return $timeout(function() {
									return 'SLOW DATA CONTENT';
								}, 1000);
							}
						},
						untilResolved : {
							templateUrl : 'templates/loading.html'
						}
					}).segment('myrequest', {
						templateUrl : 'templates/home/myrequest.html',
						
						resolve : {
							data : function($timeout) {
								return $timeout(function() {
									return 'SLOW DATA CONTENT';
								}, 1000);
							}
						},
						untilResolved : {
							templateUrl : 'templates/loading.html'
						}
					
                })
                
             
                .segment('resources', {
						templateUrl : 'templates/home/resources.html',
						
						resolve : {
							data : function($timeout) {
								return $timeout(function() {
									return 'SLOW DATA CONTENT';
								}, 1000);
							}
						},
						untilResolved : {
							templateUrl : 'templates/loading.html'
						}
					
                })
                
                
            .segment('profile', {
                templateUrl: 'templates/home/profile.html',
                dependencies: ['id', 'usergroup'],
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })

            .segment('userSubjects', {
                templateUrl: 'templates/home/userSubjects.html',
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })
            .segment('groups', {
                templateUrl: 'templates/home/groupChat.html',
                dependencies: ['id', 'usergroup'],
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })

        .up()
        .segment('s3', {
            templateUrl: 'templates/signup.html',
            resolve: {
                data: function($timeout) {
                    return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                }
            },
            untilResolved: {
                templateUrl: 'templates/loading.html'
            }
            	
        })


        .segment('s4', {
            templateUrl: 'templates/forgetpassword.html',
            resolve: {
                data: function($timeout) {
                    return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                }
            },
            untilResolved: {
                templateUrl: 'templates/loading.html'
            }    
        })

        .segment('s5', {
            templateUrl: 'templates/resetpassword.html',
            resolve: {
                data: function($timeout) {
                    return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                }
            },
            untilResolved: {
                templateUrl: 'templates/loading.html'
            }    
        })
        .segment('s6', {
                templateUrl: 'templates/UserActivation.html',
                dependencies: ['id'],
                resolve: {
                    data: function($timeout) {
                        return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                    }
                },
                untilResolved: {
                    templateUrl: 'templates/loading.html'
                }
                })
                    .segment('s7', {
            templateUrl: 'templates/notificationlink.html',
            resolve: {
                data: function($timeout) {
                    return $timeout(function() { return 'SLOW DATA CONTENT'; }, 1000);
                }
            },
            untilResolved: {
                templateUrl: 'templates/loading.html'
            }    
        })
                


    $routeProvider.otherwise({redirectTo: '/login'});

}).config(function($locationProvider) {
	$locationProvider.html5Mode(false);
	    $locationProvider.hashPrefix('!');
}).run(function($rootScope, $location, $http,Data, $localStorage) {

	$rootScope.$on("$routeChangeStart", function(event, next, current) {

		$rootScope.authenticated = false;
		//alert(JSON.stringify($localStorage.currentUser))

		if($localStorage.currentUser != undefined)
		{
            $http.defaults.headers.common.Authorization = 'Bearer ' + $localStorage.currentUser.token;

			$rootScope.authenticated = true;
			$rootScope.uid = $localStorage.currentUser.uid;
			$rootScope.name = $localStorage.currentUser.name;
			$rootScope.email = $localStorage.currentUser.email;
			$rootScope.image = $localStorage.currentUser.image;
		} else {
			var nextUrl = next.$$route.originalPath;

			if (nextUrl == '/signup' || nextUrl == '/notificationlink' || nextUrl == '/login' || nextUrl == '/forgetpassword' || nextUrl == '/resetpassword/:id' || nextUrl == '/UserActivation/:id' || nextUrl == '/signup') {

			} else {
				$location.path("/login");
			}
		}

	});
});

app.value('loader', {show: false});

app.controller('MainCtrl', function($scope, $routeSegment, loader) {

    $scope.$routeSegment = $routeSegment;
    $scope.loader = loader;

    $scope.$on('routeSegmentChange', function() {
        loader.show = false;
    })
});