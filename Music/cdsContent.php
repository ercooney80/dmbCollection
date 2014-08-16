<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: Music/cdsContent.php
 * Date: 07/11/2014
 * PHP version: 5.3
 * Description: build the content for the cd display page
 * ToDo: add JS check for remove item
 *          add asc and desc (php or js?)
 */
require_once "include/Session.php";
$session = new Session();             // for ease of use - consolidate all needed session functionality
require_once "include/DB.php";
$props = DB::init();                  // for ease of use - consolidate all needed DB functionality
$params = (object) $_REQUEST;         // for ease of use - consolidate get, post, cookie     
// set order field
$orderField = "title";

if (isset($params->orderField)) {
    $orderField = $params->orderField;
}

if (isset($session->user)) {
    $loggedIn = TRUE;
    $superUser = $session->user->level > 0;
}

// Gets CDs from DB
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
<form action="removeItems.php" method="GET">
    <h3>CDs</h3>
<!-- IF SUPER USER DISPLAY REMOVE OPTION AND MESSAGE -->
    <?php if ($superUser): ?>    
        <h4>To modify an item, click on the artist entry for the item</br>
            To remove items check the boxes
        </h4>
        <input type="hidden" name="table" value="cd" />
        <input type="hidden" name="type" value="music" />
        <table class="changer">
            <td><button class="button" type="submit" name="remove">Remove Items</button></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </table>
    <?php endif; ?>
        <table>
            <th style="width: 12%"><a href='displayTable.php?table=cds&type=Music&orderField=artist&sort=.$sort'>Artist</a></th>
            <th style="width: 19%"><a href='displayTable.php?table=cds&type=Music&orderField=title&sort=.$sort'>Title</a></th>
            <th style="width: 6%"><a href='displayTable.php?table=cds&type=Music&orderField=discs&sort=.$sort'>Discs</a></th>
            <th style="width: 8%"><a href='displayTable.php?table=cds&type=Music&orderField=country&sort=.$sort'>Country</a></th>
            <th style="width: 7%"><a href='displayTable.php?table=cds&type=Music&orderField=cond&sort=.$sort'>Condition</a></th>                    
            <th style="width: 4%"><a href='displayTable.php?table=cds&type=Music&orderField=prod_year&sort=.$sort'>Year</a></th>
            <th style="width: 10%"><a href='displayTable.php?table=cds&type=Music&orderField=upc&sort=.$sort'>UPC/CAT#</a></th>                             
            <th style="width: 10%"><a href='displayTable.php?table=cds&type=Music&orderField=category&sort=.$sort'>Category</a></th>
            <th style="width: 24%">Description</th>
            <?php foreach ($list as $cd): ?>
                <tr>
                    <td><?php if ($superUser): ?>
                        <input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($cd['id']) ?>" /><?php endif; ?>      
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
</form>