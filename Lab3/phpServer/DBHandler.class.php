<?php
	
class DBHandler
{
	const DB_NAME = "chat.db";
	
	private $chatConn = null;
	
	public function __construct()
	{
		$this->chatConn = new mysqli("localhost", "root", "", "chat");
		if ($this->chatConn->connect_error)
		{
			die("Connection failed: " . $this->chatConn->connect_error);
		}
	}
	
	public function close()
	{
		$this->chatConn->close();
	}
	
	public function addNewMessage($user, $message)
	{
		$queryStr = "INSERT INTO messages (user, message) VALUES ('" . $user . "', '" . $message . "')";
		return $this->chatConn->query($queryStr);
	}
	
	public function getAllMessages()
	{
		$queryStr = "SELECT * FROM messages ORDER BY id";
		$result = $this->chatConn->query($queryStr);
		return $result;
	}
}

?>