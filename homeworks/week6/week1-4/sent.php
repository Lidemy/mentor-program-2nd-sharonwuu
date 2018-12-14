<?php require_once("conn.php"); ?>

<?php  //送出註冊
if(isset($_POST['signUpBTN'])){
	if( isset($_POST['username']) &&
		isset($_POST['password']) &&
		!empty($_POST['username']) &&
		!empty($_POST['password']) ){ //都有填
			$username = $_POST['username'];
			$password = password_hash($_POST['password'],PASSWORD_DEFAULT);
			$stmtSignUp = $conn->prepare("INSERT INTO sharon_Users(username,password) VALUES (?,?)");
			$stmtSignUp->bind_param("ss" , $username,$password);

			if ($stmtSignUp->execute()){
				//setcookie("username", $username, time()+3600*24);
				setSession($conn,$username);
				echo "<script type=\"text/javascript\">
						window.alert('註冊完成！！');
						window.location.href = './index.php';
					  </script>";
			}else{ //重複註冊
				echo "<script type=\"text/javascript\">
						window.alert('帳號已被使用，換個帳號');
						window.location.href = './index.php';
					  </script>";
			}			
	}else{
		echo "<script type=\"text/javascript\">
				window.alert('請完整輸入帳號密碼');
				window.location.href = './index.php';
			  </script>"; 
	}
}
?>

<?php //送出登入 查詢 ＆ 登入成功設置setcookie
if(isset($_POST['loginBTN'])){
	if( isset($_POST['username']) &&
		isset($_POST['password']) &&
		!empty($_POST['username']) &&
		!empty($_POST['password']) ){ //都有填
			$username = $_POST['username'];
			$password = $_POST['password'];

			$stmtLogin = $conn->prepare(" SELECT * FROM sharon_Users WHERE username=? ");
			$stmtLogin->bind_param("s" , $username);
			$stmtLogin->execute();

			$resultLogin = $stmtLogin->get_result();
			if ( $resultLogin->num_rows > 0){ //有這組帳號，驗證密碼
				$row =$resultLogin->fetch_assoc();
				$hash_password = $row['password'];
				if (password_verify($password,$hash_password)) {
					setSession($conn,$username);
					echo "<script type=\"text/javascript\">
							window.alert('登入成功 :D');
							window.location.href = './index.php';
						</script>";
				} else {
					echo "<script type=\"text/javascript\">
							window.alert('登愣 登入失敗');
							window.location.href = './index.php';
						</script>";	
				}
			}else{ //沒連上，或沒這個帳號
				echo "<script type=\"text/javascript\">
						window.alert('登愣 登入失敗');
						window.location.href = './index.php';
					</script>";
				exit();
			}
	}else{
		echo "<script type=\"text/javascript\">
				window.alert('請完整輸入帳號密碼');
				window.location.href = './index.php';
			  </script>"; 
	}
}
?>

<?php  //按下登出 重設 cookie
if(isset($_POST['logoutBTN'])){
	setcookie("sessionID", "", time()-3600*24); 
	echo "<script type=\"text/javascript\">
			window.alert('登出成功！ByeBye');
			window.location.href = './index.php';
		  </script>";
}
?>

<?php //如果登入成功，設定 Session
function setSession($conn,$username){
	$sessionID = uniqid();

	//先刪掉上次登入過的紀錄，再記這一次的
	$stmtSessionRM = $conn->prepare("DELETE FROM sharon_Certificates WHERE username=?");
	$stmtSessionRM->bind_param('s' , $username);
	$stmtSessionRM->execute();

	setcookie("sessionID", $sessionID, time()+3600*24);
	$stmtSession = $conn->prepare("INSERT INTO sharon_Certificates(username,sessionID) VALUES (?,?)");
	$stmtSession->bind_param('ss' , $username , $sessionID);
	$stmtSession->execute();
}
?>

<?php  //送出 msg 表單
if(isset($_POST['msgBTN'])){

	//這筆留言的floorNum = $maxFloorNum (當下總留言數 maxFloor +1)
	$sqlMaxFloor = "SELECT MAX(floorNum) AS maxFloor FROM sharon_Comments";
	$maxFloorResult = $conn->query($sqlMaxFloor)->fetch_assoc();
	$maxFloorNum = $maxFloorResult['maxFloor']+1; 
 
	$content = $_POST['content'];
	$username = $currentUser;
	$stmtInsert = $conn->prepare("INSERT INTO sharon_Comments(floorNum,parents_id,content,username) VALUES (?,'0',?,?)");
	$stmtInsert->bind_param("iss" ,$maxFloorNum,$content,$username);
	if ($stmtInsert->execute()){
		echo "<script type=\"text/javascript\">
				window.location.href = './index.php';
			  </script>";
	}else{
		echo "<div> fail </div>" . $stmtInsert . $conn->error;
	}
}
?>

<?php  //送出 reply 表單
if(isset($_POST['replyBTN'])){
	$floor = $_POST['floor'];
	$username = $currentUser;
	$content = $_POST['content'];
	$stmtInsert = $conn->prepare("INSERT INTO sharon_Comments(floorNum,parents_id,content,username) VALUES (Null,?,?,?)");
	$stmtInsert->bind_param("sss",$floor,$content,$username);
	if ($stmtInsert->execute()){
		echo "<script type=\"text/javascript\">
				window.location.href = './index.php';
			  </script>";
	}else{
		echo "<div> fail </div>" . $stmtInsert . $conn->error;
	}
}
?>

<?php
//送出 edit 表單
if(isset($_POST['editBTN'])){
	$floor = $_POST['floor'];
	$content = $_POST['content'];
	$stmtEdit = $conn->prepare("UPDATE sharon_Comments SET content=? WHERE floorNum=? ");
	$stmtEdit->bind_param("ss",$content,$floor);
	if ($stmtEdit->execute()){
		echo "<script type=\"text/javascript\">
				window.alert('更新完成!');
				window.location.href = './index.php';
			  </script>"; 
	}else{
		echo "<div> fail </div>" . $stmtEdit . $conn->error;
	}
}

//送出 delete 表單
if(isset($_POST['deleteBTN'])){
	$floor = $_POST['floor'];
	$stmtDelete = $conn->prepare(
				"UPDATE sharon_Comments 
				SET content = '此留言已被刪除' ,username = NUll
				WHERE floorNum=? ");
	$stmtDelete->bind_param('i',$floor);
	if ($stmtDelete->execute()){
		echo "<script type=\"text/javascript\">
				window.alert('已刪除留言');
				window.location.href = './index.php';
			  </script>"; 
	}else{
		echo "<div> fail </div>" . $stmtDelete . $conn->error;
	}
}
?>