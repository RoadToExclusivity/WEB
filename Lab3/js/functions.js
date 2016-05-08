function login(){
	event.preventDefault();
	var url = 'phpServer/loginHandler.php';
	
	var userStr = $('#user').val();
	var passwordStr = $('#password').val();
	if (userStr == '' || passwordStr == '')
	{
		alert('Please fill all fields');
		return false;
	}
	
	var postData = { user : userStr, password : passwordStr };
	console.log(postData);
	$.ajax({
		type: 'POST',
		url: url,
		data: postData,
		dataType: 'json',
		success: function(result){
			alert(result.status + ' ' + result.nickname);
		},
		error: function(){
			console.log("Unhandled server error");
		}
	});
	
	return true;
}