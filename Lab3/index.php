<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Chat</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="js/pageSetup.js"></script>
		<script src="js/chat.js"></script>
		<link rel="stylesheet" href="css/styles.css">
    </head>
    <body onLoad="pageSetup.hideChatControls()">
		<div id="loginFormContainer">
			<form id="loginForm">
				<label>
					User:
					<input type="text" id="user">
				</label>
				<label>
					Password:
					<input type="text" id="password">
				</label>
				<input type="submit" onClick="chat.login()" value="Login">
			</form>
			<p id="loginResult"></p>
        </div>
		
		<div id="chatContainer">
			<div id="mainChat"></div>
			<div id="chatVisitors"></div>
		</div>
		
		<p></p>
		
		<div id="submitFormContainer">
			<form id="sendForm">
				<label id="submitTextLabel">
					Text:
					<input type="text" name="submitText" id="submitTextField" maxLength="50">
				</label>
				<input type="submit" onClick="chat.sendMessage()" value="Send">
			</form>
		</div>
    </body>
</html>