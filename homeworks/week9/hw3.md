## Event Loop

#### 請你說明以下程式碼會輸出什麼，以及盡可能詳細的解釋原因。

```
console.log(1)

setTimeout(() => {
  console.log(2)
}, 0)

console.log(3)

setTimeout(() => {
  console.log(4)
}, 0)

console.log(5)
```

#### 輸出結果：13524

#### 運作方式 & 原因

1. 新增 `console.log(1)` 到 call Stack
	- call Stack：`console.log(1)`
	- callback Queue：無

2. call Stack 執行 `console.log(1)`，完成後 `console.log(1)` 從 call Stack 移除
	- call Stack：無
	- callback Queue：無
	- Console： **1**

3. 	新增 第一個 `setTimeout(...)` 到 call Stack
	- call Stack：`setTimeout(...)`
	- callback Queue：無

4. call Stack 執行 `setTimeout(...)`，web api 建立 timer1，`setTimeout(...)` 從 call Stack 移除
	- call Stack：無
	- callback Queue：無
	- web api：timer1（0秒後可以執行 function1）
 
5. timer1 時間到後，function1 加到 callback Queue 等待執行
	- call Stack：無
	- callback Queue：`function1`
	 
	要等 call Stack 都沒東西要執行時，Event Loop 才會把 callback Queue 裡的事件放到 call Stack 裡執行，目前 call Stack 還有後續事件要執行，還沒輪到 callback Queue

6. 新增 `console.log(3)` 到 call Stack
	- call Stack：`console.log(3)`
	- callback Queue：`function1`
 
7. call Stack 執行 `console.log(3)`，完成後 `console.log(3)` 從 call Stack 移除
	- call Stack：無
	- callback Queue：`function1`
	- Console：1 **3**

8. 新增 第二個 `setTimeout(...)` 到 call Stack
	- call Stack：`setTimeout(...)`
	- callback Queue：`function1`

9. call Stack 執行 `setTimeout(...)`，web api 建立 timer2，`setTimeout(...)` 從 call Stack 移除
	- call Stack：無
	- callback Queue：`function1`
	- web api：timer2（0秒後可以執行 function2）
 
10. timer2 時間到後，function2 加到 callback Queue 等待執行
	- call Stack：無
	- callback Queue：`function1` **`function2`**

11. 新增 `console.log(5)` 到 call Stack
	- call Stack：`console.log(5)`
	- callback Queue：`function1``function2`

12. call Stack 執行 `console.log(5)`，完成後 `console.log(5)` 從 call Stack 移除
	- call Stack：無
	- callback Queue：`function1``function2`
	- Console：13 **5**

13. 這時候 call Stack 已經沒有事件要處理了，Event Loop 檢查到 call Stack 是空的，要從 callback Queue 把事件放到 call Stack 執行
	- call Stack：無
	- callback Queue：`function1``function2`
 
14. 根據 Queue 的處理方式 First In First Out，`function1` 會先被加到 call Stack，`function2` 繼續在 callback Queue 等待
	- call Stack：`function1`
	- callback Queue：`function2`
 
15. call Stack 執行 `function1`，新增 `console.log(2)`到 call Stack
	- call Stack：`function1` **`console.log(2)`**
	- callback Queue：`function2` 
 
16. `console.log(2)` 被執行，完成後從 call Stack 移除
	- call Stack：`function1`
	- callback Queue：`function2`
	- Console：135 **2**
	 
17. `function1`也執行完，從 call Stack 移除
	- call Stack：無
	- callback Queue：`function2`

18.  call Stack 再度沒事，Event Loop 檢查到 call Stack 是空的，把 callback Queue 中的`function2`加到 call Stack
	- call Stack：`function2`
	- callback Queue：無

19.  call Stack 執行 `function2`，新增 `console.log(4)`到 call Stack
	- call Stack：`function2` **`console.log(4)`**
	- callback Queue：無
 
20. `console.log(4)` 被執行，完成後從 call Stack 移除
	- call Stack：`function1`
	- callback Queue：無
	- Console：1352 **4**
	 
21. `function2`也執行完，從 call Stack 移除
	- call Stack：無
	- callback Queue：無

22. 全部執行完，輸出結果：13524



## 疑惑：Event Loop 的運作時機？

這個疑惑來自於謎樣的箭頭 XD  
在 Huli 用 `http://latentflip.com/loupe/...` 講解的時候，只有在要把 `timeout()` 從 callback Queue 傳到 call Stack 時，Event Loop 的橘色箭頭 🔄 才會轉圈，當下就出現「所以 Event Loop 現在才在運作（轉圈）喔？」的疑惑

後來看參考文章和影片、重新想想後，得到以下結論：

1. 在上面 1-21 整個過程中，Event Loop 是一直都在運作的（不斷的檢查 Stack 是否為空），Huli 也有提到會一直 Loop，所以才叫「Loop」-> 箭頭轉圈的意思應該是「我檢查到 Stack 為空了！」
  
2. 從 js 開始執行時，Event Loop 就會運作，無論有沒有 setTimeout 這類的非同步事件

但是總覺得沒有非同步事件的時候 Event Loop 也一直運作，好像有點浪費體力XD

還是 Stack 處理到非同步事件時，Event Loop 才會啟動，如果都沒有碰到非同步事件，Event Loop 就不會運作。




