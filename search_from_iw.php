<?php header("content-type: text/plain; charset=utf-8"); ?>
<?php
date_default_timezone_set('Asia/Tokyo');
// トライアル判定
$trial_flg = $_POST['trial'];
if ($trial_flg == "1") {
  // トライアル版アクセスの場合
  $now_datetime = new DateTime();
  $target_datetime = new DateTime('2018-06-23 23:59:59');
  if ($now_datetime->format('Y-m-d H:i:s') > $target_datetime->format('Y-m-d H:i:s')){
    print "TRIAL FINISHED";
    die('');
  }
}
$conn = "host=ec2-23-23-248-192.compute-1.amazonaws.com dbname=dl8app8ukml19 user=zukuhaourmbbsk password=f9e66d533b3f6cdae3d67c88e7baac7bc05f380fcaf047471e726d3b332ef74a";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}
// 接続に成功

// print "--- REQUEST IW TEST ---\n";
$in_section = "";
$data = pg_escape_string($_POST['items']);
$search_mode = pg_escape_string($_POST['search_mode']);
// キーワードありなし
if (strlen($data) <= 0) {
  die('');
}
// あいまい検索・絞り込み検索
if (intVal($search_mode) == 0 || intVal($search_mode) == 1) {

$item_array = array_unique(explode('/', $data));
// 有効食材絞り込み
foreach ($item_array as $value) {
  $str_grep = preg_replace('/^(.+)[ ]+\(?[0-9]+\)?/', '$1', $value);
  if (strlen($in_section) > 0) {
    $in_section = $in_section . ",'" . $str_grep . "'";
  } else {
    $in_section = "'" . $str_grep . "'";
  } 
}
$query = '
SELECT
  dfm.foodstuff_seq
FROM
  dfs_foodstuff_mst dfm
WHERE
  dfm.foodstuff_name_en in (
    ' . $in_section . '
  )
';
$result = pg_query($query);
if (!$result) {
  die('クエリーが失敗しました。'.pg_last_error());
}
$valid_foodstuff_list = array();
for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
  $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
  $valid_foodstuff_list[] = $rows['foodstuff_seq'];
}
// あいまい検索・絞り込み検索
if (intVal($search_mode) == 0) {
  // あいまい検索
  $where_section = "";
  if (strlen(implode(',', $valid_foodstuff_list)) > 0) {
    $where_section = '
WHERE
  drfj.foodstuff_seq in (
    ' . implode(',', $valid_foodstuff_list) . '
  )
';
  }
  $query = '
SELECT
  drm.recipe_seq,
  drm.recipe_name_en
FROM
  dfs_recipe_foodstuff_join drfj LEFT OUTER JOIN
  dfs_recipe_mst drm ON drfj.recipe_seq = drm.recipe_seq
  ' . $where_section . '
GROUP BY
  drm.recipe_seq,
  drm.recipe_name_en
ORDER BY
  drm.recipe_name_en ASC
';
} else {
  // 絞り込み検索
  $exists_sections = "";
  foreach ($valid_foodstuff_list as $value) {
    $exists_sections = $exists_sections . '
AND
  EXISTS (
    SELECT
      null
    FROM
      dfs_recipe_foodstuff_join
    WHERE
      recipe_seq = drfj.recipe_seq
      AND
      foodstuff_seq = ' . $value . ')';
  }
  $query = '
SELECT
  drm.recipe_seq,
  drm.recipe_name_en
FROM
  dfs_recipe_foodstuff_join drfj LEFT OUTER JOIN
  dfs_recipe_mst drm ON drfj.recipe_seq = drm.recipe_seq
WHERE
  drfj.foodstuff_seq != 0
' . $exists_sections . '
GROUP BY
  drm.recipe_seq,
  drm.recipe_name_en
ORDER BY
  drm.recipe_name_en ASC
';
}

} else {
  // チャット検索
  if (intVal($search_mode) == 2) {
    // あいまい検索
    $lower_data = strtolower($data);
    $query = '
SELECT
  vrwn.recipe_seq,
  vrwn.recipe_name_en
FROM
  view_recipe_with_name vrwn
WHERE
  LOWER(vrwn.recipe_name_en) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot01) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot02) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot03) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot04) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot05) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot06) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot07) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot08) like \'%' . $lower_data . '%\'
  OR
  LOWER(vrwn.foodstuff_name_en_slot09) like \'%' . $lower_data . '%\'
GROUP BY
  vrwn.recipe_seq,
  vrwn.recipe_name_en
ORDER BY
  vrwn.recipe_name_en ASC
';
  } else if (intVal($search_mode) == 3) {
    // レシピ名検索
    $query = '
SELECT
  vrwn.recipe_seq,
  vrwn.recipe_name_en
FROM
  view_recipe_with_name vrwn
WHERE
  LOWER(vrwn.recipe_name_en) like \'%' . strtolower($data) . '%\'
GROUP BY
  vrwn.recipe_seq,
  vrwn.recipe_name_en
ORDER BY
  vrwn.recipe_name_en ASC
';
  }
}
print "■" . $query . "■";
$result = pg_query($query);
if (!$result) {
  die('クエリーが失敗しました。'.pg_last_error());
}
$response = "";
for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
  $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
  print $rows['recipe_seq'] . "//" . $rows['recipe_name_en'] . "\n";
}

$close_flag = pg_close($link);
if ($close_flag){
  //     print('切断に成功しました。<br>');
}
// print "--- PARAMETER END ---\n";
?>
