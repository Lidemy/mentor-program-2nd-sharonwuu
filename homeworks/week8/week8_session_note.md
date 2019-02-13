## 通行證機制改成 php session 
> 第一反應是 Session 之前不是已經設過了嗎？！

#### 回顧 wk6-8 的作業說明和留言板的程式碼
- week6：作業說明「hw3：通行證」還真的都沒提到 Session XD

	1. 為了防止密碼存明碼在資料庫，註冊時用 `password_hash()` 產生一組亂碼，存入資料庫的密碼欄位
	2. 登入驗證時，用 `password_varify()` 比對資料庫中的亂碼密碼是否相符
	3. **通行證**：成功登入後，用 uniqid 產生一組 ID 作為臨時通行證，把 ID 作為 session 存在資料庫（Certificates），也存在瀏覽器的 cookie，確認身份

- week7：把部分功能改成 ajax
- week8：要把 wk6 的通行證機制，改成 php 的 session 功能 
	- 所以要改的只有原本的 uniqid 功能

#### week8 改 session 實作：
1. conn.php 加上 `session_start()`
2. 把原本 `function setSession` 裡面的功能 改成設定 php session，原本的 cookie 留著
	- 測試：新增留言（正常
	- 測試：cookie 改成別人的名字再新增留言，也一樣是用正確的 username 新增留言  
		-> 是抓 session 存的 username 新增留言的，所以改 cookie 不影響  
		-> 改不到 session 存的 username  
		-> cookie 好像沒有用了啊？
3. 刪掉 自己設定的 cookie  
	-> 變成只要設定 php session，刪掉原本的 `function setSession`  
4. 登出時要清除 session
5. 調整其他原本是用 cookie 判斷的功能，如 登入留言...

#### 突然想通的東西：
所以 wk6 「產出 uniqid 並存到 資料庫（Certificates）」這個步驟不是真正的 session 功能，只用不同的方式實作出 session 具備的功能；wk8 這個才是 session 的真正用法！

wk6 簡答題有提到「在會員系統中，Session 機制會在用戶完成身分認證後，存下所需的用戶資料，產生一組對應的 id，存入 cookie 後傳回用戶端。」

現在用了 PHP Session 之後，會 **自動** 回傳一組對應的 id 存到 cookie，所以不需要再自己設定 cookie 了（？
-> 用了 `session_start()` 之後，看到瀏覽器出現 cookie `PHPSESSID `，這個就是 session 自動存 cookie！