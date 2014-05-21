<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: Music/vinylContent.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description: build the content for the vinyl display page
 * ToDo:
 */

require_once "include/Session.php";
$session = new Session();
require_once "include/DB.php";
$props = DB::init();
$params = (object) $_REQUEST;

$orderField = "title";
if (isset($params->orderField)) {
  $orderField = $params->orderField;
}

$vinyls = R::findAll('vinyl', "1 order by $orderField asc");

// Build the vinyl display array
foreach ($vinyls as $vinyl) {
  $list[] = array(
      'artist' => $vinyl->artist,
      'title' => $vinyl->title,
      'records' => $vinyl->records,
      'country' => $vinyl->country,
      'condition' => $vinyl->cond,
      'year' => $vinyl->prod_year,
      'upc' => $vinyl->upc,
      'category' => $vinyl->category,
      'description' => $vinyl->description,
      'size' => $vinyl->vinyl_size,
  );
}
?>

<table> 
  <th style="width: 8%"><a href="vinyl.php?orderField=artist">Artist</a></th>
  <th style="width: 20%"><a href="vinyl.php?orderField=title">Title</a></th>
  <th style="width: 6%"><a href="vinyl.php?orderField=records">Records</a></th>
  <th style="width: 9%"><a href="vinyl.php?orderField=country">Country</a></th>
  <th style="width: 7%"><a href="vinyl.php?orderField=cond">Condition</a></th>                    
  <th style="width: 4%"><a href="vinyl.php?orderField=prod_year">Year</a></th>
  <th style="width: 9%"><a href="vinyl.php?orderField=upc">UPC/CAT#</a></th>                             
  <th style="width: 7%"><a href="vinyl.php?orderField=category">Category</a></th>
  <th style="width: 10%"><a href="vinyl.php?orderField=vinyl_size">Vinyl Size</a></th>
  <th style="width: 19%">Description</th>
  <?php foreach ($list as $vinyl): ?>
    <tr>
      <td><?php echo htmlspecialchars($vinyl['artist']); ?></td>
      <td><?php echo htmlspecialchars($vinyl['title']); ?></td>
      <td style="text-align: center;"><?php echo htmlspecialchars($vinyl['records']); ?></td>
      <td><?php echo htmlspecialchars($vinyl['country']); ?></td>
      <td><?php echo htmlspecialchars($vinyl['condition']); ?></td>
      <td style="text-align: center;"><?php echo htmlspecialchars($vinyl['year']); ?></td>
      <td><?php echo htmlspecialchars($vinyl['upc']); ?></td>
      <td><?php echo htmlspecialchars($vinyl['category']); ?></td>
      <td style="text-align: center;"><?php echo htmlspecialchars($vinyl['size']); ?></td>
      <td><?php echo htmlspecialchars($vinyl['description']); ?></td>
    </tr>
  <?php endforeach; ?>

</table>

