app.controller('paysilpCtrl', function ($scope, $rootScope, $routeParams, $location, $http,ngDialog, Data, $interval) {
   //alert("paysilpCtrl");
   var userID = $routeParams.id;
   $scope.cartList = {id:userID};
   
   $scope.employee = {"month" : ""};
	//  alert(employee.id);
  $scope.netpay_words = "";
   $scope.init = function() {

    $scope.hideme = true;
	   $scope.getUserSalaryMonth();
   };

   $scope.getUserSalaryMonth = function() {
      Data.get('Profile/getUserSalaryMonth', {
         }).then(function (results) {
          //alert(JSON.stringify(results));
          $scope.SalaryMonth = results;
         });
   }

   $scope.getAllUsersGroups = function(){
	   Data.get('Dashboard/getAllUsersGroups', {
	       }).then(function (results) {
		   // 	 alert(JSON.stringify(results));
	       	$scope.Alluser = results;
	       });
   };

   $scope.getCategoryList = function(){
	   Data.get('Dashboard/getCategory', {
	       }).then(function (results) {
		    	// alert(JSON.stringify(results));
	       	$scope.Category = results;
	       });
   };

   $scope.generatepayslip = function(inputPayslip){
    
    if(inputPayslip.month == "" || inputPayslip.month == null )
    {
      alert("Please select month and year.");
      return;
    }
		$scope.payslipDetail = {};
			
	
        	Data.post('Profile/generatepayslip',inputPayslip).then(function (results) {

					$scope.hideme = true;
					//Data.toast(results);
          $scope.payslipDetail = results.PayslipDetails;
          $scope.netpay_words = $scope.convertNumberToWords($scope.payslipDetail.ctc);
					if(results.status == "success"){
						 $scope.hideme = false;
					}else{
						 $scope.hideme = true;
					}
       });
    };
   
   $scope.getSubCategoryList = function(categoryId){

	   Data.post('Dashboard/getSubCategory', {
		   categoryId : categoryId
	       }).then(function (results) {
		  //  	 alert(JSON.stringify(results));
	       	$scope.subCategory = results;
	       });
   };


   $scope.postQuestion = function(AskQuest){
	   //alert(JSON.stringify(AskQuest));
	   Data.put('Dashboard/Postquestion', AskQuest).then(function (results) {
    	   //alert(JSON.stringify(results));
	    	 Data.toast(results);
	    	 if(results.status == "success")
     		{
	    		 $scope.AskQuest = {"selectedUser" : {"user_id":"All", "User" : "User"}};

         	}
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
    //var amount = amount.toString();
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
    words_string = "(In words) Rupees  "+words_string+" only";
    }
    return words_string; 
  }

   
   $scope.printpay = function(){
		  var printContents = document.getElementById('exportthis').innerHTML;
  		var popupWin = window.open('', '_blank');
  		popupWin.document.open();
  		popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" /><style>table th, td{padding:5px; text-align:left;} p {color: black; text-align: left;margin:5px}</style></head><body onload="window.print()">' + printContents + '</body></html>');

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
