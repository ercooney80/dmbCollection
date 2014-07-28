<?php

$dvds_file = "setup/dvds.txt";
if (!file_exists($dvds_file)) {
    die("missing file $dvds_file\n");
}

require_once "include/DB.php";
$props = DB::init();
echo "\naddDVDs -- url: {$props['url']}\n\n";

$dvds = file($dvds_file);

// populate table by reading file
foreach ($dvds as $str) {
    $info = trim($str);
    $time = time();
    if (empty($info))
        continue;
    if (substr($info, 0, 1) == "#") // skip comment line
        continue;
    list($artist, $title, $discs, $country, $cond, $prod_year, $upc, $category) = array_map('trim', explode("|", $info));
    echo "$artist | $title | $discs | $country | $cond | $prod_year | $upc | $category | $time\n";
    $dvd = R::dispense('dvd');
    $dvd->artist = $artist;
    $dvd->title = $title;
    $dvd->discs = $discs;
    $dvd->country = $country;
    $dvd->cond = $cond;
    $dvd->prod_year = $prod_year;
    $dvd->upc = $upc;
    $dvd->category = $category;
    $dvd->created_at = $time;
    try {
        $id = R::store($dvd);
        echo "#$id: $title\n";
    } catch (Exception $ex) {
        echo $ex->getMessage(), "\n";
    }
}
