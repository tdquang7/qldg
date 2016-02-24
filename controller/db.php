<?php

require_once("LoginResult.php");
require_once("VisitInfo.php");
require_once("MajorInfo.php");

class DB
{
	public static $server = "localhost";
	public static $database = "qldg";
	public static $dbUser = "root";
	public static $dbPass = "";	
	
	public static function Login($username, $password) //: LoginResult
	{
		$result = new LoginResult();
		
		$connection = new mysqli(self::$server, self::$dbUser, self::$dbPass, self::$database);
		if ($connection->connect_error) {
			die("Connection failed: " . $connection->connect_error);
		}
		
		$username = $connection->real_escape_string($username);
		$password = $connection->real_escape_string($password);
		
		$sql = "select * from user where username='$username' and password='$password'";
		
		$connection->query("set names 'utf8'");
		$reader = $connection->query($sql);				
		
		if ($reader->num_rows > 0)
		{
			$row = $reader->fetch_assoc();
			$result->Username = $username;
			$result->Success = true;
			$result->RoleName = $row["rolename"];
		}
				
		$connection->close();
		return $result;
	}
	
	public static function GetTodayVisits() //: VisitInfo
	{
		$result = array();
		
		$connection = new mysqli(self::$server, self::$dbUser, self::$dbPass, self::$database);
		if ($connection->connect_error) {
			die("Connection failed: " . $connection->connect_error);
		}
		
		$sql = "select * from Visit where year(now()) = year(timestamp) and month(now()) = month(timestamp) and day(now()) = day(timestamp) order by timestamp desc";
		
		$connection->query("set names 'utf8'");
		$reader = $connection->query($sql);
		
		if ($reader->num_rows > 0)
		{
			while ($row = $reader->fetch_assoc())
			{
				$vid = $row["visitid"];
				$studentid = $row["studentid"];
				$major = $row["major"];
				$date = $row["timestamp"];
				
				$item = new VisitInfo($vid, $studentid, $major, $date);
				
				array_push($result, $item);
			}
		}
		
		$connection->close();
		
		return $result;
	}	
	
	// Lấy tất cả các ngành học 
	public static function GetAllMajors()
	{
		$result = array();
		
		$connection = new mysqli(self::$server, self::$dbUser, self::$dbPass, self::$database);
		if ($connection->connect_error) {
			die("Connection failed: " . $connection->connect_error);
		}
		
		$sql = "select * from Major";
		
		$connection->query("set names 'utf8'");
		$reader = $connection->query($sql);
		
		if ($reader->num_rows > 0)
		{
			while($row = $reader->fetch_assoc())
			{
				$id = $row["majorid"];
				$code = $row["code"];
				$name = $row["majorname"];
				
				$item = new MajorInfo($id, $code, $name);
				
				array_push($result, $item);
			}	
		}
		
		$connection->close();
		
		return $result;
	}
}
	
?>