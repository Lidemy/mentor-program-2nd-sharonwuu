
function join(str, concatStr) {
	let joinAns = '';
	for (i = 0 ; i < str.length ; i++){
		joinAns = joinAns + str[i] + concatStr 
	}
	if(concatStr){
		return joinAns.substr(0,joinAns.length-1)
	}else{
		return joinAns
	}
}

//console.log(join([1, 2, 3], ''))
//console.log(join(["a", "b", "c"], "!"))
//console.log(join(["a", 1, "b", 2, "c", 3], ','))



function repeat(str, times) {
	let repAns = '';
	for (i = 0 ; i < times ; i++) {
		repAns += str
	}
	return repAns
}

//console.log(repeat('a', 5))
//console.log(repeat('yoyo', 2))