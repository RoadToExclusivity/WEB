<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Chat</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="js/functions.js"></script>
		<link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
		<header id="wrapper">
			<form id="loginForm">
				<label>
					User:
					<input type="text" id="user">
				</label>
				<label>
					Password:
					<input type="text" id="password">
				</label>
				<input type="submit" onClick="login()" value="Login">
			</form>
        </header>
		
		<div id="wrapper">
			<div id="chatContainer">
				<div id="mainChat">a</div>
				<div id="chatVisitors">b</div>
			</div>
		</div>
		
		<div id="wrapper">
			<div id="submitFormContainer">
				<form action="" method="post">
					<label>
						Text:
						<input type="text" name="submitText">
						<input type="submit" value="Send">
					</label>
				</form>
			</div>
		</div>
    </body>
</html>