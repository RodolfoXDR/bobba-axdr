$(function (){    
	$('#emailform').submit(function (e){    
		e.preventDefault(); 
		var myemail = $("#myemail").val(); 
		if (myemail == '' ){
			$('.success').fadeOut(200); 
			$('.error').fadeIn(200); 
		}else{
			$.ajax({
				type: "POST", 
				url: "/quickregister/submit", 
				data: $('#emailform').serialize(), 
				success: function (msg){
					if(msg == 'success'){
						$('.success').fadeIn(200).show();
						$('.error').fadeOut(200).hide();
						$("#myemail").val(""); 
					}else{
						$('.success').fadeOut(200);
						$('.error').fadeIn(200); 
					} 
				}, 
				error: function (){
					$('.success').fadeOut(200);
					$('.error').fadeIn(200); 
				} 
			}); 
		} 
		return false; 
	});
});