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
$request = $_GET['ITEM'];
print "--- REQUEST IW TEST ---\n";
switch (gettype($request)) {
case 'array':
  foreach ($request as $key => $value) {
    echo "キー : " . $key . "\n";
    echo "値 : " . $value . "\n";
    echo "\n";
  }
  break;
default:
  print ($request);
}
print "--- PARAMETER END ---\n";
?>
