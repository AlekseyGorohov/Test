$(document).ready(function(){
    $("#btn-reg").click(
		function(){
			sendForm('result', 'form', 'action_form.php');
			return false; 
		}
	);
});
 
function sendForm(result, form, url){
    $.ajax({
        url: url, 
        type: "POST", 
        dataType: "html", 
        data: $("#" + form).serialize(), 
        success: function(response){ 
			result = $.parseJSON(response);
			answer(result);
    	},
    	error: function(response){
            $("#result").html('Ошибка. Данные не отправлены.');
    	}
 	});
}

function answer(result){
	if(result.code > 0)
		alert(result.message);
	else{
		$("#form").hide();
		$("#result").show();
		$("#result").html(result.message);
	}
}