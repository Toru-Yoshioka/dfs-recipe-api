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
$url = "https://www.digitalfarmsystem.com/dfs-recipes/";
$html = file_get_contents($url);

$array = explode("\n", $html); // とりあえず行に分割
$array = array_map('trim', $array); // 各行にtrim()をかける
$array = array_filter($array, 'strlen'); // 文字数が0の行を取り除く
$array = array_values($array); // これはキーを連番に振りなおしてるだけ

foreach ($array as $line) {
  $match_result = "";
  preg_match('/<strong class=\'name\'>[^<]+<\/strong>/', $line, $match1);
  if (strlen($match1[0]) <= 0) {
    preg_match('/^(DFS[^<]+)<br\/>/', $line, $match2);
    if (strlen($match2[1]) <= 0) {
      preg_match('/^([0-9] \-[^<]+)<br\/>/', $line, $match3);
      if (strlen($match3[1]) <= 0) {
      } else {
        $match_result = $match3[1];
      }
    } else {
      $match_result = $match2[1];
    }
  } else {
    $match_result = $match1[0];
  }
  if (strlen($match_result) > 0) {
?>
  <div class="border_inside"><?php print($match_result); ?></div>
<?php
  }
}
?>
  </body>
</html>
