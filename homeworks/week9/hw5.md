## CSS 預處理器是什麼？我們可以不用它嗎？
CSS 預處理器（如 SASS、SCSS、Less、Stylus），提供純 CSS 沒有的功能，讓開發者可以用程式化的方法寫 CSS，使 CSS 可讀性更高、更容易維護，最後再透過預處理器編譯成真的 CSS。 

可以不用預處理器，直接寫 CSS。  
預處理器只是提供不同形式、功能(?)寫 CSS，最終還是要編譯回原本的 CSS 才能用。

## 請舉出任何一個跟 HTTP Cache 有關的 Header 並說明其作用。
`Cache-Control` 用於指定要使用哪一種 Cache 方式

- `Cache-Control: max-age=30`代表這個 Response 的過期時間是 30 秒。30 秒內不管重新整理幾次，都是從 Cache 讀取資料，假設使用者在超過 30 秒後重新整理，瀏覽器就會發送 Request。

- `Cache-Control: no-store` 永遠不要儲存 Cache，每次進入網站瀏覽器都會發 Request 抓回檔案，耗流量。
- `Cache-Control: no-cache` 儲存 Cache，每次進入網站都發 Request 確認檔案有無更動，沒更動就從 Cache 抓原本的檔案。

## Stack 跟 Queue 的差別是什麼？
#### Stack 堆疊
放資料、取資料都只能從都一端操作，因此資料的存取順序是先進後出，First In Last Out（FILO）。  

像桶裝洋芋片，只有一個開口，最先放進去的在桶底，拿出來吃的時候是從靠近開口的那片開始依序往下吃，最後才會吃到在最底部的第一片。

#### Queue 佇列
有別於 Stack 只有單一出口，Queue 的規則是先進先出，First-In-First-Out（FIFO）。

像小吃店牆上的紙杯架，紙杯從上方的洞口放進去，從下面的洞口依序把紙杯取出來裝飲料，最先放進去的紙杯會第一個被取出。

## 請去查詢資料並解釋 CSS Selector 的權重是如何計算的（不要複製貼上，請自己思考過一遍再自己寫出來）
#### Specificity 權重/特異性
瀏覽器會依照 各個 Selector 的權重判斷每個屬性值跟該元素的相關性，比較過後，套用相關性最高的屬性值到該元素。

#### 計算權重
為了要能夠比較權重，W3C 制定了權重的計算方式，權重格式分為 `a,b,c,d` 四個項目，四個項目分別 代表不同選擇器的數量：

- a：Inline style 的數量
- b：ID 的數量
- c：Class、Attribute、Pseudo-classes(`:not`除外) 的數量
- d：Element、Pseudo-elements 的數量

```
div{ color:red; } /* 0,0,0,1 */  
.class{color:yellow;} /* 0,0,1,0 */  
#id{color:green;} /* 0,1,0,0 */

*{color:blue;} /* 0,0,0,0 */
```

#### 比較權重：a>b>c>d

比較權重時，會按照 a>b>c>d 的順序，先比 a，a 相同再比 b，依序比下去。套用上面舉例的 CSS，假設 html 長這樣：

```
<div class="class" id ="id"> Hello World <div/>
```

按照比較順序，三個 Selector 的 a 都相同，接著比 b，找到 id Selector b=1 是最高的，所以 id 指定的 `color:green` 權重最高，瀏覽器會套用 `color:green` 到 Helloe World。