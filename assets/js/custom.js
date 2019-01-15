document.addEventListener("change", function(event) {
  let element = event.target;
  if (element && element.matches(".form-element-field")) {
    element.classList[element.value ? "add" : "remove"]("-hasvalue");
  }
});

function unsetForm(){
	var names = ['#device_registry', '#leads', '#contact', '#facility', '#hardware_inventory', '#software_inventory'];
	$.each(names, function( index, value ) {
	  	$(value).addClass('hidden');
	});
}

function checkSpinner(ajaxCnt){
	if (ajaxCnt <= 0) $('.animationload').addClass('hidden');
	else $('.animationload').removeClass('hidden');
}

var ajaxCnt = 0;
var table;
var Client = function(){}
Client.prototype = {
	base_url : "ApiClient/Controller.php",
	ajaxCnt  : 0,
	init : function(){},
	getallFacilities : function(){
	    $.ajax({
	        url : this.base_url,
	        method : 'post',
	        data : { "req_name" : "allfacilities" },
	        beforeSend : function(){	        	
	        	checkSpinner(++ajaxCnt);
	        },
	        complete : function(){
	        	checkSpinner(--ajaxCnt);
	        },
	        success : function(res){	        	
	            var dt = JSON.parse(res);
	            if (dt.status === "success"){
	                htmlContent = '<option disabled selected value="" class="form-select-placeholder"></option>';
	                for (i = 0 ; i < dt.message.length; i++){                        
	                    htmlContent += "<option value='" + dt.message[i].id + "'>" + dt.message[i].value + "</option>";
	                }
	                $('#Assigned_Facility').html(htmlContent);
	            }
	        }
	    });
	},

	getallContacts : function(){
	    $.ajax({
	        url : this.base_url,
	        method : 'post',
	        data : { "req_name" : "allcontacts" },
	        beforeSend : function(){	        	
	        	checkSpinner(++ajaxCnt);
	        },
	        complete : function(){
	        	checkSpinner(--ajaxCnt);
	        },
	        success : function(res){
	            var dt = JSON.parse(res);
	            if (dt.status === "success"){
	                htmlContent = '<option disabled selected value="" class="form-select-placeholder"></option>';
	                for (i = 0 ; i < dt.message.length; i++){                        
	                    htmlContent += "<option value='" + dt.message[i].id + "'>" + dt.message[i].value + "</option>";
	                }
	                $('#User_assigned').html(htmlContent);
	            }
	        }
	    });
	},

	insertDeviceRegistry : function(){
		var fields = {
			"req_name" 		: "device-registry",
			"Name" 			: $('#Name').val(),
			"Assigned_Facility" : $("#Assigned_Facility").val(),
			"IP_Address" 	: $('#IP_Address').val(),
			"Last_Polling_Time" : $('#Last_Polling_Time').val(),
			"Polling_Time" 	: $('#Polling_Time').val(),
			"Organization" 	: $('#Organization').val(),
			"User_assigned" : $('#User_assigned').val(),
			"Notes"			: $('#Notes').val()
		}
		document.getElementById("Active").checked == true ? fields['Active'] =  "on": console.log("Not checked");


		$.ajax({
			url : this.base_url,
			method : 'post',
			data :  fields,
	        beforeSend : function(){	        	
	        	checkSpinner(++ajaxCnt);
	        },
	        complete : function(){
	        	checkSpinner(--ajaxCnt);
	        },
			success : function(res){
				var dt = JSON.parse(res);
				alert(dt.message);
			}
		});
	},

	getAllDeviceRegistry : function(){
	    $.ajax({
	        url : this.base_url,
	        method : 'post',
	        data : { "req_name" : "alldevice-registry" },
	        beforeSend : function(){	        	
	        	checkSpinner(++ajaxCnt);
	        },
	        complete : function(){
	        	checkSpinner(--ajaxCnt);
	        },
	        success : function(res){
	            var dt = JSON.parse(res);
	            if (dt.status === "success"){
	            	var keys = ["Name","Active", "Assigned_Facility", "IP_Address", "Last_Polling_Time", "Polling_Time", "User_assigned"];
	                headContent = '<tr> <th>No</th> ';
	                for (var i = 0 ; i < keys.length ; i++) headContent += "<th>" + keys[i] + "</th>"; headContent += "</tr>";

	                bodyContent = "";
	            	var objKeys = Object.keys(dt.message);

	                for (i = 0 ; i < objKeys.length; i++){
	                	var obj = dt.message[objKeys[i]];
	                	bodyContent += "<tr> <td>" + (i+1) + "</td>";
	                	for (var j = 0 ; j < keys.length ; j++) {	                		
	                		var value = "";
	                		if (obj[keys[j]] !="null") value = obj[keys[j]];
	                		bodyContent += "<td>" + value + "</td>";
	                	}
	                	bodyContent += "</tr>";
	                }

	                $('#device_head').html(headContent);
	                $('#device_body').html(bodyContent);
	                console.log(bodyContent);
	                table = $('#device-registry').DataTable();
	            }
	        }
	    });
	}
}


var client = new Client();

$(document).ready(function(){    
    checkSpinner(ajaxCnt);
	unsetForm();	
	$('#_name').change(function(){
		unsetForm();
		$(this.value).removeClass('hidden');
	});
});


