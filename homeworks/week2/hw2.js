
function alphaSwap(str) {
  let ans = '';
    for (let i = 0 ; i<=str.length-1 ; i++ ){
 	str[i] === str[i].toUpperCase() ? 
 	ans += str[i].toLowerCase():ans += str[i].toUpperCase()
  	}
  return ans	
}

module.exports = alphaSwap ;
