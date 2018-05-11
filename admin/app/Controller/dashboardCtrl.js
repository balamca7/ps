app.controller('dashboardCtrl',	function ($scope, $rootScope, $routeParams, $location, $http, Data, $timeout) {
    //initially set those objects to null to avoid undefined error
    //alert("dashboradCtrl");

        $scope.init = function()
        {
        	$scope.barChart = {};
          $scope.companyEmp = {}
        	$scope.category_id = 0;
          $scope.getDashboard();
        	//$scope.generatePieData();
            $scope.doughnut();
        	//$scope.generateData();
            //$scope.bar(0);
           // $scope.getCategory();
        };
        
        $scope.getCategory = function(){

        	Data.get('dashboard/getCategory', {
            }).then(function (results) {
            	//alert(JSON.stringify(results));
            	$scope.Category = results.category;
            
                });
        };

        
    	$scope.getDashboard = function(){
    		
        	Data.get('dashboard/getDashboard', {
            }).then(function (results) {
            	//alert(JSON.stringify(results));
            	$scope.totalUser = results.totalUser;
            	$scope.totalQuestion = results.totalQuestion;
              $scope.companyEmp = results.EmployeeList;
                });
        };

          $scope.generateData = function(category){
        	  $scope.barChart = {};
        	  var data1 = {}
        	  Data.post('dashboard/getQuestionbarchart', {category:category
              }).then(function (results) {
            	  var label = results.questionChart.label;
            	  var labeldata = results.questionChart.value;
                 data1 = {
                        labels : label,
                        datasets : [
                          {
                            fillColor : "rgba(151,187,205,0.5)",
                            strokeColor : "rgba(251,187,205,1)",
                            pointColor : "rgba(151,187,205,1)",
                            pointStrokeColor : "#fff",
                            data : labeldata
                          }
                        ]
                      };

              	
              	$scope.barChart = {"data": data1, "options": {} };
                  });
        	  
        	  
/*            var sevenRandNumbers = function(){
              var numberArray = [];
              for (var i=0;i<10;i++){
                numberArray.push(Math.floor((Math.random()*100)+1));
              }
              return numberArray;
            };
            var data = {
              labels : ["World Language","History","ELA","Mathematics","Geography","Drawing","Physics","Mechanical","Test","NEW"],
              datasets : [
                {
                  fillColor : "rgba(151,187,205,0.5)",
                  strokeColor : "rgba(151,187,205,1)",
                  pointColor : "rgba(151,187,205,1)",
                  pointStrokeColor : "#fff",
                  data : sevenRandNumbers()
                }
              ]
            };
            $scope.barChart = {"data": data, "options": {} };
*/          };

          $scope.generatePieData = function(){
        	  $scope.pieChart = {};
          	Data.get('dashboard/getUserpiechart', {
            }).then(function (results) {
            	var data = results.userChart;
            	$scope.pieChart = {"data": data, "options": {} };
                });

            /*var data = [
              {
            	  label:"Student",
            	  value: 152,
                color:"red"
              },
              {
            	  label:"Teacher",
            	  value : 50,
                color : "green"
              },
              {
            	  label:"Valenteer",
            	  value : 100,
                color : "aqua"
              }
              ,
              {
            	  label:"Others",
            	  value : 185,
                color : "gray"
              }
            ]
*/            
          };

          $scope.bar = function(category) {
        	  document.getElementById('barChart').value="";
              document.getElementById('barChart').setAttribute('type', 'Bar');
              $scope.generateData(category);
            };
            $scope.radar = function() {
                document.getElementById('barChart').setAttribute('type', 'Radar');
                $scope.generateData();
              };
          $scope.polarArea = function() {
            document.getElementById('pieChart').setAttribute('type', 'PolarArea');
            $scope.generatePieData();
          };

          $scope.pie = function() {
            document.getElementById('pieChart').setAttribute('type', 'Pie');
            $scope.generatePieData();
          };

          $scope.doughnut = function() {
            document.getElementById('pieChart').setAttribute('type', 'Doughnut');
            $scope.generatePieData();
          };


     
        $scope.init();
});