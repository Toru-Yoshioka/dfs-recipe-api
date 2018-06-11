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
if ($_POST['search_mode'] == "0") {
  // あいまい検索

  $query = '
SELECT
  drm.recipe_seq,
  drm.recipe_name_en
FROM
  dfs_recipe_foodstuff_join drfj LEFT OUTER JOIN
  dfs_recipe_mst drm ON drfj.recipe_seq = drm.recipe_seq
WHERE
  drfj.foodstuff_seq in (
    ' . implode(',', $valid_foodstuff_list) . '
  )
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
      recipe_seq = drfja.recipe_seq
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
  drfj.recipe_seq
ORDER BY
  drfj.recipe_seq
';
}
$result = pg_query($query);
if (!$result) {
  die('クエリーが失敗しました。'.pg_last_error());
}
$response = "";
for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
  $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
  print $rows['recipe_seq'] . ":" . $rows['recipe_name_en'] . "\n";
}

$close_flag = pg_close($link);
if ($close_flag){
  //     print('切断に成功しました。<br>');
}
print "--- PARAMETER END ---\n";
?>
