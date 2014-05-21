<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: Music/cassettesContent.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description: build the content for the cassette display page
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

$cassettes = R::findAll('cassette', "1 order by $orderField asc");

// Build the cassette display array
foreach ($cassettes as $cassette) {
  $list[] = array(
      'id' => $cassette->id,
      'artist' => $cassette->artist,
      'title' => $cassette->title,
      'tapes' => $cassette->tapes,
      'country' => $cassette->country,
      'condition' => $cassette->cond,
      'year' => $cassette->prod_year,
      'upc' => $cassette->upc,
      'category' => $cassette->category,
      'description' => $cassette->description,
  );
}
?>
<h3>Cassettes</h3>
<h4>To modify an item, click on the artist entry for the item</br>
  To remove items check the boxes
</h4>
<form action="removeItems.php" method="POST">
<?php if ($superUser): ?>
  <input type="hidden" name="table" value="cd" />
<table class="changer">
    <td><button class="button" type="submit" name="remove">Remove Items</button></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</table>
<table>
	  <th style="width: 12%"><a href="cassettes.php?orderField=artist">Artist</a></th>
  <th style="width: 20%"><a href="cassettes.php?orderField=title">Title</a></th>
  <th style="width: 4%"><a href="cassettes.php?orderField=tapes">Tapes</a></th>
  <th style="width: 9%"><a href="cassettes.php?orderField=country">Country</a></th>
  <th style="width: 7%"><a href="cassettes.php?orderField=cond">Condition</a></th>                    
  <th style="width: 4%"><a href="cassettes.php?orderField=prod_year">Year</a></th>
  <th style="width: 10%"><a href="cassettes.php?orderField=upc">UPC/CAT#</a></th>                             
  <th style="width: 10%"><a href="cassettes.php?orderField=category">Category</a></th>
  <th style="width: 24%">Description</th>
    <?php foreach ($list as $cassette): ?>
    <tr>
      <td><input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($cassette['id']) ?>" /> 
        <a href="modifyCassette.php?id=<?php echo $cassette['id'] ?>"> <?php echo htmlspecialchars($cassette['artist']); ?></a></td>
      <td><?php echo htmlspecialchars($cassette['title']); ?></td>
      <td style="text-align: center;"><?php echo htmlspecialchars($cassette['tapes']); ?></td>
      <td><?php echo htmlspecialchars($cassette['country']); ?></td>
      <td><?php echo htmlspecialchars($cassette['condition']); ?></td>
      <td style="text-align: center;"><?php echo htmlspecialchars($cassette['year']); ?></td>
      <td><?php echo htmlspecialchars($cassette['upc']); ?></td>
      <td><?php echo htmlspecialchars($cassette['category']); ?></td>
      <td><?php echo htmlspecialchars($cassette['description']); ?></td>
    </tr>
  <?php endforeach; ?>
</table>	
<table class="changer">
      <td><button class="button" type="submit" name="remove">Remove Items</button></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
</table>
<?php else: ?>
<table> 
  <th style="width: 12%"><a href="cassettes.php?orderField=artist">Artist</a></th>
  <th style="width: 20%"><a href="cassettes.php?orderField=title">Title</a></th>
  <th style="width: 4%"><a href="cassettes.php?orderField=tapes">Tapes</a></th>
  <th style="width: 9%"><a href="cassettes.php?orderField=country">Country</a></th>
  <th style="width: 7%"><a href="cassettes.php?orderField=cond">Condition</a></th>                    
  <th style="width: 4%"><a href="cassettes.php?orderField=prod_year">Year</a></th>
  <th style="width: 10%"><a href="cassettes.php?orderField=upc">UPC/CAT#</a></th>                             
  <th style="width: 10%"><a href="cassettes.php?orderField=category">Category</a></th>
  <th style="width: 24%">Description</th>
  <?php foreach ($list as $cassette): ?>
    <tr>
      <td><a href="modifyCassette.php?id=<?php echo $cassette['id'] ?>">
        <?php echo htmlspecialchars($cassette['artist']); ?></a></td>
      <td><?php echo htmlspecialchars($cassette['title']); ?></td>
      <td style="text-align: center;"><?php echo htmlspecialchars($cassette['tapes']); ?></td>
      <td><?php echo htmlspecialchars($cassette['country']); ?></td>
      <td><?php echo htmlspecialchars($cassette['condition']); ?></td>
      <td style="text-align: center;"><?php echo htmlspecialchars($cassette['year']); ?></td>
      <td><?php echo htmlspecialchars($cassette['upc']); ?></td>
      <td><?php echo htmlspecialchars($cassette['category']); ?></td>
      <td><?php echo htmlspecialchars($cassette['description']); ?></td>
    </tr>
  <?php endforeach; ?>
</table>	
<?php endif; ?>
</form>