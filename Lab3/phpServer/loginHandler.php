<?php
	include('DBHandler.class.php');
	
	const REGISTERED_USERS = array("denis" => "qwerty", "sanek" => "123321", "serega" => "bottle");
	
	$user = $_POST["user"];
    $password = $_POST["password"];
	
	$returnedArray = array("status" => "", "nickname" => "", "message" => "");
	header('Content-Type: application/json');
	if (array_key_exists($user, REGISTERED_USERS))
	{
		if (REGISTERED_USERS[$user] == $password)
		{
			$db = new DBHandler();
			if ($db->isVisitorExists($user))
			{
				$returnedArray["status"] = "FAILED";
				$returnedArray["message"] = "ALREADY_LOGGED";
			}
			else
			{
				$returnedArray["status"] = "OK";
				$returnedArray["nickname"] = $user;
				$db->addNewVisitor($user);
			}
			
			$db->close();
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