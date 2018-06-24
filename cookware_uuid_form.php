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
    <h3>DFS 調理機器 UUID 登録フォーム</h3>
<?php
  // 編集する素材を選択
$selected_name = $_POST['selected_name'];
$selected_icon_uuid = $_POST['selected_icon_uuid'];
$selected_pict_uuid = $_POST['selected_pict_uuid'];
  // 食材一覧取得
  $uuid_result = pg_query('
SELECT
  dcm.cookware_name_en,
  duj.icon_uuid,
  duj.pict_uuid,
  duj.update_date,
  duj.regist_date
FROM
  dfs_cookware_mst dcm
  LEFT OUTER JOIN dfs_uuid_join duj
  ON dcm.cookware_name_en = duj.dst_name
ORDER BY
  dcm.cookware_name_en ASC
');
  if (!$uuid_result) {
    die('クエリーが失敗しました。'.pg_last_error());
  }
?>
    <form method="post" action="./cookware_uuid_update.php">
      <input type="radio" name="MODE" value="1"/> 新規追加&nbsp;&nbsp;
      <input type="radio" name="MODE" value="2" checked="true"/> 更新&nbsp;&nbsp;
      <input type="radio" name="MODE" value="9"/> 削除<br/>
      <h4>対象調理器具</h4>
      <?php print($selected_name); ?>
      <input name="DST_NAME" type="hidden" value="<?php print($selected_name); ?>"/><br/><br/>      
      アイコンUUID：<br/>
      <input type="text" name="ICON_UUID" size="40" value="<?php print($selected_icon_uuid); ?>"/><br/>      
      写真UUID：<br/>
      <input type="text" name="PICT_UUID" size="40" value="<?php print($selected_pict_uuid); ?>"/><br/>      
      <br/>
      <br/>
      <input type="submit" value="　実　行　"/>
    </form>
    <table class="border_outside">
      <tr class="border_inside">
        <th>対象調理器具</th>
        <th>アイコンUUID</th>
        <th>写真UUID</th>
        <th>登録日時</th>
        <th>更新日時</th>
      </tr>
<?php
  for ($i = 0 ; $i < pg_num_rows($uuid_result) ; $i++){
    $rows = pg_fetch_array($uuid_result, NULL, PGSQL_ASSOC);
    $cookware_name_en = $rows['cookware_name_en'];
    $icon_uuid = $rows['icon_uuid'];
    $pict_uuid = $rows['pict_uuid'];
    $update_date = $rows['update_date'];
    $regist_date = $rows['regist_date'];
?>
      <tr class="border_inside">
        <td>
          <a href="javascript:void(0);" onclick="javascript:document.getElementById('<?php print($cookware_name_en); ?>').submit();"><?php print($cookware_name_en); ?></a>
        </td>
        <td><img alt="<?php print($icon_uuid); ?>" src="<?php print("http://secondlife.com/app/image/" . $icon_uuid . "/2"); ?>"/></td>
        <td><img alt="<?php print($pict_uuid); ?>" src="<?php print("http://secondlife.com/app/image/" . $pict_uuid . "/2"); ?>"/></td>
        <td><?php print($update_date); ?></td>
        <td><?php print($regist_date); ?></td>
        <form id="<?php print($cookware_name_en); ?>" method="post" action="./cookware_uuid_form.php">
          <input type="hidden" name="selected_name" value="<?php print($cookware_name_en); ?>"/>
          <input type="hidden" name="selected_icon_uuid" value="<?php print($icon_uuid); ?>"/>
          <input type="hidden" name="selected_pict_uuid" value="<?php print($pict_uuid); ?>"/>
        </form>
      </tr>
<?php
  }
?>
    </table>
  </body>
</html>
