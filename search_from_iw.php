<?php header("content-type: text/plain; charset=utf-8"); ?>
受信したヘッダ:
<?php
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

print "--- PARAMETER END ---\n";
?>
