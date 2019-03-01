class Stack {
  constructor(){
    this.arr = []
  }
  push(num) {
    this.arr[this.arr.length] = num
  }
  pop() { //LIFO
    let last = this.arr[this.arr.length-1]
    this.arr.splice(this.arr.length-1 ,1)
    return last
  }
}

class Queue {
  constructor(){
    this.arr = []
  }
  push(num) {
    this.arr[this.arr.length] = num
  }
  pop() { //FIFO
    let first = this.arr[0]
    this.arr.splice(0 ,1)
    return first
  }
}


var stack = new Stack()
stack.push(10)
stack.push(5)
console.log(stack.pop()) // 5
console.log(stack.pop()) // 10


var queue = new Queue()
queue.push(1)
queue.push(2)
console.log(queue.pop()) // 1
console.log(queue.pop()) // 2



