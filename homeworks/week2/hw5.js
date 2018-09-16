function add(a, b) {

  let aArray = []
  let bArray = []

  if ( a.length > b.length){
    aArray = a.split('') 
    bArray = b.padStart(a.length,"0").split('')
  }else if( a.length < b.length ){
    aArray = a.padStart(b.length,"0").split('')
    bArray = b.split('')
  }else if ( a.length === b.length){
    aArray = a.split('')
    bArray = b.split('')  
  }
 
  
  let finalArray = ['0'];
  for( let i=0 ; i<aArray.length ; i++ ){
    finalArray[i] = String( Number(aArray[i])+Number(bArray[i]) )
  }
  
  for( let i=finalArray.length-1 ; i>0 ; i-- ){
    if (finalArray[i].length !== 1){
      finalArray[i] = String( Number(finalArray[i]-10) )
      finalArray[i-1] = String( Number(finalArray[i-1])+1) 
    }
  }

  return  finalArray.join('')
}

module.exports = add;
