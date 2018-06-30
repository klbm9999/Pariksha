
function verifySubmission() {
	$("document").ready(function(){
	    // var str = $('form').serialize();
	    var str = JSON.stringify($('form').serializeArray()); // store json string
	    $.ajax({
	        type: 'post',
	        url: 'scripts/ajax_handler.php',
	        data: { "action": "verifySubmission","submission":str,"integrity":$('form').attr('data')},
	        success: function(response) { 
	        	var text = 'Your score is '+response
	        	$('#result').removeClass('d-none')
	        	$('#result').text(text)
	        }
	    });
	});
}