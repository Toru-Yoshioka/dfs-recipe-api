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
/**
 * @author Wouter Hobble
 * @copyright 2008
 */
 
/*
foreach ($_SERVER as $k => $v)
{
	if( substr($k, 0, 5) == 'HTTP_')
	{
		print "\n". $k. "\t". $v;
	}
}
*/

/*
$request = $_POST['ITEM'];
print "TYPE: " . gettype($request) . "\n";
switch (gettype($request)) {
case 'array':
  foreach ($request as $value) {
    echo "値 : " . $value . "\n";
    echo "\n";
  }
  break;
default:
  print ($request) . "\n";
}
print "--- PARAMETER END ---\n";
*/
/*
$json_string = file_get_contents('php://input');
print $json_string . "\n";
$obj = json_decode($json_string);
print "TYPE: " . gettype($obj) . "\n";
switch (gettype($obj)) {
case 'array':
  foreach ($obj as $value) {
    echo "値 : " . $value . "\n";
    echo "\n";
  }
  break;
default:
  print ($obj) . "\n";
}
*/
$in_section = "";
$data = $_POST['items'];
$item_array = array_unique(explode('/', $data));
foreach ($item_array as $value) {
  $str_grep = preg_replace('/^(.+)[ ]+\(?[0-9]+\)?/', '$1', $value);
  if (strlen($str_grep) > 0) {
    $in_section = $in_section . ",'" . $str_grep . "'";
  } else {
    $in_section = "'" . $str_grep . "'";
  } 
  //print "値 : " . $str_grep . "\n";
}

print "--- PARAMETER END ---\n";

$result = pg_query('
SELECT
  dfm.foodstuff_name_en
FROM
  dfs_foodstuff_mst dfm
WHERE
  dfm.foodstuff_name_en in (
    ' . $in_section . '
  )
ORDER BY
  dfm.foodstuff_name_en ASC
');
if (!$result) {
  die('クエリーが失敗しました。'.pg_last_error());
}
$response = "";
for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
  $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
  print $rows['foodstuff_name_en'] . "\n";
}

$close_flag = pg_close($link);
if ($close_flag){
  //     print('切断に成功しました。<br>');
}
?>
