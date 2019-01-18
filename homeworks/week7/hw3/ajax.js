$(document).ready(function(){

	//AJAX 新增留言
	$('#topBlock_addmsg').on('click','.msgBTN', function(e){

		let contentArea = $(e.target).siblings('textarea[name="content"]');

		if( !contentArea.val() ){ //送出 msg 前檢查
			contentArea.attr('placeholder','要在這邊留言啦');
			return
		}else{ //送出

			let content = contentArea.val()

			$.ajax({
				method:"POST",
				url:"./sent.php",
				data:{
					content
				},
				dataType:"json"

			}).done(function(response){	

				if(nowPageNum === 1){ 
					contentArea.val(''); //清空 teatarea
					contentArea.attr('placeholder','再留個言啊');
					console.log(response)
					addMsgBlock(response); //在第一頁 -> 前端新增 msgBlock

				}else{ //不在第一頁 -> 跳回第一頁（查看新留言）
					window.location.href = './index.php';
				}

			}).fail(function(){
				alert('留言GG')
			})
		}
	})


	//AJAX 刪除留言
	$('body').on('click','.deleteBTN', function(e){

		let deleteFloor=$(e.target).attr('floorNum')
		console.log( deleteFloor)

		if(!confirm('蛤 真的要刪嗎？')) {
			return
		}else{
			$.ajax({
				method:"POST",
				url:"./sent.php",
				data:{
					deleteFloor
				},
				dataType:"json",
			}).done(function(response){
				$(e.target).parents('.msgContainer').hide(200)
				let prependedText=`
					<div style="display: inline-block;">
					 	<div class="pic"> ${deleteFloor}F</div>		
					</div> 	
					<span>此留言已被刪除</span> `
				$(`.msgBlock[floorNum=${deleteFloor}]`).prepend(prependedText)
			}).fail(function(){
				alert('刪除失敗')
			})
		}
	})

	//AJAX 新增回覆
	$('body').on('click','.replyBTN', function(e){

		let addReplyFloor = $(e.target).attr('floorNum'); //number => 回覆哪樓
		let contentArea = $(`input[floorNum="${addReplyFloor}"][name="content"]`); // X樓的回覆input

		if( !contentArea.val() ){ //送出 msg 前 檢查
			contentArea.attr('placeholder','你要講話啊~');
			return
		}else{ //送出

			$.ajax({
				method:"POST",
				url:"./sent.php",
				data:{
					replyContent:contentArea.val(),
					replyFloor:addReplyFloor
				},
				dataType:"json"
			}).done(function(response){
				contentArea.val(''); //清空 input
				contentArea.attr('placeholder','還有想說的嗎');
				addReplyBlock(response)

			}).fail(function(){
				alert('回覆失敗')
			})
		}
	})


	//AJAX 編輯留言
	$('body').on('click','.editBTN', function(e){

		let editFloor = $(e.target).attr('floornum') //number => 編輯哪樓
		let newContent = $(`#edit${editFloor} > textarea`); // 編輯X樓的textarea 中的字（準備送出）

		$.ajax({
			method:"POST",
			url:"./sent.php",
			data:{
				editFloor:editFloor,
				editContent:newContent.val()
			},
			dataType:"json"
		}).done(function(response){

			let oldContent = $(e.target).parents(`#edit${editFloor}`).prev()

			oldContent.fadeOut(100,function(){
				oldContent.text(newContent.val())
			}).fadeIn(200); //fadeIn新留言

			$(`#edit${editFloor}`).hide(200); //關掉編輯區
			$(`div[floornum="${editFloor}"] button[name="edit"]`).show(200); //顯示編輯按鈕

		}).fail(function(){
			alert('編輯失敗')
		})
	})
})



//新增  msgBlock
function addMsgBlock(response){
	//新增 msgBlock
	let prependMain=`	
		<div class="msgBlock bg" floorNum = ${response.floorNum} style="display:none;">
			<div class="msgContainer" >
				<!-- 樓主資訊 -->
				<div class="msgBlock_header">
					<div class="info">
						<div class="pic">${response.floorNum}F</div>
						<div>
							<div class="name">${response.username}</div>
							<div class="time">${response.created_at}</div>
						</div>
					</div>
					<button class="btn btn-primary" name="edit" onclick="openEdit(${response.floorNum})" >編輯</button> 
				</div>

				<!-- 樓主留言內容 -->
				<div class="msg">${response.content}</div>

				<!-- 編輯留言(這是ajax顯示的) -->
				<div class="editBlock" id="edit${response.floorNum}" style="display:none;">
					<div class="editTitle">
						編輯留言 
						<button class="btn btn-primary" name="cancelBTN" onclick="closeEdit(${response.floorNum})">取消</button>	
					</div>
					<!-- 改成 AJAX -->
					<textarea type="text" name="content">${response.content}</textarea>
					<div class="editBTN btn btn-primary" floorNum="${response.floorNum}">送出留言</div>
					<div class="deleteBTN btn btn-primary" floorNum="${response.floorNum}">刪除留言</div>
				</div> 
			</div> 
		</div> 	`
	$( `.msgBlock[floornum="${response.floorNum -1}"]` ).before( $(prependMain).fadeIn(800) );

	//新增 回覆區(已登入可留言區)
	let prependAddReply=`
		<div class="addreply" floorNum="${response.floorNum}" >
			<span>${response.username}</span>
			<input floorNum="${response.floorNum}" type="text" name="content" placeholder="回應..."/>
			<input class="replyBTN btn btn-primary" type="submit" value="送出" floorNum="${response.floorNum}" />
		</div> `
	$( `#edit${response.floorNum}` ).after( prependAddReply ); 	
}

//新增 replyBlock
function addReplyBlock(response){
	let prependReply=`
		<div class="singleReply" style="border: 2px solid #B3B3B3; box-sizing: border-box; display:none;" >
			<div>
				<span class="r_name">${response.username}</span>
				<span class="r_time">${response.created_at}</span>
			</div>	
			<span class="r_content">${response.content}</span>
		</div> `

	// 判斷新回覆的位置（考量有無編輯區）
	let floorName = $(`div[floornum="${response.floorNum}"] .name`).text() //樓主名

	if( response.username === floorName ){
		//樓主自己回覆自己 -> 新回覆加在編輯區下方
		$( `#edit${response.floorNum}` ).after( $(prependReply).fadeIn(800) );
	}else{
		//回覆在別人的樓 -> 新回覆加在樓主留言下方
		$( `div[floornum="${response.floorNum}"] .msg` ).after( $(prependReply).fadeIn(800) );		
	}
}