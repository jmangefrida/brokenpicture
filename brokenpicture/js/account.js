/**
 * 
 */

function signup() {
	
	var email = $('#inputEmail').val();
	var password1 = $('#password1').val();
	var password2 = $('#password2').val();
	var agree = $('#agree').val();
	
	$('#notify').removeClass("bg-danger");
	$('#notify').addClass("invisible");
	
	$.post("code/dosignup.php",{ email: email, password1: password1, password2: password2, agree: agree}).done(function( data ) {
		$('#notify').removeClass("invisible");
		if (data == "good") {
			$('#notify').addClass("bg-success");
			$('#innermessage').html("Account created.");
			window.location.replace("http://brokenpicture.com/mygames.php");
		} else {
			$('#notify').addClass("bg-danger");
			$('#innermessage').html(data);
		}
		
	   });
}

function login() {
	var email = $('#inputEmail').val();
	var password = $('#password').val();
	$('#notify').removeClass("bg-danger");
	$('#notify').addClass("invisible");
	
	$.post("code/dologin.php",{ email: email, password: password }).done(function( data ) {
		$('#notify').removeClass("invisible");
		if (data == "good") {
			$('#notify').addClass("bg-success");
			$('#innermessage').html("success");
			window.location.replace("http://brokenpicture.com/mygames.php");
		} else {
			$('#notify').addClass("bg-danger");
			$('#innermessage').html(data);
		}
		
	   });
}

$('#password').keydown(function(e) {
    if (e.keyCode == 13) {
        login();
    }
});

$('#password2').keydown(function(e) {
    if (e.keyCode == 13) {
        signup();
    }
});

function logout() {
	$.post("code/dologout.php",{ }).done(function( data ) {
		location.reload(); 
		
		
	   });
}
