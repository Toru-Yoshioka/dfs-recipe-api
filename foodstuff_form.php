<html>
  <head>
    <title>DFS Foodstuff Input Form</title>
  </head>
  <body>
    <h3>DFS 食材 登録フォーム</h3>
    <form method="post" action="./foodstuff_regist.php">
      <h4>食材名</h4>
      英名：<br/>
      <input type="text" name="FOODSTUFF_NAME_EN" size="64"/><br/>
      和名：(任意)<br/>
      <input type="text" name="FOODSTUFF_NAME_JP" size="64"/><br/>      
      使用可能回数：<br/>
      <input type="text" name="FOODSTUFF_USES" size="8" value="1"/><br/>      
      エネルギー：<br/>
      <input type="text" name="FOODSTUFF_EP" size="8" value="10"/><br/>      
      <br/>
      <br/>
      <input type="submit" value="　登　録　"/>
    </form>
  </body>
</html>
