<html>
  <head>
    <title>DFS UUID Input Form</title>
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
    <h3>DFS UUID 登録フォーム</h3>
<?php
  // 編集する素材を選択
$selected_name = $_POST['select'];
  // 食材一覧取得
  $uuid_result = pg_query('
SELECT
  duj.dst_name,
  duj.icon_uuid,
  duj.pict_uuid,
  duj.update_date,
  duj.regist_date
FROM
 dfs_uuid_join duj
ORDER BY
 duj.dst_name ASC
');
  if (!$uuid_result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }
?>
    <table class="border_outside">
      <tr class="border_inside">
        <th>対象素材名</th>
        <th>アイコンUUID</th>
        <th>写真UUID</th>
        <th>登録日時</th>
        <th>更新日時</th>
      </tr>
<?php
  for ($i = 0 ; $i < pg_num_rows($uuid_result) ; $i++){
    $rows = pg_fetch_array($uuid_result, NULL, PGSQL_ASSOC);
    $dst_name = $rows['dst_name'];
    $icon_uuid = $rows['icon_uuid'];
    $pict_uuid = $rows['pict_uuid'];
    $update_date = $rows['update_date'];
    $regist_date = $rows['regist_date'];
    // 選択した対象素材だったら変数に保持する
    if ($dst_name == $selected_name) {
      $selected_icon_uuid = $icon_uuid;
      $selected_pict_uuid = $pict_uuid;
    }
?>
      <tr class="border_inside">
        <td><a href="./uuid_form.php?select=<?php print($dst_name); ?>"><?php print($dst_name); ?></a></td>
        <td><?php print($icon_uuid); ?></td>
        <td><?php print($pict_uuid); ?></td>
        <td><?php print($update_date); ?></td>
        <td><?php print($regist_date); ?></td>
      </tr>
<?php
  }
?>
    </table>
    <form method="post" action="./uuid_update.php">
      <h4>対象素材</h4>
      <?php print($selected_name); ?>
      <input name="DST_NAME" type="hidden" value="<?php print($selected_name); ?>"/><br/>      
      アイコンUUID：<br/>
      <input type="text" name="ICON_UUID" size="40" value="<?php print($selected_icon_uuid); ?>"/><br/>      
      写真UUID：<br/>
      <input type="text" name="PICT_UUID" size="40" value="<?php print($selected_pict_uuid); ?>"/><br/>      
      <br/>
      <br/>
      <input type="submit" value="　更　新　"/>
    </form>
  </body>
</html>
