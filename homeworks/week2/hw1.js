function stars(n) {
  let starA=['*'] 
  for (let i = 1 ; i < n ; i++ ){
	starA[i] = starA[i-1]+'*'
  } 
  return starA
}

module.exports = stars;