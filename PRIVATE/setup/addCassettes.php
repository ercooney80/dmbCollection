<?php

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
  $cassette->artist = $artist;
  $cassette->title = $title;
  $cassette->tapes = $tapes;
  $cassette->country = $country;
  $cassette->cond = $cond;
  $cassette->prod_year = $prod_year;
  $cassette->upc = $upc;
  $cassette->category = $category;
  $cassette->created_at = $time;
  $cassette->description = $description;

  try {
    $id = R::store($cassette);
    echo "#$id: $title\n";
  } catch (Exception $ex) {
    echo $ex->getMessage(), "\n";
  }
}
