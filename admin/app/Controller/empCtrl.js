app.controller('empCtrl', function ($scope, $rootScope, $routeParams, $location, $http,ngDialog, Data, $interval, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) {
 var id = $routeParams.id;
 //var name = $routeParams.name;
 $scope.dtOptions = DTOptionsBuilder.newOptions()
	    .withOption('order', [])
        .withOption('responsive', true);
 $scope.dtColumns = [
            DTColumnDefBuilder.newColumnDef(0).notSortable(),
           DTColumnDefBuilder.newColumnDef(1).notSortable(),
           DTColumnDefBuilder.newColumnDef(2).notSortable(),
            //DTColumnDefBuilder.newColumnDef(3).notSortable()
             
        ];

 var departname ;
 var designame ;
 var compname;
 $scope.employee = {"id" : "", "month" : ""};
 	$scope.disabledFlg = "false";
 $scope.netpay_words = "";
   $scope.AskQuest = {"selectedUser" : {"user_id":"All", "User" : "User"}};
   $scope.init = function() {
	 $scope.hideme = true;
	 if($location.url() == "/home/listemp" || $location.url() == "/home/salarycalc" || $location.url() ==  "/home/payslip")
	 {
	 	$scope.getempdetails();
	 }
	 
	 $scope.getDepartmentList();
	 $scope.getcompdetail();
	 $scope.getAllDesignation();

	 if(id != undefined)
	 {
		 $scope.getempdetail(id);
		// $scope.getUserEducationDetails();
		 
	 }
   };


   $scope.calculateCTC = function (annualCTC = 0, page) {
   		//$scope.employee.monthly_ctc = Math.round(annualCTC/12, 2);
   		var monthlyCTC = (annualCTC/12).toFixed(2);
   		if(page == 'New')
   		{
   			$scope.employee.monthly_ctc = monthlyCTC;
   		}
   		else if(page == "update")
   		{
			$scope.employeedetail.monthly_ctc = monthlyCTC;
   		}
   }
    $scope.UplodPhoto = function(){
    	$scope.modelInculdeFile = "templates/admin/uploadlogo.html";
		$('#myModal').modal('show');
    };
   
  	$scope.cancelSalaryCalc = function()
  	{
  		$scope.disabledFlg = "false";
  		$scope.employee = {};
  	}

	$scope.getAllUsersGroups = function(){
	   Data.get('Dashboard/getAllUsersGroups', {
	       }).then(function (results) {
	       	$scope.Alluser = results;
	       });
	};

	$scope.getDepartmentList = function(){
	   Data.get('Dashboard/getDepartment', {
	       }).then(function (results) {
	       	$scope.Department = results.Department;
	       });
	};
   
    $scope.getcompdetail = function(){
	   Data.get('Dashboard/getcomp', {
	       }).then(function (results) {
	       	$scope.company = results.company;
	       });
	};

	$scope.getDesignation = function(department_id){
		
	   Data.post('Dashboard/getDesignation', {
		   department_id : department_id
	       }).then(function (results) {
	       	$scope.Designation = results.Designation;
	       });

	};
	
	$scope.getAllDesignation = function(){
	   Data.get('Dashboard/getAllDesignation', {
	       }).then(function (results) {
	       	$scope.Designation = results.Designation;
	       });

	};
	
	
		/*
	$scope.getDesignation = function(id,name)
		{
		alert(id);
		departname = name;
		alert(departname);
		Data.post('Dashboard/getSubCategory', {
		   category_id : id
	       }).then(function (results) {
		   	 //alert(JSON.stringify(results));
	       	$scope.subcategory = results.subcategory;
	       });
		}
		*/
		
		
	$scope.getDesig = function(id,name){
			designame = name;
	}
		
	$scope.getcompname = function(id,name){
			compname = name;
	}	
		
	$scope.saveEmployee = function(empDetails){
	   Data.post('Dashboard/saveEmployee', empDetails).then(function (results) {
	    	 Data.toast(results);
	    	 if(results.status == "success")
				{
	    	//	 $scope.AskQuest = {"selectedUser" : {"user_id":"All", "User" : "User"}};
				$location.path('/home/listemp');
				}
       });
	}
	
	$scope.updateEmployee = function(empDetails){
	   Data.post('Dashboard/updateEmployee', empDetails).then(function (results) {
		   if(results.status == "success")
				{
			Data.toast(results);
			$location.path('/home/listemp');
				}
       });
	}
   
	$scope.getempdetails = function(id){

        	Data.get('Dashboard/getempdetails', { id : id
                }).then(function (results) {
                	$scope.employeedetails = results.EmpDetails;
                	
                    });
    };
	
	$scope.testroute = function(){
		$location.path('/home/updateemp');
	};
	
	$scope.getUserEducationDetails = function() {
    Data.get('Profile/subjectGrades', {
    }).then(function (results) {
        $scope.eduInfo = results;
       	$scope.selectedCategory = {};
       });
    };
	
	/*$scope.getempdetails = function(){
        	Data.get('Dashboard/getempdetails', {
                }).then(function (results) {
                	alert(JSON.stringify(results));
                	$scope.employeedetails = results.EmpDetails;
                    });
    };*/
	
	$scope.getempdetail = function(id){

        	Data.post('Dashboard/getempdetail',{'id':id}).then(function (results) {
                	$scope.employeedetail = results.EmpDetails;

					 $scope.getDesignation($scope.employeedetail.department_id);
                    });
    };
	
	$scope.generatepayslip = function(inputPayslip){
		if(inputPayslip.id == "" || inputPayslip.id == null )
	    {
	      alert("Please select employee.");
	      return;
	    }
			if(inputPayslip.month == "" || inputPayslip.month == null )
	    {
	      alert("Please select month and year.");
	      return;
	    }
		$scope.payslipDetail = {};
        	Data.post('Dashboard/generatepayslip',inputPayslip).then(function (results) {
					$scope.hideme = true;
					Data.toast(results);
					if(results.status == "success")
					{
						//alert(JSON.stringify(results.PayslipDetails));
	                	$scope.payslipDetail = results.PayslipDetails;
	                	$scope.netpay_words = $scope.convertNumberToWords($scope.payslipDetail.ctc);
						if(results.status == "success"){
							 $scope.hideme = false;
						}else{
							 $scope.hideme = true;
						}
					}
					
					
                    });
    };
	

	
	$scope.getempdetailforsalary = function(empDetails){
	   Data.post('Dashboard/getempdetailforsalary', empDetails).then(function (results) {
                	$scope.employeedetail = results.EmpDetails;
					$scope.disabledFlg = "true";
                    });
	}
	
	$scope.getwordmonth = function(mon_number){
		if(mon_number == 1){
			return 'January';
		}else if(mon_number == 2){
			return 'February';
		}else if(mon_number == 3){
			return 'March';
		}else if(mon_number == 4){
			return 'April';
		}else if(mon_number == 5){
			return 'May';
		}else if(mon_number == 6){
			return 'June';
		}else if(mon_number == 7){
			return 'July';
		}else if(mon_number == 8){
			return 'Augest';
		}else if(mon_number == 9){
			return 'Septemper';
		}else if(mon_number == 10){
			return 'October';
		}else if(mon_number == 11){
			return 'November';
		}else if(mon_number == 12){
			return 'December';
		}
	   
	}
	
	$scope.convertNumberToWords = function(amount){
    var words = new Array();
    words[0] = '';
    words[1] = 'One';
    words[2] = 'Two';
    words[3] = 'Three';
    words[4] = 'Four';
    words[5] = 'Five';
    words[6] = 'Six';
    words[7] = 'Seven';
    words[8] = 'Eight';
    words[9] = 'Nine';
    words[10] = 'Ten';
    words[11] = 'Eleven';
    words[12] = 'Twelve';
    words[13] = 'Thirteen';
    words[14] = 'Fourteen';
    words[15] = 'Fifteen';
    words[16] = 'Sixteen';
    words[17] = 'Seventeen';
    words[18] = 'Eighteen';
    words[19] = 'Nineteen';
    words[20] = 'Twenty';
    words[30] = 'Thirty';
    words[40] = 'Forty';
    words[50] = 'Fifty';
    words[60] = 'Sixty';
    words[70] = 'Seventy';
    words[80] = 'Eighty';
    words[90] = 'Ninety';
    //amount = amount.toString();
    var atemp = amount.split(".");
    var number = atemp[0].split(",").join("");
    var n_length = number.length;
    var words_string = "";
    if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
            received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
            n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                if (n_array[i] == 1) {
                    n_array[j] = 10 + parseInt(n_array[j]);
                    n_array[i] = 0;
                }
            }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                value = n_array[i] * 10;
            } else {
                value = n_array[i];
            }
            if (value != 0) {
                words_string += words[value] + " ";
            }
            if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Crores ";
            }
            if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Lakhs ";
            }
            if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Thousand ";
            }
            if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                words_string += "Hundred and ";
            } else if (i == 6 && value != 0) {
                words_string += "Hundred ";
            }
        }
        words_string = words_string.split("  ").join(" ");
		words_string = "(In words) Rupees "+words_string+" only";
		}
    return words_string; 
	}
	
  
	
	/*$scope.printpay = function(){
	  
		var printContents = document.getElementById('exportthis').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
   
	$scope.export = function(){
	   
        html2canvas(document.getElementById('exportthis'), {
            onrendered: function (canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500,
                    }]
                };
                pdfMake.createPdf(docDefinition).download("test.pdf");
            }
        });
		}  */

		
	 $scope.printpay = function(){
		  var printContents = document.getElementById('exportthis').innerHTML;
  		var popupWin = window.open('', '_blank');
  		popupWin.document.open();
  		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css" /><style>table th, td{padding:5px; text-align:left;} p {color: black; text-align: left;margin:5px}</style></head><body onload="window.print()">' + printContents + '</body></html>');
  		//popupWin.document.write('<html><head><style>table td, th{padding:5px;}</style></head><body onload="window.print()">' + printContents + '</body></html>');
  		popupWin.document.close();
   }
   
     $scope.export = function(name, monthYear){
	       var filename = name+"_"+monthYear.replace(",","_")+".pdf";
        html2canvas(document.getElementById('exportthis'), {
            onrendered: function (canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500,
                    }]
                };
                pdfMake.createPdf(docDefinition).download(filename);
            }
        });
     }
	
	$scope.init();

});
