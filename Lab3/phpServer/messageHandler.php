<?php
	
	include('DBHandler.class.php');
	
	// session_start();
	// if (!isset($_SESSION['user']))
	// {
		// die('No user session found');
	// }
	
	$user = $_POST['user'];
	$cmd = $_POST['command'];
	switch ($cmd)
	{
		case "new_msg":
			$msg = $_POST['message'];
			$resultArray = array('status' => '');
			$db = new DBHandler();
			if ($db->addNewMessage($user, $msg))
			{
				$resultArray['status'] = 'OK';
			}
			else
			{
				$resultArray['status'] = 'FAILED';
			}
			$db->close();
			echo json_encode($resultArray);
			break;
		case "get_messages":
			$db = new DBHandler();
			$msgs = $db->getAllMessages();
			$users = array();
			$messages = array();
			$resultArray = array();
			while ($row = $msgs->fetch_assoc())
			{
				array_push($users, $row['user']);
				array_push($messages, $row['message']);
			}
			$resultArray['users'] = $users;
			$resultArray['messages'] = $messages;
			$db->close();
			echo json_encode($resultArray);
			break;
	}
	
?>