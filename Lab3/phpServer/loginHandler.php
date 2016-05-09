<?php
	const REGISTERED_USERS = array("denis" => "qwerty", "sanek" => "123321", "serega" => "bottle");
	
	$user = $_POST["user"];
    $password = $_POST["password"];
	
	$returnedArray = array("status" => "", "nickname" => "", "message" => "");
	header('Content-Type: application/json');
	if (array_key_exists($user, REGISTERED_USERS))
	{
		if (REGISTERED_USERS[$user] == $password)
		{
			$returnedArray["status"] = "OK";
			$returnedArray["nickname"] = $user;
			
			// session_start();
			// $_SESSION['user'] = $user;
		}
		else
		{
			$returnedArray["status"] = "FAILED";
			$returnedArray["message"] = "WRONG_PASSWORD";
		}
	}
	else
	{
		$returnedArray["status"] = "FAILED";
		$returnedArray["message"] = "WRONG_LOGIN";
	}
	
	echo json_encode($returnedArray);
?>