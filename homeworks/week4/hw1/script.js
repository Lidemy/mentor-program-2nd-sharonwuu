let firstNum = '' 
let secondNum = ''
let noOperation = '' 
	
document.querySelector('.allBtns').addEventListener("click", function (e) {
  let result = document.querySelector('.result') ;
  if( e.target.className === 'operation' ){
    firstNum = result.innerText
    if(e.target.id === 'plus') {noOperation='+'}
    if(e.target.id === 'minus') {noOperation='-'}
	if(e.target.id === 'times') {noOperation='*'}
	if(e.target.id === 'obelus') {noOperation='/'}
  }

  if(e.target.id === 'equal'){
  	secondNum = result.innerText
  	if(noOperation==='+'){result.innerText =  parseFloat(Number(firstNum)+Number(secondNum))}
  	if(noOperation==='-'){result.innerText =  parseFloat(Number(firstNum)-Number(secondNum))}
  	if(noOperation==='*'){result.innerText =  parseFloat(Number(firstNum)*Number(secondNum))}
  	if(noOperation==='/'){result.innerText =  parseFloat(Number(firstNum)/Number(secondNum))}
  }

  if (noOperation===''){
  	if( e.target.className === 'num' ){
  		if( result.innerText === '0' ){
  			result.innerText = e.target.innerText
  		}else{
			result.innerText += e.target.innerText
		}
	}
	if( e.target.id === 'point' && !result.innerText.includes('.')){
		result.innerText += e.target.innerText
	}
  }else if(noOperation!==''){ 
	if( e.target.className === 'num' ){
		if(result.innerHTML===firstNum){
			result.innerText = e.target.innerText
		}else{
			result.innerText += e.target.innerText
		}
	}
	if( e.target.id === 'point'){
		if(result.innerHTML===firstNum){
			result.innerText='0.'
		}else if(!result.innerText.includes('.')){
			result.innerText += e.target.innerText
		}			
	}
  }					

  if(e.target.id === 'AC'){
  	window.location.reload();
  } 
})

