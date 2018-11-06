<?php
require("conn.php");
?>

<!DOCTYPE html>
<html>
	<head>
	 	<title>Sharon's 留言板</title>
	 	<meta charset="utf-8"/>
	 	<link rel="stylesheet" type="text/css" href="./style.css">
	 	<script type="text/javascript" src="./script.js"></script>
	</head>

	<body>
		<header> 留言板
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
				<div> <?php echo $_COOKIE['username']; ?> </div>
				<textarea type="text" name="content" placeholder="留言內容" ></textarea>
				<input class="msgBTN btns" type="submit" name="msgBTN" value="送出留言" />
			</form>					
		</div>

		<!--(登入中)輸入帳密-->
		<div id="topBlock_login" onsubmit="return checkLogin()" class="bg"> 登入
			<form method="POST" action="./sent.php">
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
				<input type="text" name="password" placeholder="password">
				<input class="btns" type="submit" name="signUpBTN" value="註冊">
			</form>
			<button class="btns" name="login" onclick="openLogin()" >有帳號登入</button>
			<button class="btns" name="visitor" onclick="openVisitor()" >我只是路人</button>	
		</div>
<!--/////////////// END topBlock ////////////////////-->


<?php // 判斷有無 cookie
	if(!isset($_COOKIE['username'])) {
	    echo "<script> openVisitor() </script>";
	}else{
		echo "<script> openAddmsg() </script>";
	}
?>

<?php
	 //頁碼控制
	if(empty($_POST['page'])){
		$pageNum = 1; //沒頁碼（第一次到網頁 沒按頁碼的時候，預設在第一頁）
	}
	if(isset($_POST['page'])){ //有按頁碼換頁
		$pageNum = $_POST['page']; //現在第幾頁
	}

	//開始抓各頁留言
	$limitWith = ($pageNum-1)*10;
	$msgSQL = "SELECT * FROM sharon_comments ORDER BY sharon_comments.postTime DESC LIMIT $limitWith,10";
	$msgResult = $conn->query($msgSQL);
	if ($msgResult->num_rows > 0){
		while($row = $msgResult->fetch_assoc()){
?>
<!--//////////////////////// 印出所有 msgBlock /////////////////////////-->

		<div class="msgBlock bg">
			<!-- 樓主資訊 -->
			<div class="info"> 
				<div class="pic"> <?php echo $row['id']."F" ?> </div>
				<div>
					<div class="name"> <?php echo $row['username'] ?> </div>
					<div class="time"> <?php echo $row['postTime'] ?> </div>
				</div>	
			</div>

			<!-- 樓主留言內容 -->
			<div class="msg"> <?php echo $row['content'] ?> </div>

	<!------------- 印出所有 reply -------------->
		<?php
			$replySQL = "SELECT * FROM sharon_replys WHERE floor='{$row["id"]}' ORDER BY sharon_replys.postTime DESC";
			$replyResult = $conn->query($replySQL);

			if ($replyResult->num_rows > 0){
				while($replyrow = $replyResult->fetch_assoc()){
		?>			
					<div class="singleReply">
						<div>
							<span class="r_name"> <?php echo $replyrow['username']; ?> </span>
							<span class="r_time"> <?php echo $replyrow['postTime']; ?> </span>
						</div>	
						<div class="r_content"> <?php echo $replyrow['content']; ?> </div> 	
					</div>
		<?php			
				}
			}	
		?>
	<!------------- 登入按鈕 or 新增回應 -------------------->
		<?php 
			if(!isset($_COOKIE['username'])) {
		?>
				<!--（沒登入）登入按鈕 -->
				<div class="loginToreply">
					<button class="btns" name="gologin"  onclick="openLogin()" >登入留言</button>
				</div>
		<?php				
			} else { 
		?>	
				<!-- （已登入）新增回應  --> 
				<form class="addreply" method="POST" onsubmit="return checkReply(<?php echo $row['id']; ?>)" action="./sent.php">
					<input type="hidden" name="floor" value="<?php echo $row['id']; ?>" /> <!--紀錄是幾樓的回應-->
					<span> <?php echo $_COOKIE['username']; ?> </span>
					<input id="<?php echo 'F'.$row['id']; ?>" type="text" name="content" placeholder="回應..."/>
					<input class="replyBTN btns" type="submit" name="replyBTN" value="送出" />
				</form>
		<?php
			}
		?>
		</div>
	<?php
		}
	}
	?>
<!--//////////////////////// END msgBlock ////////////////////////////////////////////-->


<!--//////////////////////// Pages ////////////////////////////-->
		<?php //這串只是想印出留言總數
			$pageSQL = "SELECT COUNT(id) as total FROM sharon_comments";
			$pageResult = $conn->query($pageSQL)->fetch_assoc();
			$total = $pageResult['total']; //留言總數
		?>

		<form id="pages" method="POST">
			<!-- JS countPage() 計算頁碼、新增 -->
		</form>

		<script type="text/javascript">
			countPage (<? echo $total;?>)
			let nowPageNum = (<? echo $pageNum;?>) //標示目前頁碼
			document.querySelector(`#pages input[value="${nowPageNum}"]`).style.backgroundColor = "#E6E6E6"; 
		</script> 
	</body>
</html>