<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: Homepage/frontpage.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description: Site news, recently added 
 * ToDo:
 */
require_once "include/DB.php";
$props = DB::init();

$news = 'This is a simple RedbeanPHP site with and SQL database displaying my collection'
        . ' of Dave Matthews Band related memorabilia.  This is a work in progress and a'
        . ' learning tool for me.  If you have any memorabilia that you think I might want'
        . ' feel free to contact me. </br>-ED';

$listSize = 10;
try {
  $listOfTables = R::inspect();
  foreach ($listOfTables as $table) {
    $items = R::findAll($table);
    if ($table == 'user') {  // skip the user table
      continue;
    }
    foreach ($items as $item) {
      $all_items[] = array(
          'table' => $table,
          'id' => $item->id,
          'created_at' => $item->created_at
      );
    }
  }

  // Sort the data with timstamp descending
  foreach ($all_items as $key => $row) {
    $created_at[$key] = $row['created_at'];
  }
  array_multisort($created_at, SORT_DESC, $all_items);


  // Build the recent additions array
  for ($i = 0; $i < $listSize; $i++) {
    $element = $all_items[$i];
    $item = R::load($element['table'], $element['id']);
    $new_items[] = array(
        'artist' => $item->artist,
        'title' => $item->title,
        'country' => $item->country,
        'category' => $item->category,
        'format' => strtoupper($element['table']),
        'upc' => $item->upc,
    );
  }
} catch (Exception $ex) {
  $warning = $ex->getMessage();
}

//echo var_dump($new_items);
?>

<h3>Site News</h3>
<p><?php echo $news ?></p>

<h3>New Additions</h3>
<table id="frontpagetable">
  <th>Artist</th>
  <th>Title</th>
  <th>Country</th>
  <th>Category</th>
  <th>Format</th>
  <th>UPC</th>
  <?php foreach ($new_items as $new_item): ?>
    <tr>
      <td><?php echo $new_item['artist']; ?></td>
      <td><?php echo $new_item['title']; ?></td>
      <td><?php echo $new_item['country']; ?></td>
      <td><?php echo $new_item['category']; ?></td>
      <td><?php echo $new_item['format']; ?></td>
      <td><?php echo $new_item['upc']; ?></td>
    </tr>
  <?php endforeach; ?>
</table>








