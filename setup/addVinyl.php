<?php

$vinyl_file = "setup/vinyl.txt";
if (!file_exists($vinyl_file)) {
    die("missing file $vinyl_file\n");
}

require_once "include/DB.php";
$props = DB::init();
echo "\naddVinyl -- url: {$props['url']}\n\n";

$vinyl = file($vinyl_file);

// populate table by reading file
foreach ($vinyl as $str) {
    $info = trim($str);
    $time = time();
    if (empty($info))
        continue;
    if (substr($info, 0, 1) == "#") // skip comment line
        continue;
    list($artist, $title, $records, $country, $cond, $prod_year, $category, $vinyl_size, $upc, $description) = array_map('trim', explode("|", $info));
    echo "$artist | $title | $records | $country | $cond | $prod_year | $category | $vinyl_size | $upc | $description | $time\n";
    $vinyl = R::dispense('vinyl');
    $vinyl->artist = $artist;
    $vinyl->title = $title;
    $vinyl->records = $records;
    $vinyl->country = $country;
    $vinyl->cond = $cond;
    $vinyl->prod_year = $prod_year;
    $vinyl->category = $category;
    $vinyl->vinyl_size = $vinyl_size;
    $vinyl->upc = $upc;
    $vinyl->description = $description;
    $vinyl->created_at = $time;
    try {
        $id = R::store($vinyl);
        echo "#$id: $title\n";
    } catch (Exception $ex) {
        echo $ex->getMessage(), "\n";
    }
}
