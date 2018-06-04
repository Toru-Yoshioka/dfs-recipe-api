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
    </style>
  </head>
  <body>
<?php
$url = "https://www.digitalfarmsystem.com/dfs-recipes/";
$html = file_get_contents($url);
var_dump($html);
?>
  </body>
</html>
