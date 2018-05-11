app.factory("Data", ['$http', 'toaster',
    function ($http, toaster) { // This service connects to our REST API

        var serviceBase = 'api/index.php/';

        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 10000, 'trustedHtml');
        }
        obj.get = function (q) {
        	//alert(serviceBase + q);
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
        	//alert(serviceBase + q);
            return $http.post(serviceBase + q, object).then(function (results) {
            	//alert(JSON.stringify(results))
                return results.data;
            });
        };
        obj.put = function (q, object) {
        	/*return $http.put(serviceBase + q, object)
            .success(function (data, status, headers) {
            	return data;
            })
            .error(function (data, status, header, config) {
            	return data;
            });
        	*/
        	
            return $http.put(serviceBase + q, object).then(function (results) {
            	
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);


app.factory('Excel',function($window){
        var uri='data:application/vnd.ms-excel;base64,',
            template='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
            format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
        return {
            tableToExcel:function(tableId,worksheetName){
                var table=$(tableId),
                    ctx={worksheet:worksheetName,table:table.html()},
                    href=uri+base64(format(template,ctx));
                return href;
            }
        };
    });
   



