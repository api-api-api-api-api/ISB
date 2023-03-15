// JavaScript Document
$(document).ready(function(){

	var url = 'getSetting';
//call jQuery AJAX function
	$.ajax({
      url: url,
      type: "POST",
      data: ({}),
      dataType: "text",
      async:false,
      success: function(returnedVal){

    	 returnedVal=returnedVal.split("!");
      	  document.getElementById("headerText").innerHTML=returnedVal[0];
      	  document.title='.::: '+returnedVal[0]+' :::.';
      }
   	}
);	
	
$('#namaUser').focus();

$("#frmLogin").validate({
   	rules:
	{
		namaUser: {
		required: true,
		minlength: 1
		},
		pass: {
		required: true,
		minlength: 1
		}
	}, 
	messages: 
	{
		namaUser: {
		required: "*",
		minlength: ""
		},
		pass: {
		required: "*",
		minlength: ""
		}
  	},

highlight: function (element) {
	$(element).parent().addClass('error')
},

unhighlight: function (element) {
	$(element).parent().removeClass('error')
}, 

submitHandler: function(form) {	 
	$('#mode').val("saveData");
		var formData = $("#frmLogin").serialize(); 
		var formUrl = 'logProcess';
	
	$.ajax({
		url: formUrl,
		type: "post",
		async:false,
		data: formData,
	
		success: function(returnedVal){
			//console.log(returnedVal);return
			if(returnedVal=='gagal')
			{
				alert('Username atau password anda salah!');
				document.getElementById('errMsg').innerHTML='Username atau password anda salah!';
				
				return;
			}
			else
			{			
				window.location='mainmenus';
			}
			
		}
   	});
}});

	 
});
