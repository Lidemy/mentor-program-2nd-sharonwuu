## 1.請說明 SQL Injection 的攻擊原理以及防範方法
- 攻擊原理：    
  透輸入字串或是其他途徑，插入惡意字串影響原本的 SQL 指令，錯誤指令就會被 server 誤認為是正常的 SQL 指令而執行。

- 防範方法：Prepared Statement  
  Prepared Statement 會替 SQL 語句進行預處理，再將欲查詢的參數值或變數綁定上去。  
  執行時參數會以數值傳遞，因此參數不可能成為 SQL 指令的一部分，就不會產生 SQL Injection 的問題。
  
- 參考：https://zh.wikipedia.org/wiki/SQL%E8%B3%87%E6%96%99%E9%9A%B1%E7%A2%BC%E6%94%BB%E6%93%8A

## 2.請說明 XSS 的攻擊原理以及防範方法
- XSS，英文全稱「Cross-site Scripting」，中文譯為「跨網站指令碼」。

- 攻擊原理：  
惡意使用者利用網頁漏洞將程式碼注入到網頁上，其他使用者觀看網頁時就會受到影響。

- 防範方法：跳脫字元  
  使用 htmlentities() 或 htmlspecialchars() 對使用者輸入的內容執行跳脫處理，使內容的特殊符號轉換為僅能顯示的純符號，而非 HTML。

## 3.請說明 CSRF 的攻擊原理以及防範方法
- CSRF，英文全稱「Cross Site Request Forgery」，中文譯為「跨站請求偽造」。

- 攻擊原理：  
  透過欺騙用戶的瀏覽器，以用戶的名義存取用戶曾經認證過的網站並執行操作。  
  由於瀏覽器已經通過認證，瀏覽器發送 request 時會把相關的 cookie 一起發送，所以 server 會認為是真正的用戶在操作。

- 防範方法：
  - 使用者使用完網站就登出
  - 檢查 request header 中的 Referer，只接收合法 Domain 的資料
  - 圖形、簡訊驗證碼
  - 加上 CSRF token：  
      - 由 server 產生一組 csrftoken，存在 server 的 session 裡面，也放在 form 裡面，送出表單後，由 server 比對 csrftoken 是否一致  
      - 風險：如果 server 支持 cross origin 的 request，csrftoken 一樣可能被偷走
  - Double Submit Cookie：  
      - 由 server 產生一組 csrftoken，存在 cookie 裡面，也放在 form 裡面，送出表單後，由 server 比對兩個 csrftoken 是否一致

- 參考老師的文章XD：https://blog.techbridge.cc/2017/02/25/csrf-introduction/

## 4.請舉出三種不同的雜湊函數
1. SHA-256
2. RIPEMD-160
3. bcrypt

## 5.請去查什麼是 Session，以及 Session 跟 Cookie 的差別
- Cookie 存在 Client 端；Session 存在 Server 端。
- 在會員系統中，Session 機制會在用戶完成身分認證後，存下所需的用戶資料，產生一組對應的 id，存入 cookie 後傳回用戶端。

## 6.include、require、include_once、require_once 的差別
- require：
	- 通常放在 PHP 程式最前面，在執行其他程式前，就先引入 require 所指定的檔案，並且把自己本身代換成這些讀入的內容，使它變成 PHP 程式網頁的一部份。
	- 常用的函式可以寫成一個函式庫檔案，然後用這個方法將它引入網頁中，適合用來引入靜態的內容（如版權宣告）。
	- 引入的文件有錯誤時，require 會在錯誤發生後停止執行。

- include：
	- include 一般是放在流程控制的處理區段中。程式讀到 include 時，才將它讀進來。
	- include( ) 則適合用來引入動態的程式碼（程式內容會依其他程式碼而變動）。
	- 引入的文件有錯誤時，include 會在錯誤發生後繼續執行。

- require_once、include_once：
	- 在引入的檔案前，會先檢查有沒有被引入過，如果有的話，就不會再次重複引入該檔案。

- 參考：https://www.w3schools.com/php/php_includes.asp