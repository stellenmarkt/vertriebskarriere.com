<?php

include "landingpages.config.php";

foreach ($options as $key=>$option) {
  echo $key . ',';
  echo $option['id'] . ',';
  echo $option['text'] . ',';
  echo $option['tab'] . ',';
  echo $option['panel'] . ',';
  echo $option['query']['q'];
  
  echo "\n";
  
}
