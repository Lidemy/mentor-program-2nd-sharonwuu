<div class="msgBlock bg">
<!------------- 印出 主留言(沒被刪除的) -------------->
	<!-- 樓主資訊 -->
	<div class="msgBlock_header">
		<div class="info">
			<div class="pic"> <?php echo $row['floorNum'] ."F" ?> </div>
			<div>
				<div class="name"> <?php echo $row['username'] ?> </div>
				<div class="time"> <?php echo $row['created_at'] ?> </div>
			</div >
		</div>

		<?php //樓主才出現 editBTN
		if($row['username']===$currentUser){
		?>
			<button class="btns" name="edit" onclick="openEdit(<?php echo $row['floorNum']; ?>)" >編輯</button> 
		<?php
		}
		?>
	</div>

	<!-- 樓主留言內容 -->
	<div class="msg"> <?php echo htmlspecialchars( $row['content'] , ENT_QUOTES , 'UTF-8' ); ?> </div>

	<!-- 編輯主留言（依 currentUser，樓主才有 editBlock）-->
	<?php
	if($row['username'] === $currentUser){
	?>	
		<div class="editBlock" id="<?php echo 'edit'.$row['floorNum']; ?>" style="display:none;">
			<div class="editTitle">
				編輯留言 
				<button class="btns" name="cancelBTN" onclick="closeEdit(<?php echo $row['floorNum']; ?>)">取消</button>	
			</div>

			<form  method="POST" action="./sent.php">
				<textarea type="text" name="content"><?php echo $row['content'] ?></textarea>
				<input type="hidden" name="floor" value=" <?php echo $row['floorNum']; ?>" /> <!--更新幾樓的留言內容 -->
				<div>
					<input class="editBTN btns" type="submit" name="editBTN" value="送出留言" />
					<input class="deleteBTN btns" type="submit" name="deleteBTN" value="刪除留言" />
				</div>
			</form>
		</div>	
	<?php
	}
	?>

<!------------- 印出 reply -------------->
	<?php
	$replySQL = " SELECT *
		FROM sharon_Comments
		WHERE parents_id ='{$row["floorNum"]}'
		ORDER BY created_at DESC ";
	$replyResult = $conn->query($replySQL);
	if ($replyResult->num_rows > 0){
		while($replyrow = $replyResult->fetch_assoc()){
	?>
			<div class="singleReply"
				<?php //樓主的留言 變色
				if($replyrow['username']===$currentUser){
					 echo "style=\" border: 2px solid #B3B3B3; box-sizing: border-box;\" ";
				}
				?>
			>
				<div>
					<span class="r_name"> <?php echo $replyrow['username']; ?> </span>
					<span class="r_time"> <?php echo $replyrow['created_at']; ?> </span>
				</div>	
				<div class="r_content"> <?php echo htmlspecialchars( $replyrow['content'] , ENT_QUOTES , 'UTF-8' ); ?> </div>
			</div>
	<?php			
		}
	}	
	?>

<!------------- 登入按鈕 or 新增回應 -------------------->
	<?php 
	if(!isset($_COOKIE['sessionID'])) {
	?>
		<!--（沒登入）登入按鈕 -->
		<div class="loginToreply">
			<button class="btns" name="gologin"  onclick="openLogin()" >登入留言</button>
		</div>
	<?php				
	}else{ 
	?>	
		<!-- （已登入）新增回應  --> 
		<form class="addreply" method="POST" onsubmit="return checkReply(<?php echo $row['floorNum']; ?>)" action="./sent.php">
			<input type="hidden" name="floor" value="<?php echo $row['floorNum']; ?>" /> <!--紀錄是幾樓的回應-->
			<span> <?php echo $currentUser; ?> </span>
			<input id="<?php echo 'F'.$row['floorNum']; ?>" type="text" name="content" placeholder="回應..."/>
			<input class="replyBTN btns" type="submit" name="replyBTN" value="送出" />
		</form>
	<?php
	}
	?>
</div>	