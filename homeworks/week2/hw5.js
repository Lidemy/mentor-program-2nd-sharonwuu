function add(a, b) {
  let aNew =  a.padStart(b.length,"0")
  let bNew =  b.padStart(a.length,"0") 

  if ( a.length > b.length){
    aNew = a
    bNew =  b.padStart(a.length,"0")
  }else if( a.length < b.length ){
    aNew = a.padStart(b.length,"0")
    bNew = b
  }
  //判斷長短 不一樣長補0   console.log(aNew,bNew)

  let aArray = aNew.split('') ;
  let bArray = bNew.split('');  
  //字串數字轉成陣列 console.log(aArray,bArray) 

  let finalArray = ['0'];
  for( let i=0 ; i<aArray.length ; i++ ){
    finalArray[i] = String( Number(aArray[i])+Number(bArray[i]) )
  }
  // 陣列各項相加 console.log(finalArray)

  for( let i=finalArray.length-1 ; i>0 ; i-- ){
    if (finalArray[i].length !== 1){
      finalArray[i] = String( Number(finalArray[i]-10) )
      finalArray[i-1] = String( Number(finalArray[i-1])+1) 
    }
  }
  return  finalArray.join('')
}

module.exports = add;