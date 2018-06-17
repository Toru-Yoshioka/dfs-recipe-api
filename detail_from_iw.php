<?php header("content-type: text/plain; charset=utf-8"); ?>
<?php
date_default_timezone_set('Asia/Tokyo');
$conn = "host=ec2-23-23-248-192.compute-1.amazonaws.com dbname=dl8app8ukml19 user=zukuhaourmbbsk password=f9e66d533b3f6cdae3d67c88e7baac7bc05f380fcaf047471e726d3b332ef74a";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}
// 接続に成功

// print "--- REQUEST IW TEST ---\n";

$recipe_seq = $_POST['recipe_seq'];
// print "SEQ:" . $recipe_seq . "\n";
// レシピ詳細をクエリ
$recipe_result = pg_query('
SELECT
  vrwn.recipe_seq,
  vrwn.recipe_name_en,
  vrwn.recipe_pict_uuid,
  vrwn.recipe_name_jp,
  vrwn.cooking_equipment_seq,
  vrwn.cookware_uuids,
  vrwn.foodstuff_seq_slot01,
  vrwn.foodstuff_name_en_slot01,
  vrwn,foodstuff_icon_uuid_slot01,
  vrwn.foodstuff_pict_uuid_slot01,
  vrwn.foodstuff_seq_slot02,
  vrwn.foodstuff_name_en_slot02,
  vrwn,foodstuff_icon_uuid_slot02,
  vrwn.foodstuff_pict_uuid_slot02,
  vrwn.foodstuff_seq_slot03,
  vrwn.foodstuff_name_en_slot03,
  vrwn,foodstuff_icon_uuid_slot03,
  vrwn.foodstuff_pict_uuid_slot03,
  vrwn.foodstuff_seq_slot04,
  vrwn.foodstuff_name_en_slot04,
  vrwn,foodstuff_icon_uuid_slot04,
  vrwn.foodstuff_pict_uuid_slot04,
  vrwn.foodstuff_seq_slot05,
  vrwn.foodstuff_name_en_slot05,
  vrwn,foodstuff_icon_uuid_slot05,
  vrwn.foodstuff_pict_uuid_slot05,
  vrwn.foodstuff_seq_slot06,
  vrwn.foodstuff_name_en_slot06,
  vrwn,foodstuff_icon_uuid_slot06,
  vrwn.foodstuff_pict_uuid_slot06,
  vrwn.foodstuff_seq_slot07,
  vrwn.foodstuff_name_en_slot07,
  vrwn,foodstuff_icon_uuid_slot07,
  vrwn.foodstuff_pict_uuid_slot07,
  vrwn.foodstuff_seq_slot08,
  vrwn.foodstuff_name_en_slot08,
  vrwn,foodstuff_icon_uuid_slot08,
  vrwn.foodstuff_pict_uuid_slot08,
  vrwn.foodstuff_seq_slot09,
  vrwn.foodstuff_name_en_slot09,
  vrwn,foodstuff_icon_uuid_slot09,
  vrwn.foodstuff_pict_uuid_slot09,
  vrwn.cooking_time_seconds,
  vrwn.deliverable_uses,
  vrwn.deliverable_energy,
  vrwn.experience_point,
  vrwn.update_date,
  vrwn.regist_date
FROM
  view_recipe_with_name vrwn
WHERE
  vrwn.recipe_seq = ' . $recipe_seq . '
');
if (!$recipe_result) {
  die('クエリーが失敗しました。'.pg_last_error());
}

for ($i = 0 ; $i < pg_num_rows($recipe_result) ; $i++){
  $rows = pg_fetch_array($recipe_result, NULL, PGSQL_ASSOC);
print $rows['recipe_seq'] . "//" . $rows['recipe_name_en'] . "//" . $rows['recipe_pict_uuid'] . "\n";
// print $rows['recipe_name_jp'] . "\n";
print $rows['cooking_equipment_seq'] . "//" . $rows['cookware_uuids'] . "\n";
print $rows['foodstuff_seq_slot01'] . "//" . $rows['foodstuff_name_en_slot01'] . "//" . $rows['foodstuff_icon_uuid_slot01'] . "//" . $rows['foodstuff_pict_uuid_slot01'] . "\n";
print $rows['foodstuff_seq_slot02'] . "//" . $rows['foodstuff_name_en_slot02'] . "//" . $rows['foodstuff_icon_uuid_slot02'] . "//" . $rows['foodstuff_pict_uuid_slot02'] . "\n";
print $rows['foodstuff_seq_slot03'] . "//" . $rows['foodstuff_name_en_slot03'] . "//" . $rows['foodstuff_icon_uuid_slot03'] . "//" . $rows['foodstuff_pict_uuid_slot03'] . "\n";
print $rows['foodstuff_seq_slot04'] . "//" . $rows['foodstuff_name_en_slot04'] . "//" . $rows['foodstuff_icon_uuid_slot04'] . "//" . $rows['foodstuff_pict_uuid_slot04'] . "\n";
print $rows['foodstuff_seq_slot05'] . "//" . $rows['foodstuff_name_en_slot05'] . "//" . $rows['foodstuff_icon_uuid_slot05'] . "//" . $rows['foodstuff_pict_uuid_slot05'] . "\n";
print $rows['foodstuff_seq_slot06'] . "//" . $rows['foodstuff_name_en_slot06'] . "//" . $rows['foodstuff_icon_uuid_slot06'] . "//" . $rows['foodstuff_pict_uuid_slot06'] . "\n";
print $rows['foodstuff_seq_slot07'] . "//" . $rows['foodstuff_name_en_slot07'] . "//" . $rows['foodstuff_icon_uuid_slot07'] . "//" . $rows['foodstuff_pict_uuid_slot07'] . "\n";
print $rows['foodstuff_seq_slot08'] . "//" . $rows['foodstuff_name_en_slot08'] . "//" . $rows['foodstuff_icon_uuid_slot08'] . "//" . $rows['foodstuff_pict_uuid_slot08'] . "\n";
print $rows['foodstuff_seq_slot09'] . "//" . $rows['foodstuff_name_en_slot09'] . "//" . $rows['foodstuff_icon_uuid_slot09'] . "//" . $rows['foodstuff_pict_uuid_slot09'] . "\n";
$cooking_time_seconds = intVal($rows['cooking_time_seconds']);
$cooking_hours = floor($cooking_time_seconds / 3600);
$cooking_minutes = str_pad(floor(($cooking_time_seconds - ($cooking_hours * 3600)) / 60), 2, 0, STR_PAD_LEFT);
$cooking_seconds = str_pad($cooking_time_seconds - ($cooking_hours * 3600) - ($cooking_minutes * 60), 2, 0, STR_PAD_LEFT);
print $cooking_hours . ":" . $cooking_minutes . ":" . $cooking_seconds . "\n";
print $rows['deliverable_uses'] . "\n";
print $rows['deliverable_energy'] . "\n";
print $rows['experience_point'];
// print $rows['update_date'] . "\n";
// print $rows['regist_date'] . "\n";
}

$close_flag = pg_close($link);
if ($close_flag){
  //     print('切断に成功しました。<br>');
}
// print "--- PARAMETER END ---\n";
?>
