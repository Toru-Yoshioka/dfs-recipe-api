<html>
  <head>
    <title>DFS Recipe Search Form</title>
    <style type="text/css">
    .border_outside {
      border: #aaaaaa 2px solid;
      border-collapse: collapse;
    }
    .border_inside th {
      border: #cccccc 1px solid;
      border-collapse: collapse;
      padding: 4px 4px 4px 4px;
      font-size: smaller;
    }
    .border_inside td {
      border: #cccccc 1px solid;
      border-collapse: collapse;
      padding: 4px 4px 4px 4px;
      font-size: smaller;
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
    <h3>DFS レシピ 検索フォーム</h3>
<?php
  // 検索キーワード(食材Seq)取得
  $target_recipe_seq_keys = "";
  $foodstuff_items = $_POST['FOODSTUFF_ITEMS'];
  if (is_array($foodstuff_items)) {
    if ($_POST['SEARCH_TYPE'] === '0') {
      // あいまい検索
      $search_keys = implode(',', $foodstuff_items);
      // あいまい検索レシピSeq取得
      $recipe_seq_result = pg_query('
SELECT
  recipe_seq
FROM
  dfs_recipe_foodstuff_join
WHERE
  foodstuff_seq in (' . $search_keys . ')
GROUP BY
  recipe_seq
');
      if (!$recipe_seq_result) {
        die('クエリーが失敗しました。'.pg_last_error());
      }
    } else {
      // 絞り込み検索
      $exists_sections = "";
      foreach ($foodstuff_items as $value) {
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
      // あいまい検索レシピSeq取得
      $recipe_seq_result = pg_query('
SELECT
  drfja.recipe_seq
FROM
  dfs_recipe_foodstuff_join drfja
WHERE
  drfja.foodstuff_seq != 0
' . $exists_sections . '
GROUP BY
  drfja.recipe_seq
ORDER BY
  drfja.recipe_seq
');
      if (!$recipe_seq_result) {
        die('クエリーが失敗しました。'.pg_last_error());
      }
    }
    $target_recipe_seqs = [];
    for ($i = 0 ; $i < pg_num_rows($recipe_seq_result) ; $i++){
      $rows = pg_fetch_array($recipe_seq_result, NULL, PGSQL_ASSOC);
      $target_recipe_seqs[] = $rows['recipe_seq'];
    }
    $target_recipe_seq_keys = implode(',', $target_recipe_seqs);
    $target_recipe_seq_keys = "WHERE vrwn.recipe_seq in (" . $target_recipe_seq_keys . ")";
  }
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
' . $target_recipe_seq_keys . '
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
        <td rowspan="3"><?php print($recipe_seq); ?></td>
        <td rowspan="3"><?php print($recipe_name_en); ?></td>
        <td rowspan="3"><?php print($recipe_name_jp); ?></td>
        <td rowspan="3"><?php print($cooking_equipment_seq); ?></td>
        <td rowspan="3"><?php print($cookware_name_en); ?></td>
        <td><?php print($foodstuff_name_en_slot01); ?></td>
        <td><?php print($foodstuff_name_en_slot02); ?></td>
        <td><?php print($foodstuff_name_en_slot03); ?></td>
        <td rowspan="3"><?php print($cooking_time_seconds); ?></td>
        <td rowspan="3"><?php print($deliverable_uses); ?></td>
        <td rowspan="3"><?php print($deliverable_energy); ?></td>
        <td rowspan="3"><?php print($experience_point); ?></td>
        <td rowspan="3"><?php print($regist_date); ?></td>
        <td rowspan="3"><?php print($update_date); ?></td>
      </tr>
      <tr class="border_inside">
        <td><?php print($foodstuff_name_en_slot04); ?></td>
        <td><?php print($foodstuff_name_en_slot05); ?></td>
        <td><?php print($foodstuff_name_en_slot06); ?></td>
      </tr>
      <tr class="border_inside">
        <td><?php print($foodstuff_name_en_slot07); ?></td>
        <td><?php print($foodstuff_name_en_slot08); ?></td>
        <td><?php print($foodstuff_name_en_slot09); ?></td>
      </tr>
<?php
  }
?>
    </table>
    <form method="post" action="./recipe_search.php">
      <h4>検索方法</h4>
      <label name="aimai"><input type="radio" name="SEARCH_TYPE" value="0"/>あいまい検索</label>&nbsp;&nbsp;
      <label name="aimai"><input type="radio" name="SEARCH_TYPE" value="1"/>絞り込み検索</label>
      <h4>材料選択</h4>
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
  $option_tag = '';
  for ($i = 0 ; $i < pg_num_rows($foodstuff_result) ; $i++){
    $rows = pg_fetch_array($foodstuff_result, NULL, PGSQL_ASSOC);
?>
      <label name="<?php print($rows['foodstuff_seq']); ?>">
        <input type="checkbox" name="FOODSTUFF_ITEMS[]" value="<?php print($rows['foodstuff_seq']); ?>"/>
        <?php print($rows['foodstuff_name_en']); ?>&nbsp;&nbsp;
      </label>
<?php
  }
?>
      <br/>
      <input type="submit" value="　検　索　"/>
    </form>
<?php
  $close_flag = pg_close($link);
  if ($close_flag){
    //     print('切断に成功しました。<br>');
  }
?>
  </body>
</html>
