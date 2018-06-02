<html>
  <head>
    <title>DFS Recipe Input Form</title>
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
    <h3>DFS レシピ 登録フォーム</h3>
    <form>
      <h2>レシピ名</h2>
      英名：<br/>
      <input type="text" name="RECIPE_NAME_EN" size="64"/><br/>
      和名：(任意)<br/>
      <input type="text" name="RECIPE_NAME_JP" size="64"/><br/>      
      <h2>調理器具：</h2>
<?php
  // 調理機器一覧取得
  $cookwares_result = pg_query('
SELECT
 dcm.cookware_seq,
 dcm.cookware_name_en,
 dcm.cookware_name_jp,
 dcm.dfs_site_key
FROM
 dfs_cookware_mst dcm
ORDER BY
 dcm.cookware_seq ASC
');
  if (!$cookwares_result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }
?>
      <select name="COOKWARE">
        <option value="">選択してください</option>
<?php
  for ($i = 0 ; $i < pg_num_rows($cookwares_result) ; $i++){
    $rows = pg_fetch_array($cookwares_result, NULL, PGSQL_ASSOC);
    $cookware_seq = $rows['cookware_seq'];
    $cookware_name_en = $rows['cookware_name_en'];
    $cookware_name_jp = $rows['cookware_name_jp'];
    $dfs_site_key = $rows['dfs_site_key'];
?>
        <option value="<?php print($cookware_seq); ?>"><?php print($cookware_name_en); ?></option>
<?php
  }
?>
      </select>
      <h2>スロット - 材料</h2>
<?php
  // 食材一覧取得
  $foodstuff_result = pg_query('
SELECT
 dfm.foodstuff_seq
 dfm.foodstuff_name_en,
 dfm.foodstuff_name_jp
FROM
 dfs_foodstuff_mst dfm
ORDER BY
 dfm.foodstuff_seq ASC
');
  if (!$foodstuff_result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }
?>
      SLOT (1) - 
      <select name="SLOT01">
        <option value="">選択してください</option>
<?php
  for ($i = 0 ; $i < pg_num_rows($foodstuff_result) ; $i++){
    $rows = pg_fetch_array($foodstuff_result, NULL, PGSQL_ASSOC);
    $foodstuff_seq = $rows['foodstuff_seq'];
    $foodstuff_name_en = $rows['foodstuff_name_en'];
    $foodstuff_name_jp = $rows['foodstuff_name_jp'];
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      SLOT (2) - 
      <select name="SLOT02">
        <option value="">選択してください</option>
<?php
  for ($i = 0 ; $i < pg_num_rows($foodstuff_result) ; $i++){
    $rows = pg_fetch_array($foodstuff_result, NULL, PGSQL_ASSOC);
    $foodstuff_seq = $rows['foodstuff_seq'];
    $foodstuff_name_en = $rows['foodstuff_name_en'];
    $foodstuff_name_jp = $rows['foodstuff_name_jp'];
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
    </form>
  </body>
</html>
