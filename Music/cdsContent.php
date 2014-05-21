<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: Music/cdsContent.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description: build the content for the cd display page
 * ToDo:
 */
require_once "include/Session.php";
$session = new Session();
require_once "include/DB.php";
$props = DB::init();
$params = (object) $_REQUEST;

$superUser = FALSE;
if (isset($session->user)) {
  if ($session->user->level == 1) {
    $superUser = TRUE;
  }
}

$orderField = "title";
if (isset($params->orderField)) {
  $orderField = $params->orderField;
}

$cds = R::findAll('cd', "1 order by $orderField asc");

// Build the cd display array
foreach ($cds as $cd) {
  $list[] = array(
      'id' => $cd->id,
      'artist' => $cd->artist,
      'title' => $cd->title,
      'discs' => $cd->discs,
      'country' => $cd->country,
      'condition' => $cd->cond,
      'year' => $cd->prod_year,
      'upc' => $cd->upc,
      'category' => $cd->category,
      'description' => $cd->description,
  );
}
?>
<h3>CDs</h3>
<h4>To modify an item, click on the artist entry for the item</br>
  To remove items check the boxes</h4>
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
	<th style="width: 14%"><a href="cds.php?orderField=artist">Artist</a></th>
	<th style="width: 20%"><a href="cds.php?orderField=title">Title</a></th>
	<th style="width: 4%"><a href="cds.php?orderField=discs">Discs</a></th>
	<th style="width: 9%"><a href="cds.php?orderField=country">Country</a></th>
	<th style="width: 7%"><a href="cds.php?orderField=cond">Condition</a></th>                    
	<th style="width: 4%"><a href="cds.php?orderField=prod_year">Year</a></th>
	<th style="width: 10%"><a href="cds.php?orderField=upc">UPC/CAT#</a></th>                             
	<th style="width: 10%"><a href="cds.php?orderField=category">Category</a></th>
	<th style="width: 24%">Description</th>
    <?php foreach ($list as $cd): ?>
	<tr>
		<td><input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($cd['id']) ?>" />     
		<a href="modifyCd.php?id=<?php echo $cd['id'] ?>"><?php echo htmlspecialchars($cd['artist']); ?></a></td>
		<td><?php echo htmlspecialchars($cd['title']); ?></td>
		<td style="text-align: center;"><?php echo htmlspecialchars($cd['discs']); ?></td>
		<td><?php echo htmlspecialchars($cd['country']); ?></td>
		<td><?php echo htmlspecialchars($cd['condition']); ?></td>
		<td style="text-align: center;"><?php echo htmlspecialchars($cd['year']); ?></td>
		<td><?php echo htmlspecialchars($cd['upc']); ?></td>
		<td><?php echo htmlspecialchars($cd['category']); ?></td>
		<td><?php echo htmlspecialchars($cd['description']); ?></td>
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
	<th style="width: 12%"><a href="cds.php?orderField=artist">Artist</a></th>
	<th style="width: 20%"><a href="cds.php?orderField=title">Title</a></th>
	<th style="width: 4%"><a href="cds.php?orderField=discs">Discs</a></th>
	<th style="width: 9%"><a href="cds.php?orderField=country">Country</a></th>
	<th style="width: 7%"><a href="cds.php?orderField=cond">Condition</a></th>                    
	<th style="width: 4%"><a href="cds.php?orderField=prod_year">Year</a></th>
	<th style="width: 10%"><a href="cds.php?orderField=upc">UPC/CAT#</a></th>                             
	<th style="width: 10%"><a href="cds.php?orderField=category">Category</a></th>
	<th style="width: 24%">Description</th>
    <?php foreach ($list as $cd): ?>
	<tr>     
		<td><a href="modifyCd.php?id=<?php echo $cd['id'] ?>"><?php echo htmlspecialchars($cd['artist']); ?></a></td>
		<td><?php echo htmlspecialchars($cd['title']); ?></td>
		<td style="text-align: center;"><?php echo htmlspecialchars($cd['discs']); ?></td>
		<td><?php echo htmlspecialchars($cd['country']); ?></td>
		<td><?php echo htmlspecialchars($cd['condition']); ?></td>
		<td style="text-align: center;"><?php echo htmlspecialchars($cd['year']); ?></td>
		<td><?php echo htmlspecialchars($cd['upc']); ?></td>
		<td><?php echo htmlspecialchars($cd['category']); ?></td>
		<td><?php echo htmlspecialchars($cd['description']); ?></td>
	</tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
</form>