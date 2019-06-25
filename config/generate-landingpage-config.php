<?php

include "landingpages.config.php";

$fp = fopen("pages.csv", "r");
$ids = [];

while ($set = fgetcsv($fp, 0, "\t")) {
  $ids[$set[1]] = $set[0];
}
fclose($fp);

foreach ($options as $key => $opt) {
  if (!isset($ids[$key])) continue;
  
  $options[$key]['id'] = $ids[$key];
}

$optionsStr = var_export($options, true);

file_put_contents("landingpages.options.arr", $optionsStr);



  