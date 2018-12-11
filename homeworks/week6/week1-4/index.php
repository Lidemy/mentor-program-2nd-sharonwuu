<?php require_once("conn.php"); ?>

<!DOCTYPE html>
<html>
	<head>
	 	<title>Sharon's 留言板2.0</title>
	 	<meta charset="utf-8"/>
	 	<link rel="stylesheet" type="text/css" href="./style.css">
	 	<script type="text/javascript" src="./script.js"></script>
	</head>

	<body>
		<header> 留言板 2.0
			<div>
				<div>
					<button class="btns" name="login" onclick="openLogin()" >登入</button>
					<button class="btns" name="signUp" onclick="opensignUp()" >註冊</button>
				</div>
				<form method="POST" action="./sent.php">
					<input class="logoutBTN btns" type="submit" name="logoutBTN" value="登出" >
				</form>
			</div>	
		</header>

<!--/////////////// topBlock 依照瀏覽者身份 判斷要出現的區塊 ///////////-->

		<div id="top"></div> <!--置頂tag-->

		<!--（未登入）路人選擇-->
		<div id="topBlock_visitor">
			<div class="bg" >
				<div>
					<button class="btns" name="login" onclick="openLogin()" >登入</button>
					<button class="btns" name="signUp" onclick="opensignUp()" >註冊</button>
				</div>
				<button class="btns" name="visitor" onclick="openNone()" >我只是路人 不要逼我</button>	
			</div>
		</div>

		<!--(已登入)可新增留言-->
		<div id="topBlock_addmsg" class="bg" >
			<form method="POST" onsubmit="return checkMsg()" action="./sent.php"  >
				<div> <?php echo $currentUser; ?> </div>
				<textarea type="text" name="content" placeholder="留言內容" ></textarea>
				<input class="msgBTN btns" type="submit" name="msgBTN" value="送出留言" />
			</form>					
		</div>

		<!--(登入中)輸入帳密-->
		<div id="topBlock_login" class="bg"> 登入
			<form method="POST" onsubmit="return checkLogin()" action="./sent.php">
				<input type="text" name="username" placeholder="username">
				<input type="password" name="password" placeholder="password">
				<input class="btns" type="submit" name="loginBTN" value="登入" >
			</form>
			<button class="btns" name="signUp" onclick="opensignUp()" >沒帳號註冊</button>
			<button class="btns" name="visitor" onclick="openVisitor()" >我只是路人</button>	
		</div>

		<!--(註冊中)-->
		<div id="topBlock_signUp" class="bg"> 註冊
			<form method="POST" onsubmit="return checkSignUp()" action="./sent.php" >
				<input type="text" name="username" placeholder="username">
				<input type="password" name="password" placeholder="password">
				<input class="btns" type="submit" name="signUpBTN" value="註冊">
			</form>
			<button class="btns" name="login" onclick="openLogin()" >有帳號登入</button>
			<button class="btns" name="visitor" onclick="openVisitor()" >我只是路人</button>	
		</div>
<!--/////////////// END topBlock ////////////////////-->

<?php // 判斷有無 cookie、判斷 topBlock
	if(isset($_COOKIE['sessionID']) && !empty($_COOKIE['sessionID']) ) {
	    echo "<script> openAddmsg() </script>";
	}else{
		echo "<script> openVisitor() </script>";
	}
?>

<?php
	 //頁碼控制
	if(!isset($_GET['page'])){
		$pageNum = 1; //沒頁碼（第一次到網頁 沒按頁碼的時候，預設在第一頁）
	}
	if(isset($_GET['page'])){ //有按頁碼換頁
		$pageNum = $_GET['page']; //現在第幾頁
	}

	//開始抓各頁留言
	$limitWith = ($pageNum-1)*10;
	$msgSQL = " SELECT *
				FROM sharon_Comments
				WHERE parents_id = 0
				ORDER BY created_at DESC
				LIMIT $limitWith,10 ";

	$msgResult = $conn->query($msgSQL);
	if ($msgResult->num_rows > 0){
		while($row = $msgResult->fetch_assoc()){
			if($row['username'] !== NULL){
				include("msg.php");
			}else{
				include("deleted.php");
			}
		}
	}
?>

<!--//////////////////////// Pages ////////////////////////////-->
		<?php //留言總數
			$pageSQL = "SELECT COUNT(floorNum) as total FROM sharon_Comments WHERE parents_id=0";
			$pageResult = $conn->query($pageSQL)->fetch_assoc();
			$total = $pageResult['total'];
		?>

		<form id="pages" method="GET">
			<!-- JS countPage() 計算頁碼、新增 -->
		</form>

		<script type="text/javascript">
			countPage (<? echo $total;?>)
			let nowPageNum = (<? echo $pageNum;?>) //標示目前頁碼
			document.querySelector(`#pages input[value="${nowPageNum}"]`).style.backgroundColor = "#E6E6E6"; 
		</script> 
	</body>
</html>