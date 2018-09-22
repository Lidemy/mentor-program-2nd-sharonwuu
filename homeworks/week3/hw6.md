## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
1.  < img > 插入圖片。<br>
    例如 ` <img src="image-location.jpg" alt="替代文字" / > ` <br>
    - src 為圖片來源
    - alt為圖片失效時出現的替代文字。
2. < video > 插入影片。<br>
    例如 `< video src="myVideo.mp4" width="320" height="240" > 這是影片 </video>`<br>
    - src 為影片來源
    - width、height 設定寬高
    - 「這是影片」為影片失效時出現的替代文字。    
3.  < table > < /table > 製作表格。<br>
    - < tr >< /tr >可以增加行數(rows)。
    - < td >< /td >可以增加同一行內的列數(columns)。

## 請問什麼是盒模型（box modal）
- 把css中的每個元素都視為一個盒子，透過 margin、border、padding 來調整盒子。

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
- inline：inline 屬性的內容與周圍內容顯示在同一行上，不會換行。
- block：是一個區塊，包含在內的內容與周圍內容不會顯示在同一行上。
- inline-block：讓區塊可彼此相鄰(同行)。

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
- static：position 的預設值，不會特別定位，會依照瀏覽器的設定配置位置。
- relative：不是以瀏覽器視窗為基準，是以外圍的物件為基準的相對位置。
- absolute：以上層元素為基準的定位方式；如果沒有上層元素就是以整個網頁為基準(body)。 
- fixed：以瀏覽器視窗為基準的定位方式；固定在視窗的位置上；常用於 navigation bars。