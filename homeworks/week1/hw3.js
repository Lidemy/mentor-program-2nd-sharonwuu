function reverse(str) {
   let strArray =[] ;   
   for(let i=str.length-1;i>=0;i--){
     strArray.push(str[i])
   }

  console.log(strArray.join(''))
}

//reverse('yoyoyo')
//reverse('1abc2')
//reverse('1,2,3,2,1')