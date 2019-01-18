/* ---- 判斷身份 （topBlock 要顯示哪一個）----- */

	//路人-> 打開 visitorBlock
	function openVisitor(){
		document.querySelector('#top').scrollIntoView();
		document.querySelector('header div div').style.display="block";
		document.querySelector('header input').style.display="none";
		document.querySelector('#topBlock_visitor').style.display="block";
		document.querySelector('#topBlock_addmsg').style.display="none";
		document.querySelector('#topBlock_login').style.display="none";
		document.querySelector('#topBlock_signUp').style.display="none";
	}

	//路人堅持當路人-> 隱藏全部
	function openNone(){
		document.querySelector('#top').scrollIntoView();
		document.querySelector('header div div').style.display="block";
		document.querySelector('header input').style.display="none";
		document.querySelector('#topBlock_visitor').style.display="none";
		document.querySelector('#topBlock_addmsg').style.display="none";
		document.querySelector('#topBlock_login').style.display="none";
		document.querySelector('#topBlock_signUp').style.display="none";
	}

	//路人正要登入-> 打開 loginBlock
	function openLogin(){
		document.querySelector('#top').scrollIntoView();
		document.querySelector('header div div').style.display="block";
		document.querySelector('header input').style.display="none";
		document.querySelector('#topBlock_visitor').style.display="none";
		document.querySelector('#topBlock_addmsg').style.display="none";
		document.querySelector('#topBlock_login').style.display="block";
		document.querySelector('#topBlock_signUp').style.display="none";
	}

	//路人正要註冊-> 打開 signUpBlock
	function opensignUp(){
		document.querySelector('#top').scrollIntoView();
		document.querySelector('header div div').style.display="block";
		document.querySelector('header input').style.display="none";
		document.querySelector('#topBlock_visitor').style.display="none";
		document.querySelector('#topBlock_addmsg').style.display="none";
		document.querySelector('#topBlock_login').style.display="none";
		document.querySelector('#topBlock_signUp').style.display="block";
	}

	//已經登入-> 打開 addmsg
	function openAddmsg(){
		document.querySelector('#top').scrollIntoView();
		document.querySelector('header div div').style.display="none";
		document.querySelector('header input').style.display="block";
		document.querySelector('#topBlock_visitor').style.display="none";
		document.querySelector('#topBlock_addmsg').style.display="block";
		document.querySelector('#topBlock_login').style.display="none";
		document.querySelector('#topBlock_signUp').style.display="none";
	}
/* --------------- END 判斷身份 ---------------- */

// 編輯主留言-> 打開/隱藏 editBlock
function openEdit(id){
	$(`#edit${id}`).show(200);
	$(`div[floornum="${id}"] button[name="edit"]`).hide(200);
}
function closeEdit(id){
	$(`#edit${id}`).hide(200);
	$(`div[floornum="${id}"] button[name="edit"]`).show(200);
}

//登入前檢查
function checkLogin(){
	let username = document.querySelector('#topBlock_login input[name="username"]')
	let password = document.querySelector('#topBlock_login input[name="password"]')
	if( username.value && password.value ){
		return true
	}else{
		if( !username.value ){
			username.placeholder="請輸入帳號";
			username.style.backgroundColor = "white";
		}else{
			username.style.backgroundColor = "#E6E6E6";
		}
		if( !password.value ){
			password.placeholder="請輸入密碼";
			password.style.backgroundColor = "white";
		}else{
			password.style.backgroundColor = "#E6E6E6";
		}
		return false
	}
}

//註冊前檢查
function checkSignUp(){
	let username = document.querySelector('#topBlock_signUp input[name="username"]')
	let password = document.querySelector('#topBlock_signUp input[name="password"]')
	if( username.value && password.value ){
		return true
	}else{
		if( !username.value ){
			username.placeholder="請輸入帳號";
			username.style.backgroundColor = "white";
		}else{
			username.style.backgroundColor = "#E6E6E6";
		}
		if( !password.value ){
			password.placeholder="請輸入密碼";
			password.style.backgroundColor = "white";
		}else{
			password.style.backgroundColor = "#E6E6E6";
		}
		return false
	}
}


//計算頁碼
function countPage(total){
	let needPages = Math.ceil(total/10)
	for(let i=1 ; i<needPages+1 ; i++){
		let addPage = document.createElement('input')
		addPage.setAttribute('type' , 'submit')
		addPage.setAttribute('name' , 'page')
		addPage.setAttribute('class' , 'btn')
		document.querySelector('#pages').appendChild(addPage).value = i
		//<input type="submit" name="page" value="i"> 
	}
}

/* 寫在 ajax.js
	//送出 msg 前 檢查
	//送出 reply 前 檢查
*/