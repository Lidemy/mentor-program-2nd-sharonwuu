<?php //前置連線
	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if($conn->connect_error){
		die("連線失敗：" . $conn->connect_error);
	}

	$conn->query("SET NAMES 'UTF8' ");
	$conn->query(" SET time_zone= '+08:00' ");
?>

<?php

	session_start();

	// 判斷有無 session  -> 取得 username 
	if( isset($_SESSION['user']) && !empty($_SESSION['user'])){
		$currentUser = $_SESSION['user'];
	}else{
		$currentUser = '';
	}
?>