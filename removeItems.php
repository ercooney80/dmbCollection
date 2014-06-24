<?php

require_once "include/DB.php";
DB::init();
$params = (object) $_REQUEST;

$ids = $params->ids;
$type = $params->table;

try {
  $beans = R::loadAll($type, $ids);
  R::trashAll($beans);

  if ($type != 'vinyl' && $type != 'vhs') {
    $type .= 's';
  }
  // Display updated list
  header("location: " . $type . ".php");
} catch (Exception $ex) {
  
}

