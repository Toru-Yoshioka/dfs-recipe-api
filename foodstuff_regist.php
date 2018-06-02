<html>
  <head>
    <title>DFS Foodstuff Input Form</title>
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

// フォーム内容取得
$foodstuff_name_en = $_GET['FOODSTUFF_NAME_EN'];
$foodstuff_name_jp = $_GET['FOODSTUFF_NAME_JP'];
$foodstuff_uses = $_GET['FOODSTUFF_USES'];
$foodstuff_ep = $_GET['FOODSTUFF_EP'];

// $result = pg_query('
// INSERT INTO
//   dfs_foodstuff_mst
//   (
//     foodstuff_seq,
// 	foodstuff_name_en,
// 	foodstuff_name_jp,
// 	foodstuff_uses,
// 	foodstuff_energy,
// 	update_date,
// 	regist_date
//   ) VALUES (
//   nextval(\'dfs_foodstuff_seq\'),
//   \'' . $foodstuff_name_en . '\',
//   \'' . $foodstuff_name_jp . '\',
//   ' . $foodstuff_uses . ',
//   ' . $foodstuff_ep . ',
//   current_timestamp,
//   current_timestamp
//  )
// ');
// if (!$result) {
//     die('クエリーが失敗しました。'.pg_last_error());
// }
?>
    <h3>DFS 食材 登録フォーム 登録完了</h3>
      <h4>食材名</h4>
      英名：<br/>
      <?php print($foodstuff_name_en); ?><br/>
      和名：<br/>
      <?php print($foodstuff_name_jp); ?><br/>
      使用可能回数：<br/>
      <?php print($foodstuff_uses); ?><br/>
      エネルギー：<br/>
      <?php print($foodstuff_ep); ?><br/>
      <br/>
      <br/>
      <a href="./foodstuff_form.php">登録フォームへ戻る</a>
<?php
  $close_flag = pg_close($link);
  if ($close_flag){
    //     print('切断に成功しました。<br>');
  }
?>
  </body>
</html>
