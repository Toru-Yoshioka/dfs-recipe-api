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
      <h4>レシピ名</h4>
      英名：<br/>
      <input type="text" name="RECIPE_NAME_EN" size="64"/><br/>
      和名：(任意)<br/>
      <input type="text" name="RECIPE_NAME_JP" size="64"/><br/>      
      <h4>調理器具：</h4>
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
      <h4>スロット - 材料</h4>
<?php
  // 食材一覧取得
  $foodstuff_result = pg_query('
SELECT
 dfm.foodstuff_seq,
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
    array_push($foodstuff_array, $rows);
  }
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      SLOT (2) - 
      <select name="SLOT02">
        <option value="">選択してください</option>
<?php
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      SLOT (3) - 
      <select name="SLOT03">
        <option value="">選択してください</option>
<?php
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      SLOT (4) - 
      <select name="SLOT04">
        <option value="">選択してください</option>
<?php
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      SLOT (5) - 
      <select name="SLOT05">
        <option value="">選択してください</option>
<?php
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      SLOT (6) - 
      <select name="SLOT06">
        <option value="">選択してください</option>
<?php
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      SLOT (7) - 
      <select name="SLOT07">
        <option value="">選択してください</option>
<?php
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      SLOT (8) - 
      <select name="SLOT08">
        <option value="">選択してください</option>
<?php
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      SLOT (9) - 
      <select name="SLOT09">
        <option value="">選択してください</option>
<?php
  for ($i = 0; $i < count($foodstuff_array); $i++) {
    $foodstuff_seq = $foodstuff_array[$i]['foodstuff_seq'];
    $foodstuff_name_en = $foodstuff_array[$i]['foodstuff_name_en'];
    $foodstuff_name_jp = $foodstuff_array[$i]['foodstuff_name_jp'];	
?>
        <option value="<?php print($foodstuff_seq); ?>"><?php print($foodstuff_name_en); ?></option>
<?php
  }
?>
      </select>
      <br/>
      <br/>
      <input type="submit" value="　登　録　"/>
    </form>
<?php
  $close_flag = pg_close($link);
  if ($close_flag){
    //     print('切断に成功しました。<br>');
  }
?>
  </body>
</html>
