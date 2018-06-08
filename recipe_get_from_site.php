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

// レシピシーケンス取得
$recipe_seq_result = pg_query('
SELECT nextval(\'dfs_recipe_tmp_seq\') AS next_recipe_seq
');
if (!$recipe_seq_result) {
    die('クエリーが失敗しました。'.pg_last_error());
}
$rows = pg_fetch_array($recipe_seq_result, NULL, PGSQL_ASSOC);
$next_recipe_seq = $rows['next_recipe_seq'];

$url = "https://www.digitalfarmsystem.com/dfs-recipes/";
$html = file_get_contents($url);

$array = explode("\n", $html); // とりあえず行に分割
$array = array_map('trim', $array); // 各行にtrim()をかける
$array = array_filter($array, 'strlen'); // 文字数が0の行を取り除く
$array = array_values($array); // これはキーを連番に振りなおしてるだけ

foreach ($array as $line) {
  $match_result = "";
  // レシピ名
  preg_match('/<strong class=\'name\'>[^<]+<\/strong>/', $line, $match1);
  if (strlen($match1[0]) <= 0) {
    // 調理器具
    preg_match('/^(DFS[^<]+)<br\/>/', $line, $match2);
    if (strlen($match2[1]) <= 0) {
      // スロット - 食材
      preg_match('/^([0-9] \-[^<]+)<br\/>/', $line, $match3);
      if (strlen($match3[1]) <= 0) {
        // 調理時間
        preg_match('/^Time : ([0-9]+:[0-9]+:[0-9]+): <br\/>/', $line, $match4);
        if (strlen($match4[1]) <= 0) {
          // USES EP XP
          preg_match('/^([0-9]+) Uses \- ([0-9]+) EP\/use \- ([0-9]+) XP<br\/>/', $line, $match5);
          if (strlen($match5[1]) <= 0) {
            // 公開終了日
            preg_match('/^Ends: ([0-9]+\-[0-9]+\-[0-9]+)<br\/>/', $line, $match6);
            if (strlen($match6[1]) <= 0) {
            } else {
              $match_result = $match6[1];
            }
          } else {
            $match_result = "USES:" . $match5[1] . " EP:" . $match5[2] . " XP:" . $match5[3];
          }
        } else {
          $match_result = $match4[1];
        }
      } else {
        // スロット - 食材
        $slot_foodstuff = $match3[1];
        // スロットと食材に分割
        list($slot_no, $foodstuff_name1, $foodstuff_name2, $foodstuff_name3, $foodstuff_name4, $foodstuff_name5) = explode('-', $slot_foodstuff);
        // 食材名で dfs_foodstuff_mst を検索
        $foodstuff_name = trim($foodstuff_name1 . $foodstuff_name2 . $foodstuff_name3 . $foodstuff_name4 . $foodstuff_name5);
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
          die('クエリーが失敗しました。'.pg_last_error());
        }
        if (pg_num_rows($foodstuff_result) > 0) {
          // 食材が登録済みだったらシーケンス取得
          $rows = pg_fetch_array($foodstuff_result, NULL, PGSQL_ASSOC);
          $foodstuff_seq = $rows['foodstuff_seq'];
        } else {
          // 食材が登録されていなかったらシーケンスを取得して登録
          $foodstuff_seq_result = pg_query('
SELECT nextval(\'dfs_foodstuff_seq\') AS next_foodstuff_seq
');
          if (!$foodstuff_seq_result) {
            die('クエリーが失敗しました。'.pg_last_error());
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
            die('クエリーが失敗しました。'.pg_last_error());
          }
        }
      }
    } else {
      // 調理器具名
      $cookware_name = $match2[1];
    }
  } else {
    // レシピ名
    $recipe_name = $match1[0];
  }
  if (strlen($match_result) > 0) {
?>
  <div class="border_inside"><?php print($match_result); ?></div>
<?php
  }
}

  $close_flag = pg_close($link);
  if ($close_flag){
    //     print('切断に成功しました。<br>');
  }
?>
  </body>
</html>
