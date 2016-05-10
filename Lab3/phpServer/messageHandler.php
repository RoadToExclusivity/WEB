<?php
	
	include('DBHandler.class.php');
	
	// session_start();
	// if (!isset($_SESSION['user']))
	// {
		// die('No user session found');
	// }
	
	$user = $_POST['user'];
	$cmd = $_POST['command'];
	$resultArray = array();
	switch ($cmd)
	{
		case "new_msg":
			$msg = $_POST['message'];
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
			
			break;
		case "get_messages":
			$db = new DBHandler();
			$msgs = $db->getAllMessages();
			$users = array();
			$messages = array();
			while ($row = $msgs->fetch_assoc())
			{
				array_push($users, $row['user']);
				array_push($messages, $row['message']);
			}
			$resultArray['users'] = $users;
			$resultArray['messages'] = $messages;
			$db->close();
			
			break;
		case "get_visitors":
			$db = new DBHandler();
			$visitors = $db->getAllVisitors();
			$users = array();
			while ($row = $visitors->fetch_assoc())
			{
				array_push($users, $row['user']);
			}
			$resultArray['users'] = $users;
			$db->close();
			
			break;
		case "remove_visitor":
			$db = new DBHandler();
			$db->removeVisitor($user);
			$db->close();
			
			break;
	}
	
	echo json_encode($resultArray);
?>