<?php header("content-type: text/plain; charset=utf-8"); ?>
受信したヘッダ:
<?php
date_default_timezone_set('Asia/Tokyo');
$conn = "host=ec2-23-23-248-192.compute-1.amazonaws.com dbname=dl8app8ukml19 user=zukuhaourmbbsk password=f9e66d533b3f6cdae3d67c88e7baac7bc05f380fcaf047471e726d3b332ef74a";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}
// 接続に成功

print "--- REQUEST IW TEST ---\n";

$in_section = "";
$data = $_POST['items'];
$item_array = array_unique(explode('/', $data));
foreach ($item_array as $value) {
  $str_grep = preg_replace('/^(.+)[ ]+\(?[0-9]+\)?/', '$1', $value);
  if (strlen($in_section) > 0) {
    $in_section = $in_section . ",'" . $str_grep . "'";
  } else {
    $in_section = "'" . $str_grep . "'";
  } 
  //print "値 : " . $str_grep . "\n";
}
  // レシピ詳細をクエリ
  $recipe_result = pg_query('
SELECT
  vrwn.recipe_seq,
  vrwn.recipe_name_en,
  vrwn.recipe_name_jp,
  vrwn.cooking_equipment_seq,
  vrwn.cookware_name_en,
  vrwn.foodstuff_seq_slot01,
  vrwn.foodstuff_name_en_slot01,
  vrwn.foodstuff_seq_slot02,
  vrwn.foodstuff_name_en_slot02,
  vrwn.foodstuff_seq_slot03,
  vrwn.foodstuff_name_en_slot03,
  vrwn.foodstuff_seq_slot04,
  vrwn.foodstuff_name_en_slot04,
  vrwn.foodstuff_seq_slot05,
  vrwn.foodstuff_name_en_slot05,
  vrwn.foodstuff_seq_slot06,
  vrwn.foodstuff_name_en_slot06,
  vrwn.foodstuff_seq_slot07,
  vrwn.foodstuff_name_en_slot07,
  vrwn.foodstuff_seq_slot08,
  vrwn.foodstuff_name_en_slot08,
  vrwn.foodstuff_seq_slot09,
  vrwn.foodstuff_name_en_slot09,
  vrwn.cooking_time_seconds,
  vrwn.deliverable_uses,
  vrwn.deliverable_energy,
  vrwn.experience_point,
  vrwn.update_date,
  vrwn.regist_date
FROM
  view_recipe_with_name vrwn
WHERE
  vrwn.recipe_seq = ' . . '
');
  if (!$recipe_result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }

$response = "";
for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
  $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
  print $rows['recipe_name_en'] . "\n";
}

$close_flag = pg_close($link);
if ($close_flag){
  //     print('切断に成功しました。<br>');
}
print "--- PARAMETER END ---\n";
?>
