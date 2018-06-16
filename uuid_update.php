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
$dst_name = $_POST['DST_NAME'];
$icon_uuid = $_POST['ICON_UUID'];
$pict_uuid = $_POST['PICT_UUID'];

$result = pg_query('
UPDATE
  dfs_uuid_join
SET
  icon_uuid = \'' . $icon_uuid . '\',
  pict_uuid = \'' . $pict_uuid . '\',
  update_date = current_timestamp
WHERE
  dst_name = \'' . $dst_name . '\';
INSERT INTO
  dfs_uuid_join
    (dst_name, icon_uuid, pict_uuid, update_date, regist_date)
  VALUES
    (\'' . $dst_name . '\', \'' . $icon_uuid . '\', \'' . $pict_uuid . '\', current_timestamp, current_timestamp)
WHERE
  NOT EXISTS (SELECT 1 FROM dfs_uuid_join WHERE dst_name = \'' . $dst_name . '\');
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
?>
    <h3>DFS UUID 登録フォーム 登録完了</h3>
      <h4>対象素材</h4>
      <?php print($dst_name); ?><br/>
      アイコンUUID：<br/>
      <?php print($icon_uuid); ?><br/>
      写真UUID：<br/>
      <?php print($pict_uuid); ?><br/>
      <br/>
      <br/>
      <a href="./uuid_form.php">登録フォームへ戻る</a>
<?php
  $close_flag = pg_close($link);
  if ($close_flag){
    //     print('切断に成功しました。<br>');
  }
?>
  </body>
</html>
