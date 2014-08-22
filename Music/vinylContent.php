<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: Music/vinylContent.php
 * Date: 07/12/2014
 * PHP version: 5.3
 * Description: build the content for the vinyl display page
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

// Get Vinyl from DB
$vinyls = R::findAll('vinyl', "1 order by $orderField asc");
// Build the vinyl display array
foreach ($vinyls as $vinyl) {
    $list[] = array(
        'id' => $vinyl->id,
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
<form action="removeItems.php" method="GET">
    <h3>Vinyl</h3>
    <!-- IF SUPER USER DISPLAY REMOVE OPTION AND MESSAGE -->
    <?php if ($superUser): ?>    
        <h4>To modify an item, click on the artist entry for the item</br>
            To remove items check the boxes
        </h4>
        <input type="hidden" name="table" value="vinyl" />
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
        <th style="width: 8%"><a href="displayTable.php?table=vinyl&type=Music&orderField=artist&sort=.$sort">Artist</a></th>
        <th style="width: 20%"><a href="displayTable.php?table=vinyl&type=Music&orderField=title&sort=.$sort">Title</a></th>
        <th style="width: 6%"><a href="displayTable.php?table=vinyl&type=Music&orderField=records&sort=.$sort">Records</a></th>
        <th style="width: 9%"><a href="displayTable.php?table=vinyl&type=Music&orderField=country&sort=.$sort">Country</a></th>
        <th style="width: 7%"><a href="displayTable.php?table=vinyl&type=Music&orderField=cond&sort=.$sort">Condition</a></th>                    
        <th style="width: 4%"><a href="displayTable.php?table=vinyl&type=Music&orderField=prod_year&sort=.$sort">Year</a></th>
        <th style="width: 9%"><a href="displayTable.php?table=vinyl&type=Music&orderField=upc&sort=.$sort">UPC/CAT#</a></th>                             
        <th style="width: 7%"><a href="displayTable.php?table=vinyl&type=Music&orderField=category&sort=.$sort">Category</a></th>
        <th style="width: 10%"><a href="displayTable.php?table=vinyl&type=Music&orderField=vinyl_size&sort=.$sort">Vinyl Size</a></th>
        <th style="width: 19%">Description</th>

        <?php foreach ($list as $vinyl): ?>
            <tr>
                <td><?php if ($superUser): ?>
                        <input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($vinyl['id']) ?>" />     
                    <a href="modifyVinyl.php?id=<?php echo $vinyl['id'] ?>"><?php echo htmlspecialchars($vinyl['artist']); ?></a>
                    <?php else: ?>
                    <?php echo htmlspecialchars($vinyl['artist']); ?>
                </td><?php endif; ?>
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
     <?php if ($superUser): ?>
    <table class="changer">
        <td><button class="button" type="submit" name="remove">Remove Items</button></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </table>
        <?php        endif; ?>
</form>
