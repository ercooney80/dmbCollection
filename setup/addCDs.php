<?php

$cds_file = "setup/cds.txt";
if (!file_exists($cds_file)) {
    die("missing file $cds_file\n");
}

require_once "include/DB.php";
$props = DB::init();
echo "\naddCDs -- url: {$props['url']}\n\n";

$cds = file($cds_file);

// populate table by reading file
foreach ($cds as $str) {
    $info = trim($str);
    $time = time();
    if (empty($info))
        continue;
    if (substr($info, 0, 1) == "#") // skip comment line
        continue;
    list($artist, $title, $discs, $country, $cond, $prod_year, $upc, $category, $description) = array_map('trim', explode("|", $info));
    echo "$artist | $title | $discs | $country | $cond | $prod_year | $upc | $category | $time | $description\n";
    $cd = R::dispense('cd');
    $cd->artist = strtoupper($artist);
    $cd->title = strtoupper($title);
    $cd->discs = $discs;
    $cd->country = strtoupper($country);
    $cd->cond = strtoupper($cond);
    $cd->prod_year = $prod_year;
    $cd->upc = strtoupper($upc);
    $cd->category = strtoupper($category);
    $cd->description = strtoupper($description);
    $cd->created_at = $time;
    try {
        $id = R::store($cd);
        echo "#$id: $title\n";
    } catch (Exception $ex) {
        echo $ex->getMessage(), "\n";
    }
}
