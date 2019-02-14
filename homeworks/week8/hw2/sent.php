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
				
				$_SESSION['user']= $username;

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

<?php //送出登入 查詢 ＆ 登入成功設 session
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
					
					$_SESSION['user']= $username;

					echo "<script type=\"text/javascript\">
							window.alert('登入成功 :D');
							window.location.href = './index.php';
						</script>";
				}else{
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

<?php  //按下登出 清除 session
if(isset($_POST['logoutBTN'])){
	
	unset($_SESSION['user']);

	echo "<script type=\"text/javascript\">
			window.alert('登出成功！ByeBye');
			window.location.href = './index.php';
		  </script>";
}
?>



<?php  //送出 msg (ajax post json
if(
	isset($_POST['content']) &&
	!empty($_POST['content'])
){
	$sqlMaxFloor = "SELECT MAX(floorNum) AS maxFloor FROM sharon_Comments";
	$maxFloorResult = $conn->query($sqlMaxFloor)->fetch_assoc();
	$maxFloorNum = $maxFloorResult['maxFloor']+1; //這筆留言的 floorNum
 
	$content = $_POST['content'];
	$username = $currentUser;

	date_default_timezone_set("Asia/Taipei");
	$created_at = date("Y-m-d H:i:s"); 

	$stmtInsert = $conn->prepare("INSERT INTO sharon_Comments(floorNum,parents_id,content,username) VALUES (?,'0',?,?)");
	$stmtInsert->bind_param("iss",$maxFloorNum,$content,$username);

	if ($stmtInsert->execute()){
		//成功 回傳資訊（讓前端新增 msgBlock）
		$msgSQL = " SELECT floorNum,content,username,created_at
				FROM sharon_Comments WHERE floorNum = $maxFloorNum " ;
		$msgResult = $conn->query($msgSQL)->fetch_assoc();

		echo json_encode(array(
			'floorNum' => htmlspecialchars( $maxFloorNum , ENT_QUOTES , 'UTF-8' ),
			'username' => htmlspecialchars( $username , ENT_QUOTES , 'UTF-8' ),
			'content' => htmlspecialchars( $content , ENT_QUOTES , 'UTF-8' ),
			'created_at' => htmlspecialchars( $created_at , ENT_QUOTES , 'UTF-8' ),
		));
	}else{
		echo json_encode(array(
			'result' => 'failure',
			'message' => '留言失敗'
		));
	}
}
?>

<?php  //送出 reply 表單 (ajax post json
if(
	isset($_POST['replyContent']) && !empty($_POST['replyFloor']) &&
	isset($_POST['replyContent']) && !empty($_POST['replyFloor'])
){
	$floor = $_POST['replyFloor'];
	$username = $currentUser;
	$content = $_POST['replyContent'];

	date_default_timezone_set("Asia/Taipei");
	$created_at = date("Y-m-d H:i:s"); 

	$stmtInsert = $conn->prepare("INSERT INTO sharon_Comments(floorNum,parents_id,content,username) VALUES (Null,?,?,?)");
	$stmtInsert->bind_param("sss",$floor,$content,$username);
	if ($stmtInsert->execute()){
		//成功 回傳資訊（讓前端新增 replyBlock）
		$replySQL = " SELECT parents_id,content,username,created_at
			FROM sharon_Comments WHERE parents_id = $floor 
			ORDER BY created_at DESC ";
		$replyResult = $conn->query($replySQL)->fetch_assoc();

		echo json_encode(array(  
			'floorNum' => htmlspecialchars( $floor , ENT_QUOTES , 'UTF-8' ),
			'username' => htmlspecialchars( $username , ENT_QUOTES , 'UTF-8' ),
			'content' => htmlspecialchars( $content , ENT_QUOTES , 'UTF-8' ),
			'created_at' => htmlspecialchars( $created_at, ENT_QUOTES , 'UTF-8' ),
		));

	}else{
		echo json_encode(array(
			'result' => 'failure',
			'message' => '回覆失敗'
		));
	}
}
?>

<?php
//送出 edit 表單 (ajax post json
if(
	isset($_POST['editContent']) && !empty($_POST['editFloor']) &&
	isset($_POST['editContent']) && !empty($_POST['editFloor'])
){
	$floor = $_POST['editFloor'];
	$content = $_POST['editContent'];
	$stmtEdit = $conn->prepare("UPDATE sharon_Comments SET content=? WHERE floorNum=? ");
	$stmtEdit->bind_param("ss",$content,$floor);
	if ($stmtEdit->execute()){
		echo json_encode(array(  //成功 回傳資訊（讓前端更新留言內容）
			'username' => htmlspecialchars( $username , ENT_QUOTES , 'UTF-8' ),
			'content' => htmlspecialchars( $content , ENT_QUOTES , 'UTF-8' ),
		));
	}else{
		echo json_encode(array(
			'result' => 'failure',
			'message' => '編輯失敗'
		));
	}
}

//送出 delete 表單 (ajax post json
if( isset($_POST['deleteFloor']) && !empty($_POST['deleteFloor']) ){

	$floor = $_POST['deleteFloor'];

	//查詢 currentUser和要刪的樓層
	$stmt = $conn->prepare(" SELECT * FROM sharon_Comments WHERE floorNum=? AND username=? ");
	$stmt->bind_param('is',$floor,$currentUser);
	$stmt->execute();

	if( $stmt->get_result()->num_rows > 0 ){

		//確認可以刪除
		$stmtDelete = $conn->prepare(
					"UPDATE sharon_Comments 
					SET content = '此留言已被刪除' ,username = NUll
					WHERE floorNum=? ");
		$stmtDelete->bind_param('i',$floor);
		if ($stmtDelete->execute()){
			echo json_encode(array(
				'result' => 'success',
				'message' => '刪除成功'
			));
		}else{
			echo json_encode(array(
				'result' => 'failure',
				'message' => '刪除失敗'
			));
		}

	}else{
		//資料不對 不能刪
		echo json_encode(array(
			'result' => 'failure',
			'message' => '刪除失敗'
		));
	}
}
?>