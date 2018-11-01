資料庫名稱：users

|  欄位名稱 |    欄位型態    |    說明    |
|----------|--------------|------------|
|    id    |    int(10)   | 使用者 id   |
| username |  varchar(20) | 使用者帳號/名稱 |
| password |  varchar(20) | 使用者密碼  |



資料庫名稱：comments

|  欄位名稱 |    欄位型態    |    說明    |
|----------|--------------|------------|
|    id    |    int(10)   |  留言樓層   |
| username |      text    |  留言者名稱 |
| content  |      text    |  留言內容   |
| postTime |   timestamp  |  留言時間   |



資料庫名稱：replys

|  欄位名稱 |    欄位型態    |    說明    |
|----------|--------------|------------|
|    id    |    int(10)   |  好像沒功能..   |
|  floor   |      text    |  紀錄父留言的id |
| username |      text    |  回覆者名稱 |
| content  |      text    |  回覆內容   |
| postTime |   timestamp  |  回覆時間   |