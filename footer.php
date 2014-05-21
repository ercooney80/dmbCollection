<?php

// Format footer
$creation = '2014';
$current = date('Y');
$date = '&copy; ' . $creation;
if (!($current == $creation)) {
  $date = $date . '&ndash;' . $current;
}

$date = $date . ' Edward R Cooney';
 echo $date;
 ?>

