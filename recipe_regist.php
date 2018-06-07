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

$recipe_name_en = $_POST['RECIPE_NAME_EN'];
$recipe_name_jp = $_POST['RECIPE_NAME_JP'];
$cooking_equipment_seq = $_POST['COOKING_EQUIPMENT_SEQ'];
$foodstuff_seq_slot01 = $_POST['FOODSTUFF_SEQ_SLOT01'];
$foodstuff_seq_slot02 = $_POST['FOODSTUFF_SEQ_SLOT02'];
$foodstuff_seq_slot03 = $_POST['FOODSTUFF_SEQ_SLOT03'];
$foodstuff_seq_slot04 = $_POST['FOODSTUFF_SEQ_SLOT04'];
$foodstuff_seq_slot05 = $_POST['FOODSTUFF_SEQ_SLOT05'];
$foodstuff_seq_slot06 = $_POST['FOODSTUFF_SEQ_SLOT06'];
$foodstuff_seq_slot07 = $_POST['FOODSTUFF_SEQ_SLOT07'];
$foodstuff_seq_slot08 = $_POST['FOODSTUFF_SEQ_SLOT08'];
$foodstuff_seq_slot09 = $_POST['FOODSTUFF_SEQ_SLOT09'];
$cooking_time_hours = $_POST['COOKING_TIME_HOURS'];
$cooking_time_minutes = $_POST['COOKING_TIME_MINUTES'];
$cooking_time_seconds = $_POST['COOKING_TIME_SECONDS'];
// 登録する調理時間(秒)を計算
 $formated_seconds = (intval($cooking_time_hours) * 360) + (intval($cooking_time_minutes) * 60) + intval($cooking_time_seconds);
$deliverable_uses = $_POST['DELIVERABLE_USES'];
$deliverable_energy = $_POST['DELIVERABLE_ENERGY'];
$experience_point = $_POST['EXPERIENCE_POINT'];
$ends_date = $_POST['ENDS_DATE'];
if ($ends_date != '') {
  $ends_date = 'to_date(\'' . $ends_date . '\', \'YYYY/MM/DD\')';
} else {
  $ends_date = 'null';
}
// レシピシーケンス取得
$recipe_seq_result = pg_query('
SELECT nextval(\'dfs_recipe_seq\') AS next_recipe_seq
');
if (!$recipe_seq_result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$rows = pg_fetch_array($recipe_seq_result, NULL, PGSQL_ASSOC);
$next_recipe_seq = $rows['next_recipe_seq'];
// レシピマスタ登録
$result = pg_query('
INSERT INTO
  dfs_recipe_mst
  (
	recipe_seq,
	recipe_name_en,
	recipe_name_jp,
	cooking_equipment_seq,
	cooking_time_seconds,
	deliverable_uses,
	deliverable_energy,
	experience_point,
	ends_date,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  \'' . $recipe_name_en . '\',
  \'' . $recipe_name_jp . '\',
  ' . $cooking_equipment_seq . ',
  ' . $formated_seconds . ',
  ' . $deliverable_uses . ',
  ' . $deliverable_energy . ',
  ' . $experience_point . ',
  ' . $ends_date . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
// 食材紐づけ登録
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  1,
  ' . $foodstuff_seq_slot01 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  2,
  ' . $foodstuff_seq_slot02 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  3,
  ' . $foodstuff_seq_slot03 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  4,
  ' . $foodstuff_seq_slot04 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  5,
  ' . $foodstuff_seq_slot05 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  6,
  ' . $foodstuff_seq_slot06 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  7,
  ' . $foodstuff_seq_slot07 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  8,
  ' . $foodstuff_seq_slot08 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$result = pg_query('
INSERT INTO
  dfs_recipe_foodstuff_join
  (
	recipe_seq,
	slot_no,
	foodstuff_seq,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_recipe_seq . ',
  9,
  ' . $foodstuff_seq_slot09 . ',
  current_timestamp,
  current_timestamp
 )
');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
?>
    <h3>DFS レシピ 登録完了</h3>
    <form>
      <h4>レシピ名</h4>
      英名：<br/>
      <?php print($recipe_name_en); ?><br/>
      和名：<br/>
      <?php print($recipe_name_jp); ?><br/>      
      <h4>調理器具：</h4>
      <?php print($cooking_equipment_seq); ?><br/>
      <h4>スロット - 材料</h4>
      SLOT (1) - <?php print($foodstuff_seq_slot01); ?><br/>
      SLOT (2) - <?php print($foodstuff_seq_slot02); ?><br/>
      SLOT (3) - <?php print($foodstuff_seq_slot03); ?><br/>
      SLOT (4) - <?php print($foodstuff_seq_slot04); ?><br/>
      SLOT (5) - <?php print($foodstuff_seq_slot05); ?><br/>
      SLOT (6) - <?php print($foodstuff_seq_slot06); ?><br/>
      SLOT (7) - <?php print($foodstuff_seq_slot07); ?><br/>
      SLOT (8) - <?php print($foodstuff_seq_slot08); ?><br/>
      SLOT (9) - <?php print($foodstuff_seq_slot09); ?><br/>
      <h4>調理時間(秒)</h4>
      <?php print((string)$formated_seconds); ?><br/>
      <br/>
      <h4>成果物の使用可能回数</h4>
      <?php print($deliverable_uses); ?><br/>
      <br/>
      <h4>成果物のエネルギー量</h4>
      <?php print($deliverable_energy); ?><br/>
      <br/>
      <h4>調理により得られる経験値</h4>
      <?php print($experience_point); ?><br/>
      <br/>
      <br/>
      <a href="./recipe_form.php">登録フォームへ戻る</a>
<?php
  $close_flag = pg_close($link);
  if ($close_flag){
    //     print('切断に成功しました。<br>');
  }
?>
  </body>
</html>
