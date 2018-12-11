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

<?php // 判斷有無 cookie、取得 username 
	if(isset($_COOKIE['sessionID']) && !empty($_COOKIE['sessionID']) ) {
	    $stmt = $conn->prepare("SELECT username FROM sharon_Certificates WHERE sessionID=?");
	    $stmt->bind_param('s' , $_COOKIE['sessionID'] );
	    $stmt->execute();
	    $result = $stmt->get_result();
	    if($result->num_rows >= 0){
	    	$row = $result->fetch_assoc();
	    	$currentUser = $row['username'];
	    }
	}else{
    	$currentUser = '';
    }
?>