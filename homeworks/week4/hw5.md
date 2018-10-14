# 什麼是 DOM？
  - Document Object Model 文件物件模型。
  - DOM 是哪來的？<br>
    當網頁被載入到瀏覽器時，瀏覽器會先分析 .HTML 檔，然後依照.HTML 的內容解析出 DOM。
  - 解析出 DOM 是什麼？<br>
    HTML DOM 用類似樹狀圖的方式結構化 HTML，形成 DOM Tree。
  - 所以要 DOM 幹嘛？<br>
    DOM 定義了操作與存取 HTML 的方式，DOM 中每個 tag 都是一個節點（node），JS 可以透過節點操作特定元素，讓網頁有更多互動性。(可以說是 html 和 js 之間的溝通管道(?))
  - 其他(還沒很懂的東西)：DOM 分為三個部份：DOM core、HTML DOM 與 XML DOM。

# 什麼是 Ajax？
  - Asynchronous JavaScript and XML。Asynchronous 非同步；XML 是一種表現資料的格式。
  - AJAX 是一種技術，可以在不重新加載整個網頁的情況下，對網頁的某部分進行更新。
  - 實例：註冊新帳號，輸入 username 的同時，網頁就會同步告訴使用者這個名稱能不能使用。
  - 缺點：同源政策規定，AJAX 請求只能發給同源的網址，否則就報錯。

  - 運作原理(似懂非懂的東西)：<br>
    Ajax 與傳統網站應用系統模式不同在於，瀏覽器自行負責建立請求傳給伺服器，並處理傳來的回應。<br>
    Ajax 模組提供了一個中間層來控制這個溝通過程（這個中間層稱為 AJAX 引擎）。<br>
    Ajax 引擎其實就是前端在請求伺服器資訊時要呼叫的 JS 物件和函式。<br>
    不像傳統方式中連結是設定到另一個資源的 URL，現在每個連結都變成在呼叫 AJAX 引擎，由它來排定和執行這些請求。<br>
    而且這些請求是非同步的，也就是說不必等候回應，介面仍可以繼續操作。

# HTTP method 有哪幾個？有什麼不一樣？
  - GET：跟 server 要資源，取得資料。
  - HEAD：與 GET 相同的回應，但 HEAD 沒有回應主體 (response body)，只有 header。
  - POST：送東西到 server，新增資料（原本就有資料，就再新增一個資料）。
  - PATCH：更新部分資料（用於更新原本就有的資料）。
  - PUT：更新資料（原本有沒有資料都可以）。如果已經有資料就更新資料，沒資料就新增資料。
  - DELETE：刪除指定資料。
  - OPTIONS：描述指定資源的溝通方法 (communication option)，看資源支援哪些 method。

# GET 跟 POST 有哪些區別，可以試著舉幾個例子嗎？
  - GET 沒有 request body，只有 header 和 URL。資訊帶在 URL 後面，所以不能放敏感資訊（像是密碼會外露）。
    -- 例子：在 google 搜尋關鍵字後，把搜尋結果頁面的網址複製給別人，別人會得到一樣的搜尋結果，<br>
    因為 GET 把關鍵字帶在網址上，所以複製給別人的網址也會有所搜尋的關鍵字。
  - POST 把資訊放在 request body 裡，適合拿來放敏感資訊。
    -- 例子：登入帳號，輸入帳號密碼後送出資訊時，帳號密碼的資訊會帶在　request body 裡送到 server，網址看不到。
    -- 疑惑：帳號密碼在　request body 別人就看不到嗎？

# 什麼是 RESTful API？
  - REST：Representational State Transfer，具象狀態傳輸，是一種網路架構風格。
  - RESTful API：符合 REST 設計風格的 Web API 就稱為 RESTful API。
  - REST 風格充份利用 HTTP 協定的特點，使 API 設計具有整體一致性，易於維護、擴展，且可讀性高。

# JSON 是什麼？
  - JSON 是一種以純文字儲存資料的格式，讓資料可以在不同程式間溝通或交換。
  - 用 {} 包住 Objetct；用 [] 包住 Array；用 "" 包住字串；用逗號分隔變數；key-value 用冒號區隔。
  - 基本格式：`｛ "string0":value0 , "string1":value1 ｝`
    -- 例如：`｛ "name":"snoopy" , "age":5 ｝`

# JSONP 是什麼？
  - JSON with padding，簡稱 JSONP，是一種 JSON 的使用方式。
  - 利用 `<script>` 不受同源政策限制的特性達成跨域請求。
  - 運作方式：使用 HTTP GET Method，在 `<script>` 中載入遠端的 JavaScript，搭配 Callback Function 回傳資料。
 

# 要如何存取跨網域的 API？
```
先備知識：
 - 網頁送出 request 時，browser 會在 request (XMLHttpRequest) 的 header 塞入 Origin，紀錄這個網頁的來源（網域）。
 - 同源政策（the same-origin policy）指的是 browser 發出 request 的 Origin 要和 server 一樣（稱為「同源」），才可相互存取。
 - 跨域：當 request Origin 網域與目標伺服器不同（不同源）就是所謂的跨網域連線。
```
如何存取跨網域 API：
1. JSONP 可以達成跨域，但因為是透過 GET Method，URL 有長度限制，單次能傳送的資料量有限。
2. CORS（Cross-Origin Resource Sharing）跨來源資源共享，是一份瀏覽器技術的規範。
    - 透過 HTTP header 的設定，規範瀏覽器在進行跨網域連線時，可以存取的資料權限與範圍，包括哪些來源可以存取，或是哪些 HTTP verb, header 的 request 可以存取。
    - 流程：（送出 request 前還有一些流程），server 從 request 中的 `Origin` 決定要不要允許：
      -- 允許，server 會在 response header 中加入 Access-Control-Allow-Origin，告訴 browser 可以通過！browser 就會放行讓 response 通過。
      -- 不允許，不會加上 Access-Control-Allow-Origin，browser 就不會放行。

   note:
   - 決定權在 server，browser 只是把關而已？
   - 簡單請求和非簡單請求還有不一樣的流程。
   - Access-Control-Allow-Origin 一定有，
      但還有其他 Access-Control-Allow-balabala 有其他功能。