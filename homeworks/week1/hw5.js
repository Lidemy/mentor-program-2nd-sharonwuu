
function join(str, concatStr) {
	let joinAns = '';
	for (i = 1 ; i < str.length ; i++){
		joinAns = joinAns + concatStr + str[i]
	}
	return str[0] + joinAns
	
}

//console.log(join([1, 2, 3], ''))
//console.log(join(["a", "b", "c"], "!"))
//console.log(join(["a", 1, "b", 2, "c", 3], ','))
console.log(join([1,2,3], '!!!'))


function repeat(str, times) {
	let repAns = '';
	for (i = 0 ; i < times ; i++) {
		repAns += str
	}
	return repAns
}

//console.log(repeat('a', 5))
//console.log(repeat('yoyo', 2))