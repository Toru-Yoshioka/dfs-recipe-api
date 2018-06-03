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
    <form method="post" action="./recipe_regist.php">
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
      <select name="COOKING_EQUIPMENT_SEQ">
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
 dfm.foodstuff_name_en ASC
');
  if (!$foodstuff_result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }
?>
      SLOT (1) - 
      <select name="FOODSTUFF_SEQ_SLOT01">
        <option value="0">選択してください</option>
<?php
  $option_tag = '';
  for ($i = 0 ; $i < pg_num_rows($foodstuff_result) ; $i++){
    $rows = pg_fetch_array($foodstuff_result, NULL, PGSQL_ASSOC);
	$option_tag = $option_tag . '<option value="' . $rows['foodstuff_seq'] . '">' . $rows['foodstuff_name_en'] . '</option>';
  }
?>
        <?php print($option_tag); ?>
      </select>
      <br/>
      SLOT (2) - 
      <select name="FOODSTUFF_SEQ_SLOT02">
        <option value="0">選択してください</option>
        <?php print($option_tag); ?>
      </select>
      <br/>
      SLOT (3) - 
      <select name="FOODSTUFF_SEQ_SLOT03">
        <option value="0">選択してください</option>
        <?php print($option_tag); ?>
      </select>
      <br/>
      SLOT (4) - 
      <select name="FOODSTUFF_SEQ_SLOT04">
        <option value="0">選択してください</option>
        <?php print($option_tag); ?>
      </select>
      <br/>
      SLOT (5) - 
      <select name="FOODSTUFF_SEQ_SLOT05">
        <option value="0">選択してください</option>
        <?php print($option_tag); ?>
      </select>
      <br/>
      SLOT (6) - 
      <select name="FOODSTUFF_SEQ_SLOT06">
        <option value="0">選択してください</option>
        <?php print($option_tag); ?>
      </select>
      <br/>
      SLOT (7) - 
      <select name="FOODSTUFF_SEQ_SLOT07">
        <option value="0">選択してください</option>
        <?php print($option_tag); ?>
      </select>
      <br/>
      SLOT (8) - 
      <select name="FOODSTUFF_SEQ_SLOT08">
        <option value="0">選択してください</option>
        <?php print($option_tag); ?>
      </select>
      <br/>
      SLOT (9) - 
      <select name="FOODSTUFF_SEQ_SLOT09">
        <option value="0">選択してください</option>
        <?php print($option_tag); ?>
      </select>
      <br/>
      <h4>調理時間(秒)</h4>
      <input type="time" name="COOKING_TIME_SECONDS" step="1" value="00:01:00"/><br/>
      <br/>
      <h4>成果物の使用可能回数</h4>
      <input type="text" name="DELIVERABLE_USES" size="8" value="1"/><br/>
      <br/>
      <h4>成果物のエネルギー量</h4>
      <input type="text" name="DELIVERABLE_ENERGY" size="8" value="4"/><br/>
      <br/>
      <h4>調理により得られる経験値</h4>
      <input type="text" name="EXPERIENCE_POINT" size="8" value="1"/><br/>
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
