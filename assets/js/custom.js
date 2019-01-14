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

var Client = function(){}

Client.prototype = {
	base_url : "ApiClient/Controller.php",	
	getallFacilities : async function(){
	    $.ajax({
	        url : this.base_url,
	        method : 'post',
	        data : { "req_name" : "allfacilities" },
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
			"req_name" : "device-registry",
			"Name" : $('#Name').val(),
			"Assigned_Facility" : $("#Assigned_Facility").val(),
			"IP_Address" : $('#IP_Address').val(),
			"Last_Polling_Time" : $('#Last_Polling_Time').val(),
			"Polling_Time" : $('#Polling_Time').val(),
			"Organization" : $('#Organization').val(),
			"User_assigned" : $('#User_assigned').val(),
			"Notes" : $('#Notes').val()
		}


		$('#Active').prop("checked") == true ? fields['Active'] =  "on": console.log("Not checked");


		$('.animationload').removeClass('hidden');
		$.ajax({
			url : this.base_url,
			method : 'post',
			data :  fields,
			success : function(res){
				$('.animationload').addClass('hidden');
				var dt = JSON.parse(res);
				alert(dt.message);				
			}
		});
	}
}


$(document).ready(function(){
	unsetForm();	
	$('#_name').change(function(){
		unsetForm();
		$(this.value).removeClass('hidden');
	});	
});


