<?php
require("conn.php");
?>

<?php  //送出註冊
	if(isset($_POST['signUpBTN'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sqlSignUp = "INSERT INTO sharon_users(username,password) VALUES ('$username','$password')";
		if ($conn->query($sqlSignUp)){
		echo "<script type=\"text/javascript\">
				window.alert('註冊完成！！');
				window.location.href = './index.php';
			  </script>"; 
		}
	}
?>

<?php //送出登入 查詢 ＆ 登入成功設置setcookie
if(isset($_POST['loginBTN'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$sqlLogin = " SELECT * FROM sharon_users WHERE username LIKE '$username' ";
	$resultLogin = $conn->query($sqlLogin);

	if ($resultLogin->num_rows > 0){ //有連線上 (ID正確、有登入)
		$row = $resultLogin->fetch_assoc();
		if($row['password'] === $password){ //檢查密碼正確與否
			echo '登入成功、帳號密碼正確!!';
			setcookie("username", $username, time()+3600*24);
			echo "<script type=\"text/javascript\">
					window.alert('登入成功 :D');
					window.location.href = './index.php';
				</script>";
		}else{
			echo "<script type=\"text/javascript\">
					window.alert('啊喔 密碼錯誤');
					window.location.href = './index.php';
				</script>";
			/*測試失敗 （這樣寫是抓到 sent.php 的 body 嗎 ?? -> 當然失敗XD）
				echo "<script type=\"text/javascript\">
						document.querySelector('body').style.backgroundColor=\"red\"
					</script>;  ";
				header("location: index.php"); */
		}
	}else{
		echo "<script type=\"text/javascript\">
				window.alert('登愣 無此帳號');
				window.location.href = './index.php';
			</script>";		
	}
}
?>


<?php  //按下登出 重設 cookie
if(isset($_POST['logoutBTN'])){
	setcookie("username", "", time()-3600*24); //登出也要設定時間嗎
	echo "<script type=\"text/javascript\">
			window.alert('登出成功！ByeBye');
			window.location.href = './index.php';
		  </script>";
}
?>


<?php  //送出 msg 表單
if(isset($_POST['msgBTN'])){
	$username = $_COOKIE['username'];
	$content = $_POST['content'];
	$sqlINSERT = "INSERT INTO sharon_comments(username,content) VALUES ('$username', '$content')";
	if ($conn->query($sqlINSERT)){
		echo "<script type=\"text/javascript\">
				window.alert('留言完成!');
				window.location.href = './index.php';
			  </script>";
	}else{
		echo "<div> fail </div>" . $sqlINSERT . $conn->error;
	}
}
?>

<?php  //送出 reply 表單
if(isset($_POST['replyBTN'])){
	$floor = $_POST['floor'];
	$username = $_COOKIE['username'];
	$content = $_POST['content'];
	$sqlINSERT = "INSERT INTO sharon_replys(floor,username,content) VALUES ('$floor', '$username', '$content')";
	if ($conn->query($sqlINSERT)){
		echo "<script type=\"text/javascript\">
				window.alert('回覆完成!');
				window.location.href = './index.php';
			  </script>"; 
	}else{
		echo "<div> fail </div>" . $sqlINSERT . $conn->error;
	}
}
?>