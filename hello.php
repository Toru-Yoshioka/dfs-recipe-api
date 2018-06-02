<html>
 <head>
  <title>DFS Recipe Input Form</title>
 </head>
 <body>
 <?php echo '<p>Hello World</p>'; ?> 
<?php
date_default_timezone_set('Asia/Tokyo');
$conn = "host=ec2-23-23-248-192.compute-1.amazonaws.com dbname=dl8app8ukml19 user=zukuhaourmbbsk password=f9e66d533b3f6cdae3d67c88e7baac7bc05f380fcaf047471e726d3b332ef74a";
$link = pg_connect($conn);
if (!$link) {
  die('接続失敗です。'.pg_last_error());
}
// 接続に成功
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
  <form>
    <select name="COOKWARE">
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
  </form>
 </body>
</html>
