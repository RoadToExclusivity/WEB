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
	
	public function isVisitorExists($user)
	{
		$queryStr = "SELECT * FROM visitors WHERE user='" . $user . "'";
		$result = $this->chatConn->query($queryStr);
		$count = $result->num_rows;
		
		return ($count > 0 ? true : false);
	}
	
	public function addNewVisitor($user)
	{
		$queryStr = "INSERT INTO visitors (user) VALUES ('" . $user . "')";
		return $this->chatConn->query($queryStr);
	}
	
	public function getAllVisitors()
	{
		$queryStr = "SELECT * FROM visitors ORDER BY id";
		$result = $this->chatConn->query($queryStr);
		return $result;
	}
	
	public function removeVisitor($user)
	{
		$queryStr = "DELETE FROM visitors WHERE user='" . $user . "'";
		return $this->chatConn->query($queryStr);
	}
}

?>