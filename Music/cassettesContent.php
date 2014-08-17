<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: Music/cassettesContent.php
 * Date: 07/11/2014
 * PHP version: 5.3
 * Description: build the content for the cassette display page
 * ToDo: add JS check for remove item
 *          add asc and desc (php or js?)
 *
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

// Get cassettes from DB
$cassettes = R::findAll('cassette', "1 order by $orderField ASC");
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
<form action="removeItems.php" method="GET">
    <h3>Cassettes</h3>
    <!-- IF SUPER USER DISPLAY REMOVE OPTION AND MESSAGE -->
    <?php if ($superUser): ?>
        <h4>To modify an item, click on the artist entry for the item</br>
            To remove items check the boxes
        </h4>
        <input type="hidden" name="table" value="cassette" />
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
            <th style="width: 12%"><a href='displayTable.php?table=cassettes&type=Music&orderField=artist&sort=.$sort'>Artist</a></th>
            <th style="width: 20%"><a href='displayTable.php?table=cassettes&type=Music&orderField=title&sort=.$sort'>Title</a></th>
            <th style="width: 4%"><a href='displayTable.php?table=cassettes&type=Music&orderField=tapes&sort=.$sort'>Tapes</a></th>
            <th style="width: 9%"><a href='displayTable.php?table=cassettes&type=Music&orderField=country&sort=.$sort'>Country</a></th>
            <th style="width: 7%"><a href='displayTable.php?table=cassettes&type=Music&orderField=cond&sort=.$sort'>Condition</a></th>                    
            <th style="width: 4%"><a href='displayTable.php?table=cassettes&type=Music&orderField=prod_year&sort=.$sort'>Year</a></th>
            <th style="width: 10%"><a href='displayTable.php?table=cassettes&type=Music&orderField=upc&sort=.$sort'>UPC/CAT#</a></th>                             
            <th style="width: 10%"><a href='displayTable.php?table=cassettes&type=Music&orderField=category&sort=.$sort'>Category</a></th>
            <th style="width: 24%">Description</th>
            <?php foreach ($list as $cassette): ?>
        <tr>
            <td><?php if ($superUser): ?>
                    <input type="checkbox" name="ids[]" value="<?php echo htmlspecialchars($cassette['id']) ?>" /><?php endif; ?> 
                                <a href="modifyCassette.php?id=<?php echo $cassette['id'] ?>"><?php echo htmlspecialchars($cassette['artist']); ?></a></td>
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
</form>