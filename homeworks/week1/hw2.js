function capitalize(str) {
	let a=str.split('') 
	if(a[0]!==a[0].toUpperCase()){
    	a[0]=a[0].toUpperCase()
    	return  a.join('')
    }else{
    	return str
    }

  }


//console.log(capitalize('nick'))
//console.log(capitalize('Nick'))
//console.log(capitalize(',hello'))
