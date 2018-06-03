<html>
  <head>
    <title>DFS Recipe Input Form</title>
    <style type="text/css">
    .border_outside {
      border: #aaaaaa 2px solid;
      border-collapse: collapse;
    }
    .border_inside th {
      border: #cccccc 1px solid;
      border-collapse: collapse;
      padding: 4px 4px 4px 4px;
    }
    .border_inside td {
      border: #cccccc 1px solid;
      border-collapse: collapse;
      padding: 4px 4px 4px 4px;
    }
    </style>
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
<?php
  // レシピ一覧取得
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
ORDER BY
 vrwn.recipe_name_en ASC
');
  if (!$recipe_result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }
?>
    <table class="border_outside">
      <tr class="border_inside">
        <th rowspan="3">Seq</th>
        <th rowspan="3">レシピ名(英名)</th>
        <th rowspan="3">レシピ名(和名)</th>
        <th rowspan="3">調理器具Seq</th>
        <th rowspan="3">調理器具名称</th>
        <th>Slot(1)</th>
        <th>Slot(2)</th>
        <th>Slot(3)</th>
        <th rowspan="3">調理所要時間</th>
        <th rowspan="3">使用可能回数</th>
        <th rowspan="3">エネルギー</th>
        <th rowspan="3">獲得経験値</th>
        <th rowspan="3">登録日時</th>
        <th rowspan="3">更新日時</th>
      </tr>
      <tr class="border_inside">
        <th>Slot(4)</th>
        <th>Slot(5)</th>
        <th>Slot(6)</th>
      </tr>
      <tr class="border_inside">
        <th>Slot(7)</th>
        <th>Slot(8)</th>
        <th>Slot(9)</th>
      </tr>
<?php
  for ($i = 0 ; $i < pg_num_rows($recipe_result) ; $i++){
    $rows = pg_fetch_array($recipe_result, NULL, PGSQL_ASSOC);
    $recipe_seq = $rows['recipe_seq'];
    $recipe_name_en = $rows['recipe_name_en'];
    $recipe_name_jp = $rows['recipe_name_jp'];
    $cooking_equipment_seq = $rows['cooking_equipment_seq'];
    $cookware_name_en = $rows['cookware_name_en'];
    $foodstuff_seq_slot01 = $rows['foodstuff_seq_slot01'];
    $foodstuff_name_en_slot01 = $rows['foodstuff_name_en_slot01'];
    $foodstuff_seq_slot02 = $rows['foodstuff_seq_slot02'];
    $foodstuff_name_en_slot02 = $rows['foodstuff_name_en_slot02'];
    $foodstuff_seq_slot03 = $rows['foodstuff_seq_slot03'];
    $foodstuff_name_en_slot03 = $rows['foodstuff_name_en_slot03'];
    $foodstuff_seq_slot04 = $rows['foodstuff_seq_slot04'];
    $foodstuff_name_en_slot04 = $rows['foodstuff_name_en_slot04'];
    $foodstuff_seq_slot05 = $rows['foodstuff_seq_slot05'];
    $foodstuff_name_en_slot05 = $rows['foodstuff_name_en_slot05'];
    $foodstuff_seq_slot06 = $rows['foodstuff_seq_slot06'];
    $foodstuff_name_en_slot06 = $rows['foodstuff_name_en_slot06'];
    $foodstuff_seq_slot07 = $rows['foodstuff_seq_slot07'];
    $foodstuff_name_en_slot07 = $rows['foodstuff_name_en_slot07'];
    $foodstuff_seq_slot08 = $rows['foodstuff_seq_slot08'];
    $foodstuff_name_en_slot08 = $rows['foodstuff_name_en_slot08'];
    $foodstuff_seq_slot09 = $rows['foodstuff_seq_slot09'];
    $foodstuff_name_en_slot09 = $rows['foodstuff_name_en_slot09'];
    $cooking_time_seconds = $rows['cooking_time_seconds'];
    $deliverable_uses = $rows['deliverable_uses'];
    $deliverable_energy = $rows['deliverable_energy'];
    $experience_point = $rows['experience_point'];
    $update_date = $rows['update_date'];
    $regist_date = $rows['regist_date'];
?>
      <tr class="border_inside">
        <th rowspan="3"><?php print($recipe_seq); ?></th>
        <th rowspan="3"><?php print($recipe_name_en); ?></th>
        <th rowspan="3"><?php print($recipe_name_jp); ?></th>
        <th rowspan="3"><?php print($cooking_equipment_seq); ?></th>
        <th rowspan="3"><?php print($cookware_name_en); ?></th>
        <th><?php print($foodstuff_name_en_slot01); ?></th>
        <th><?php print($foodstuff_name_en_slot02); ?></th>
        <th><?php print($foodstuff_name_en_slot03); ?></th>
        <th rowspan="3"><?php print($cooking_time_seconds); ?></th>
        <th rowspan="3"><?php print($deliverable_uses); ?></th>
        <th rowspan="3"><?php print($deliverable_energy); ?></th>
        <th rowspan="3"><?php print($experience_point); ?></th>
        <th rowspan="3"><?php print($regist_date); ?></th>
        <th rowspan="3"><?php print($update_date); ?></th>
      </tr>
      <tr class="border_inside">
        <th><?php print($foodstuff_name_en_slot04); ?></th>
        <th><?php print($foodstuff_name_en_slot05); ?></th>
        <th><?php print($foodstuff_name_en_slot06); ?></th>
      </tr>
      <tr class="border_inside">
        <th><?php print($foodstuff_name_en_slot07); ?></th>
        <th><?php print($foodstuff_name_en_slot08); ?></th>
        <th><?php print($foodstuff_name_en_slot09); ?></th>
      </tr>
<?php
  }
?>
    </table>
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
