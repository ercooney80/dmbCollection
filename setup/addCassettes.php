<?php

/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: addCassettes.php
 * Date: 08/16/2014
 * PHP version: 5.3
 * Description: Allows SuperUser to add a cassette to the database
 * ToDo: Enable image stuff
 */
$cassettes_file = "setup/cassettes.txt";
if (!file_exists($cassettes_file)) {
    die("missing file $cassettes_file\n");
}

require_once "include/DB.php";
$props = DB::init();
echo "\naddCassettes -- url: {$props['url']}\n\n";

$cassettes = file($cassettes_file);

// populate table by reading file
foreach ($cassettes as $str) {
    $info = trim($str);
    $time = time();
    if (empty($info))
        continue;
    if (substr($info, 0, 1) == "#") // skip comment line
        continue;
    list($artist, $title, $tapes, $country, $cond, $prod_year, $upc, $category, $description) = array_map('trim', explode("|", $info));
    echo "$artist | $title | $tapes | $country | $cond | $prod_year | $upc | $category | $time | $description\n";

    $cassette = R::dispense('cassette');
    $cassette->artist = strtoupper($artist);
    $cassette->title = strtoupper($title);
    $cassette->tapes = $tapes;
    $cassette->country = strtoupper($country);
    $cassette->cond = strtoupper($cond);
    $cassette->prod_year = $prod_year;
    $cassette->upc = strtoupper($upc);
    $cassette->category = strtoupper($category);
    $cassette->description = strtoupper($description);
    $cassette->created_at = $time;
    try {
        $id = R::store($cassette);
        echo "#$id: $title\n";
    } catch (Exception $ex) {
        echo $ex->getMessage(), "\n";   // throw exception message
    }
}
