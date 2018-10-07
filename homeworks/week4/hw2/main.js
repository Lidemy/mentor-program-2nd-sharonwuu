let ans1 = '' 
let ans2 = document.querySelector('input[name="nickName"]')
let ans3 = ''
let ans4 = document.querySelector('input[name="job"]')
let ans5 = document.querySelector('input[name="codeExp"]')
let ans6 = document.querySelector('input[name="other"]')

//ans1 判斷 Email 格式
function checkEmail(){
	let email=document.querySelector('input[name="email"]')
	if( !email.value ){ //沒作答
		hasError(1);
		document.querySelector(`#block1 .errorMsg`).innerText='這是必填問題';
	}else{ 
		if( !email.value.includes('@' , [1]) || !email.value.includes('.com') ){ //有作答，格式錯
			hasError(1)	
			document.querySelector(`#block1 .errorMsg`).innerText='這不是 Email';
		}else{
			noErroer(1)
			ans1 = email //ans1 true
		}
	}
}

//ans3 判斷選擇題
function applyType(){
	let typeA = document.querySelector('input[value="基礎班"]')
	let typeB = document.querySelector('input[value="加強班"]')
	if(!typeA.checked && !typeB.checked){
		ans3 = ''
	}else{
		typeA.checked ?	ans3 = typeA : ans3 = typeB
	}
}

//show errorMsg
function hasError(num){ 
	document.querySelector(`#block${num}`).style.backgroundColor='#ffeaea';
	document.querySelector(`#block${num} .errorMsg`).style.display="block";
	if( num !== 3 ){
		document.querySelector(`#block${num} input`).style.borderBottom= '1.5px solid  #e01212';
	}
}
function noErroer(num){
	document.querySelector(`#block${num}`).style.backgroundColor='white';
	document.querySelector(`#block${num} .errorMsg`).style.display='none';
	if( num !== 3 ){
		document.querySelector(`#block${num} input`).style.borderBottom= '1px solid  #b9b9b9';
	}
}

//確定要不要送出
function checkAns() {
	checkEmail()
	applyType()
	for(let i=1 ; i<6 ;i++){ 
		!eval(`ans${i}`).value ? hasError(i) : noErroer(i)	
	}
	
	//都有作答
	if(ans1.value && ans2.value && ans3.value && ans4.value && ans5.value){
		for(let i=1 ; i<6 ;i++){ 
			console.log(eval(`ans${i}`).name,'：',eval(`ans${i}`).value)
			noErroer(i)
		}
		console.log(ans6.name,'：',ans6.value)
		alert(' 完成了 ya~')
		return true
	}else{
		return false
	}
}