<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Chat</title>
		<link rel="stylesheet" href="styles.css">
    </head>
    <body>
		<header>
			<form action="handler.php" method="post">
				<label>
					User:
					<input type="text" name="user">
				</label>
				<label>
					Password:
					<input type="text" name="password">
				</label>
				<input type="submit" value="Login">
			</form>
        </header>
		
		<div id="chatContainer">
			<div id="mainChat">a</div>
			<div id="chatVisistors">b</div>
		</div>
		
		<div id="submitFormContainer">
			<form action="" method="post">
				<label>
					Text:
					<input type="text" name="submitText">
					<input type="submit" value="Send">
				</label>
			</form>
		</div>
    </body>
</html>