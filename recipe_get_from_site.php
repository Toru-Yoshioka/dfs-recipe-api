<html>
  <head>
    <title>DFS Recipe Get From Official Site</title>
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
    .border_inside {
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
// DB 初期化
$init_result = pg_query('
DELETE FROM dfs_recipe_mst;
');
if (!$init_result) {
  die('クエリー(DEL1)が失敗しました。'.pg_last_error());
}
$init_result = pg_query('
DELETE FROM dfs_foodstuff_mst;
');
if (!$init_result) {
  die('クエリー(DEL2)が失敗しました。'.pg_last_error());
}
$init_result = pg_query('
DELETE FROM dfs_recipe_foodstuff_join;
');
if (!$init_result) {
  die('クエリーが(DEL3)失敗しました。'.pg_last_error());
}
$init_result = pg_query('
select setval (\'dfs_recipe_seq\', 1, false);
');
if (!$init_result) {
  die('クエリー(SEQ1)が失敗しました。'.pg_last_error());
}
$init_result = pg_query('
select setval (\'dfs_foodstuff_seq\', 1, false);
');
if (!$init_result) {
  die('クエリーが(SEQ2)失敗しました。'.pg_last_error());
}

$url = "https://www.digitalfarmsystem.com/dfs-recipes/";
$html = file_get_contents($url);

$array = explode("\n", $html); // とりあえず行に分割
$array = array_map('trim', $array); // 各行にtrim()をかける
$array = array_filter($array, 'strlen'); // 文字数が0の行を取り除く
$array = array_values($array); // これはキーを連番に振りなおしてるだけ

// レシピ登録用変数初期化
$ends_date = 'null';
$resipe_foodstuff_join_array = array();

foreach ($array as $line) {
  $match_result = "";
  // レシピ名
  preg_match('/<strong class=\'name\'>([^<]+)<\/strong>/', $line, $match);
  if (strlen($match[1]) > 0) {
    print "<div clas=\"border_inside\">レシピ名：" . $match[1] . "</div><br/>\n";
    // レシピ名
    $recipe_name_en = $match[1];
    continue;
  }
  // 調理器具
  preg_match('/^(DFS[^<]+)<br\/>/', $line, $match);
  if (strlen($match[1]) > 0) {
    // 調理器具名
    $cookware_name = $match[1];
    // 調理器具シーケンス取得
    $cookware_result = pg_query('
SELECT
 dcm.cookware_seq,
 dcm.cookware_name_en,
 dcm.cookware_name_jp
FROM
 dfs_cookware_mst dcm
WHERE
 dcm.cookware_name_en = \'' . $cookware_name . '\'
');
    if (!$cookware_result) {
      die('クエリー(調理器具)が失敗しました。'.pg_last_error());
    }
    if (pg_num_rows($cookware_result) > 0) {
      // 調理器具が登録済みだったらシーケンス取得
      $rows = pg_fetch_array($cookware_result, NULL, PGSQL_ASSOC);
      $cooking_equipment_seq = $rows['cookware_seq'];
    }
    continue;
  }
  // スロット - 食材
  preg_match('/^([0-9] \-[^<]+)<br\/>/', $line, $match);
  if (strlen($match[1]) > 0) {
    // スロット - 食材
    $slot_foodstuff = $match[1];
    // スロットと食材に分割
    $slot_foodstuff_array = explode('-', $slot_foodstuff);
    $slot_no = $slot_foodstuff_array[0];
    $foodstuff_array = array_slice($slot_foodstuff_array, 1);
    // 食材名で dfs_foodstuff_mst を検索
    $foodstuff_name = trim(implode('-', $foodstuff_array));
    $foodstuff_result = pg_query('
SELECT
 dfm.foodstuff_seq,
 dfm.foodstuff_name_en,
 dfm.foodstuff_name_jp
FROM
 dfs_foodstuff_mst dfm
WHERE
 dfm.foodstuff_name_en = \'' . $foodstuff_name . '\'
');
    if (!$foodstuff_result) {
      die('クエリー(スロット食材)が失敗しました。'.pg_last_error());
    }
    if (pg_num_rows($foodstuff_result) > 0) {
      // 食材が登録済みだったらシーケンス取得
      $rows = pg_fetch_array($foodstuff_result, NULL, PGSQL_ASSOC);
      $foodstuff_seq = $rows['foodstuff_seq'];
      $resipe_foodstuff_join_array[intVal($slot_no)] = $foodstuff_seq;
    } else {
      // 食材が登録されていなかったらシーケンスを取得して登録
      $foodstuff_seq_result = pg_query('
SELECT nextval(\'dfs_foodstuff_seq\') AS next_foodstuff_seq
');
      if (!$foodstuff_seq_result) {
        die('クエリー(食材SEQ)が失敗しました。'.pg_last_error());
      }
      $rows = pg_fetch_array($foodstuff_seq_result, NULL, PGSQL_ASSOC);
      $next_foodstuff_seq = $rows['next_foodstuff_seq'];
      // 新食材登録
      $new_foodstuff_result = pg_query('
INSERT INTO
  dfs_foodstuff_mst
  (
	foodstuff_seq,
	foodstuff_name_en,
	foodstuff_name_jp,
	foodstuff_uses,
	foodstuff_energy,
	update_date,
	regist_date
  ) VALUES (
  ' . $next_foodstuff_seq . ',
  \'' . $foodstuff_name . '\',
  \'\',
  0,
  0,
  current_timestamp,
  current_timestamp
 )
');
      if (!$new_foodstuff_result) {
        die('クエリー(食材INSERT)が失敗しました。'.pg_last_error());
      }
      // 配列登録
      $resipe_foodstuff_join_array[intVal($slot_no)] = $next_foodstuff_seq;
    }
    continue;
  }
  // 調理時間
  preg_match('/^Time : ([0-9]+:[0-9]+:[0-9]+): <br\/>/', $line, $match);
  if (strlen($match[1]) > 0) {
    //print "<div clas=\"border_inside\">調理時間：" . $match[1] . "</div><br/>\n";
    // 調理時間
    $cooking_time_array = explode(':', $match[1]);
    // 調理時間演算
    $formated_seconds = (intVal($cooking_time_array[0]) * 360) + (intVal($cooking_time_array[1]) * 60) + intVal($cooking_time_array[2]);
    //print "<div clas=\"border_inside\">調理時間(計算結果)：" . $formated_seconds . "</div><br/>\n";
    continue;
  }
  // USES EP XP
  preg_match('/^([0-9]+)[ ]+Uses?[ ]+\-[ ]+([0-9]+)[ ]+EP\/use[ ]+\-[ ]+([0-9]+)[ ]+XP<br\/>/', $line, $match);
  if (strlen($match[1]) > 0) {
    //print "<div clas=\"border_inside\">USES/EP/XP：" . $match[1] . "</div><br/>\n";
    $deliverable_uses = $match[1];
    $deliverable_energy = $match[2];
    $experience_point = $match[3];
    //print "<div clas=\"border_inside\">USES/EP/XP(整形結果)：" . $deliverable_uses . " / " . $deliverable_energy . " / " . $experience_point . "</div><br/>\n";
    continue;
  }
  // 公開終了日
  preg_match('/^Ends: ([0-9]+\-[0-9]+\-[0-9]+)<br\/>/', $line, $match);
  if (strlen($match[1]) > 0) {
    $ends_date = $match[1];
    continue;
  }
  // セパレータ
  preg_match('/^([\-]+<br\/><br\/>)/', $line, $match);
  if (strlen($match[1]) > 0) {
    // レシピ登録処理
    // 公開終了日フォーマット
    if ($ends_date != 'null') {
      $ends_date = 'to_date(\'' . $ends_date . '\', \'YYYY/MM/DD\')';
    }
    // レシピシーケンス取得
    $recipe_seq_result = pg_query('
SELECT nextval(\'dfs_recipe_seq\') AS next_recipe_seq
');
    if (!$recipe_seq_result) {
      die('クエリー(レシピSEQ)が失敗しました。'.pg_last_error());
    }
    $rows = pg_fetch_array($recipe_seq_result, NULL, PGSQL_ASSOC);
    $next_recipe_seq = $rows['next_recipe_seq'];
    // レシピマスタ登録
    $query = '
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
  \'\',
  ' . intVal($cooking_equipment_seq) . ',
  ' . intVal($formated_seconds) . ',
  ' . intVal($deliverable_uses) . ',
  ' . intVal($deliverable_energy) . ',
  ' . intVal($experience_point) . ',
  ' . $ends_date . ',
  current_timestamp,
  current_timestamp
 )
';
    $result = pg_query($query);
    if (!$result) {
      print $query;
      die('クエリー(レシピINSERT)が失敗しました。'.pg_last_error());
    }
    // 食材紐づけ登録
    for ($i = 1 ; $i < 10 ; $i++){
      // 配列にスロットが存在するかチェック
      $foodstuff_seq = "0";
      if (array_key_exists($i, $resipe_foodstuff_join_array)) {
        $foodstuff_seq = $resipe_foodstuff_join_array[intVal($i)];
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
  ' . $i . ',
  ' . $foodstuff_seq . ',
  current_timestamp,
  current_timestamp
 )
');
      if (!$result) {
        die('クエリー(レシピ食材JOIN)が失敗しました。'.pg_last_error());
      }
    }
    // 再初期化
    $ends_date = 'null';
    $resipe_foodstuff_join_array = array();
    continue;
  }
}

$close_flag = pg_close($link);
if ($close_flag){
  //     print('切断に成功しました。<br>');
}
?>
  </body>
</html>
