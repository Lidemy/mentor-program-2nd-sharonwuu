function isPrime(n) {
  if( n===1){
    return false
  }else{
  	for( let i=2 ; i<n ; i++){
  		//console.log(`${n}除以${i}餘數是`,n%i)
  	  if ( n%i === 0){
  	    return false
  	  }	
	}
  }
  return true
}




module.exports = isPrime