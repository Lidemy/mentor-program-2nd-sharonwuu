## 邊寫作業邊紀錄：

#### 未解決
1. Php 和 html 寫在一起，有沒有程式先後順序的問題？
  （把送出表單的 php 寫在最上面，但表單在下面一樣可以送出，不會顯示 form undefined 之類的 error）
2. 檢查表單有沒有正確填寫或是是否為空，用 php 還是 js 都可以達到目的，不知道用哪一種比較好？ <br>
    目前對 js 比較熟，所以用 js，不知道實務上兩種寫法有什麼差異
3. SQL 資料庫 不太懂寫死的意思，不是都一樣可以用CRUD更改內容嗎？
4. Php 裡的 exit  可有可無？不管有沒有 exit 都蠻正常的樣子
5. Cookie 登出也要設定時間嗎？感覺不用或是設為0就好，但看到有網站說設為空值之後「時間也一併減掉比較保險」不知道原因。<br>
    可以理解有cookie的時候限制時間，但設為空值後，就把原本的cookie取代掉了，為啥還要減掉？
6. 目前在 sent.php 裡面要 使用 JS 只用 `window alert`做出反饋（只會這招XD） <br>
    想在 sent.php 裡面能呼叫 script.js 內的 function，才不會都只用 alert QAQ  <br>
    （目前測試失敗：把 alert 以外的 js 程式碼放到 echo”<script>...”;  就會失敗）。  <br>
    例如在「送出登入 查詢」判斷密碼錯誤或無此帳號時，能直些反應在表單（像 google 表單那樣），不要用醜醜的 alert！
7. 還沒做到判斷有無重複註冊的功能

--------------------------------------------------------------------  
#### 已解決
  
1. 🆗 判斷有沒有送出表單用： isset()
    1. `isset($_POST[‘AAA’])`，AAA 是表單的按鈕 name !!!!
    2. !isset 跟 empty 的差別（判斷留言板有無 cookie 、控制頁碼的時候）
    3. 參考：https://ithelp.ithome.com.tw/articles/10156786
    
2. 🆗 送出表單後 導向其他頁面或重新刷新
    1. `header("location: mixx.php"); ` 但送出表單後，重新整理會重複送出
    2. 用 js alert 跳出訊息，再導回留言板：` echo “<script type=\"text/javascript\"></script>”; `

    🆗 type 內的 \ 是？ <br>
    「跳脫字元」echo 用引號包住要印出的東西，但 js 內有引號存在的話會影響 echo 判斷內容範圍，所以要用 \ 當隱形斗篷，讓 php 看不到引號

3. 🆗 Php 語法 計算 array 長度：`count($array);`
4. 🔼 `innerHTML`和`createElement` 的差異 <br>
    之前寫實況作業，用 innerHTML 新增的 html tag 並不會真的顯示在 .html 檔案裡面（所以css都搭不上），所以後來改用 createElement。<br>
    但是 createElement 生成 div 之後，div 裡面的東西也還是用 innerHTML 插入的 ??? <br>
    這邊用 innerHTML 插入的就搭得到 css ????? 為甚麼偏心 :| <br>
    參考：https://www.cnblogs.com/JeasonZhao/archive/2007/11/14/958759.html  <br>
    還沒很懂，大致知道和 DOM 有關，暫時先這樣XD
5. 🆗SQL排序 時間順序語法`SELECT * FROM main_msgs ORDER BY main_msgs.postTime DESC`  <br>
    `SELECT * FROM main_msgs ORDER BY main_msgs.postTime ASC`  <br>
6. 🆗原本想得太複雜了：把資料抓出來之後再放到 js 用回圈印出每一筆資料。搞半天才發現用 php 就可以了XD
7. 🆗 Html class和 id 不能用數字開頭！！！！
8. 🆗分頁，不能自動抓10筆資料，要每一頁設定要抓的 id ??  <br>
    已解決，本來用 limit 抓最新的10筆資料就是對的，一直糾結在要抓第1-10筆..蠢  <br>
9. 🆗 SQL：in 查數字；like 查文字
10. 🆗 滑到頁中的時候，按 navbar 的按鈕或登入留言，要移到置頂 topBlock 才看得到登入區塊
    1. `window.location.hash`可以，但刷新頁面會有問題（不知為何）
    2. DOM的「balabala.scrollIntoView()」可以，但用原有的 topBlock 置頂後會被 fixed navbar 蓋住一部分
    3. 新增一個 div，在 topBlock 上、蓋在 navbar 下，用 scrollIntoView() 置頂這個 div
11. 🆗路人時目前頁碼會正確顯示，登入後就會有bug（已解決）

--------------------------------------------------------------------  
#### 其他

- 搞混題目了XD 把登入註冊和留言板都放在同一頁了..
- 換頁：原本是用 GET 讓網址後面帶頁碼參數，測試的時候屁孩魂上身，在網址試了非整數的頁碼參數，出現 Error 之後，看了不爽就改成 POST 了XD，但後來又覺得頁碼是不是普遍都用 GET 比較好
- 卡比較久的地方 1：搞不清楚 php 擺放的位置和 php 與 js 的串連
- 卡比較久的地方 2：php 語法的細節（知道功能和用途）但不知道運作原理，所以還沒辦法靈活運用，大多都是照抄語法，改改變數而已
