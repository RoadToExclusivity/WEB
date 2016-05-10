var chat = new function(){
	var username = "";
	
	var exit = function(){
		var url = 'phpServer/messageHandler.php';
		var postData = { user : chat.username, command : 'remove_visitor'};
		
		$.ajax({
			type: 'POST',
			url: url,
			data: postData,
			dataType: 'json',
			success: function(){
			},
			error: function(){
				console.log("[REMOVE_VISITOR] Unhandled server error");
			}
		});
		
		return "1";
	}
	
	this.login = function(){
		event.preventDefault();
		var url = 'phpServer/loginHandler.php';
		
		var resultLabel = $('#loginResult');
		resultLabel.text("");
		
		var userStr = $('#user').val();
		var passwordStr = $('#password').val();
		if (userStr == '' || passwordStr == '')
		{
			alert('Please fill all fields');
			return false;
		}
		
		var postData = { user : userStr, password : passwordStr };
		$.ajax({
			type: 'POST',
			url: url,
			data: postData,
			dataType: 'json',
			success: function(result){
				if (result.status != "OK")
				{
					switch (result.message)
					{
						case "WRONG_PASSWORD":
							resultLabel.text("Wrong password");
							break;
						case "WRONG_LOGIN":
							resultLabel.text("Wrong login");
							break;
						default:
							resultLabel.text("Unknown server response");
							break;
					}
				}
				else
				{
					chat.username = userStr;
					setInterval(chat.updateAll, 200);
					$(window).onunload = chat.exit;
				}
			},
			error: function(){
				console.log("[LOGIN] Unhandled server error");
			}
		});
		
		return true;
	}
	
	this.sendMessage = function(){
		event.preventDefault();
		
		var url = 'phpServer/messageHandler.php';
		var msgTextField = $('#submitTextField');
		var msg = msgTextField.val();
		msg = msg.trim();
		if (msg == ''){
			msgTextField.text('');
			return false;
		}
		
		var postData = { user : chat.username, command : 'new_msg', message : msg };
		console.log(postData);
		$.ajax({
			type: 'POST',
			url: url,
			data: postData,
			dataType: 'json',
			success: function(result){
				if (result.status == "OK"){
					chat.updateChat();
					chat.updateVisitors();
					msgTextField.val('');
				}
				else
				{
					alert("Failed to send message");
				}
			},
			error: function(){
				console.log("[SEND_MESSAGE] Unhandled server error");
			}
		});
		
		return true;
	}
	
	this.updateChat = function(){
		var url = 'phpServer/messageHandler.php';
		var chatWindow = $('#mainChat');
		var postData = { user : chat.username, command : 'get_messages'};
		
		$.ajax({
			type: 'POST',
			url: url,
			data: postData,
			dataType: 'json',
			success: function(result){
				chatWindow.empty();
				for (var i = 0; i < result.users.length; i++){
					var user = result.users[i];
					var msg = result.messages[i];
					
					var userLine = "<span class='chatUsername'>" + user + ": </span>";
					chatWindow.append(userLine + msg + "<br>");
				}
				chatWindow.scrollTop(chatWindow[0].scrollHeight);
			},
			error: function(){
				console.log("[LOAD_CHAT] Unhandled server error");
			}
		});
	}
	
	this.updateVisitors = function(){
		var url = 'phpServer/messageHandler.php';
		var visitorsWindow = $('#chatVisitors');
		var postData = { user : chat.username, command : 'get_visitors'};
		
		$.ajax({
			type: 'POST',
			url: url,
			data: postData,
			dataType: 'json',
			success: function(result){
				visitorsWindow.empty();
				for (var i = 0; i < result.users.length; i++){
					var user = result.users[i];
					
					var userLine = "<span class='chatVisitor'>" + user + "</span><br>";
					visitorsWindow.append(userLine);
				}
				visitorsWindow.scrollTop(visitorsWindow[0].scrollHeight);
			},
			error: function(){
				console.log("[LOAD_VISITORS] Unhandled server error");
			}
		});
	}
	
	this.updateAll = function(){
		chat.updateChat();
		chat.updateVisitors();
	}
};

