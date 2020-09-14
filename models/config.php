<?php


class Config
{
	public static function getDBConnect()
	{
		$dsn = "mysql:host=localhost;dbname=MessageBoard;port=3306";
		$dbid = 'root';
		$dbpasswd = 'root';
		$dbh = new PDO($dsn, $dbid, $dbpasswd) or die(mysqli_connect_error());
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("SET CHARACTER SET utf8");
		return $dbh;
	}
}
