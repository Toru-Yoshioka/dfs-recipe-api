<html>
  <head>
    <title>DFS Foodstuff Input Form</title>
    <style type="text/css">
    .border_outside {
      border: #aaaaaa 2px solid;
    }
    .border_inside th {
      border-collapse: collapse;
      border: #cccccc 1px solid;
    }
    .border_inside td {
      border-collapse: collapse;
      border: #cccccc 1px solid;
    }
    </style>
  </head>
  <body>
<?php
date_default_timezone_set('Asia/Tokyo');
$conn = "host=ec2-23-23-248-192.compute-1.amazonaws.com dbname=dl8app8ukml19 user=zukuhaourmbbsk password=f9e66d533b3f6cdae3d67c88e7baac7bc05f380fcaf047471e726d3b332ef74a";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}
// 接続に成功
?>
    <h3>DFS 食材 登録フォーム</h3>
<?php
  // 食材一覧取得
  $foodstuff_result = pg_query('
SELECT
  dfm.foodstuff_seq,
  dfm.foodstuff_name_en,
  dfm.foodstuff_name_jp,
  dfm.foodstuff_uses,
  dfm.foodstuff_energy,
  dfm.update_date,
  dfm.regist_date
FROM
 dfs_foodstuff_mst dfm
ORDER BY
 dfm.foodstuff_name_en ASC
');
  if (!$foodstuff_result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }
?>
    <table class="border_outside">
      <tr class="border_inside">
        <th>Seq</th>
        <th>食材名(英名)</th>
        <th>食材名(和名)</th>
        <th>使用可能回数</th>
        <th>エネルギー</th>
        <th>登録日時</th>
        <th>更新日時</th>
      </tr>
<?php
  for ($i = 0 ; $i < pg_num_rows($foodstuff_result) ; $i++){
    $rows = pg_fetch_array($foodstuff_result, NULL, PGSQL_ASSOC);
    $foodstuff_seq = $rows['foodstuff_seq'];
    $foodstuff_name_en = $rows['foodstuff_name_en'];
    $foodstuff_name_jp = $rows['foodstuff_name_jp'];
    $foodstuff_uses = $rows['foodstuff_uses'];
    $foodstuff_energy = $rows['foodstuff_energy'];
    $update_date = $rows['update_date'];
    $regist_date = $rows['regist_date'];
?>
      <tr class="border_inside">
        <td><?php print($foodstuff_seq); ?></td>
        <td><?php print($foodstuff_name_en); ?></td>
        <td><?php print($foodstuff_name_jp); ?></td>
        <td><?php print($foodstuff_uses); ?></td>
        <td><?php print($foodstuff_energy); ?></td>
        <td><?php print($update_date); ?></td>
        <td><?php print($regist_date); ?></td>
      </tr>
<?php
  }
?>
    </table>
    <br/>
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
