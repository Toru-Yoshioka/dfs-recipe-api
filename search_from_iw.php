<?php header("content-type: text/plain; charset=utf-8"); ?>
受信したヘッダ:
<?php
 
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
$request = $_POST['ITEM'];
print "--- REQUEST IW TEST ---\n";
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
?>
