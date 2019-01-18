## Bootstrap 是什麼？
Bootstrap 是一組包括 HTML、CSS 及 JavaScript 的前端 UI Library。  
提供多種設計好的版型、元件，及 JavaScript 擴充套件。

## 請簡介網格系統以及與 RWD 的關係
- 網格系統（以 12 欄系統為例）  
	將視窗寬度等分為 12 欄，以 1/12 欄為一寬度單位，各元素能以不同的單位量，決定所需的寬度。
	
- 網格系統 與 RWD：以網格系統的概念設計網頁介面，能更易於製作 RWD
- 單位差異：
	- 平時常用的絕對單位，如 px、mm 等，大小固定，不管出現在哪都是同樣的尺寸
	- 網格系統則是相對單位，單位依照螢幕比例而定，沒有預設的固定大小，所以易於製作 RWD
- [參考來源](https://tips.zoego.tech/archives/37)
- 題外好奇：為何要 12 格？ [解答](https://blog.csdn.net/boycycyzero/article/details/44364979) 好智慧 XD

## 請找出任何一個與 Bootstrap 類似的 library
- 夯度僅次於 Bootstrap：[Foundation](https://foundation.zurb.com/)

## jQuery 是什麼？
- jQuery 是一個 JavaScript 的 Library（函式庫）
- jQuery 提供精簡版的 JS 語法，加速開發速度。

## jQuery 與 vanilla JS 的關係是什麼？
- vanilla JS 就是原生的 JavaScript
- jQuery 是以 vanilla JS 為基礎編寫的
- 沒有 vanilla JS 就沒有 jQuery；沒有 jQuery 沒關係 XD


---

## 題外的疑惑：Library？Framework？  
寫上面這幾題查資料的時候，看到幾個不一樣的用詞：  
jQuery 是 Library，但 Bootstrap 一下 Library，一下又 Framework  
所以就查了 Library 和 Framework 的差別

- Library 就像走進圖書館（引入 Library），裡面有很多資料，要不要用、要怎麼用，自己決定。引入 jQuery 也可以不要用，只用 vanilla JS。
- Framework 和 Library 有點相反？不能隨便用，有既定的規則、使用方式（沒很懂）
	 
這樣看來 Bootstrap 像 Library 也像 Framework 啊 XD

- Library：Bootstrap 提供很多已經做好的功能和元件，要自己套用到程式裡面才有效。  
 像我不要 Navbar，只要用 Button，就自己選要用的東西。
- Framework：剛引入 Bootstrap 之後，就會被套上 Bootstrap 規定好的 css 樣式，如果要改掉那些樣式，就要針對原本 Bootstrap 的規定修改（比如另外寫 css 蓋掉 Bootstrap 預設的 btn 樣式）

感覺 Bootstrap 像 Library 的地方，和 jQuery 又點不太一樣，但說不出哪裡怪。  
偽結論：會用就好(?)，不要糾結太久 XD
