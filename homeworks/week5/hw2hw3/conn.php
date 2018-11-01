<?php //前置連線
	$servername = "";
	$username = "";
	$password = "";
	$dbname = ""; //database名稱

	$conn = new mysqli($servername, $username, $password, $dbname);
			//Open a new connection to the MySQL server

	if($conn->connect_error){
		die("連線失敗：" . $conn->connect_error);
	} //如果連線失敗($conn->connect_error)，die()輸出失敗訊息，並停止這個php

	$conn->query("SET NAMES 'UTF8' ");
	$conn->query(" SET time_zone= '+08:00' ");
?>