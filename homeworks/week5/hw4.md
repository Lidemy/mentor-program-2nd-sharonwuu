## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼
- VARCHAR：可以指定字串長度，可以節省空間
- TEXT：純文字欄位，不限定字串長度，較占空間


## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又會以什麼形式帶去 Server？
1. Cookie 功能：儲存使用者資訊，以解決使用者重複輸入相同資訊的不便（例如網站登入資訊）。
2. 傳送、設定 Cookie
      1. 瀏覽器送出 request 前，都會先找找有沒有 Cookie，如果有，就把 Cookie 資訊加到 request header 中一起送出。
    （不管有無 Cookie，瀏覽器每一次都會找(？)）
      2. 第一次造訪時（瀏覽器沒找到 Cookie），request header 不含 Cookie，伺服器確認 request 中的資訊正確無誤後，
        會在 response header 中加入 setCookie（setCookie 內會有伺服器叫瀏覽器存的資料），瀏覽器收到含 setCookie 的 response 後，
        就會存下 Cookie。（Cookie 是以 key=value 的格式保存資料）
      3. 再次造訪時（瀏覽器有找到 Cookie），伺服器收到含 Cookie 的 request header 後，會再確認一次 Cookie 內的帳密（嗎？）
      4. 以登入帳號為例，所以 Cookie 儲存好正確帳密後，（在 Cookie 期限到期前）不管使用者造訪幾次，
          瀏覽器和伺服器之間，都還是會傳送使用者資料（Cookie 內的資料）執行登入驗證，只是是透過瀏覽器自動傳送給伺服器，所以不會動用使用者。
      
      * 原本的認知、疑問：（查資料前 -> 查資料後）
        - Q1) Cookie 是瀏覽器提供的功能、Cookie 檔是存在電腦/瀏覽器上（Client 端）-> 正確
        - Q2) 有 Cookie 就等於拿到伺服器給的通行證，在 Cookie 到期前與登出前都通行無阻，瀏覽器不用再跟伺服器確認身份 -> 錯
        - Q3) Cookie 到底是「瀏覽器」還是「伺服器」記住使用者資料？ -> 是瀏覽器存使用者資料，但是是伺服器傳要存的資料給瀏覽器存

參考來源：
- https://computer.howstuffworks.com/cookie3.htm (主要參考 Page3、4)
- https://progressbar.tw/posts/91
- https://segmentfault.com/a/1190000004556040


## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？
- 重複註冊
- 帳密：中英文和全形/半形符號在資料庫的影響（以前遇過帳密都是英文字母，電腦可以正常登入，但手機無法登入，
  後來聽說只要含有英文字母的帳密，在手機APP上都無法登入，全數字就可以。英文也有編碼問題？）
- 帳密用 POST 傳送，被攔截封包就會被看到