<?php

if (isset($_SERVER['REQUEST_URI'])) {
  echo "<pre>\n";  // if web access allowed and used
}

require_once "setup/init.php";
chdir(__DIR__);
require_once "setup/addCDs.php";
require_once "setup/addCassettes.php";
require_once "setup/addDVDs.php";
require_once "setup/addUsers.php";
require_once "setup/addVinyl.php";
