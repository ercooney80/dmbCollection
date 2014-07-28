<?php
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

$session->clicked = false;

if (isset($params->sort)) {
    if ($params->sort == 'ASC') {
        $sort = 'DESC';
    } else {
        $sort = 'ASC';
    }
}


// Get cassettes from DB
$cassettes = R::findAll('cassette', "1 order by $orderField $direction");
unset($session->clicked);
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
    <?php if ($superUser): //  ?>
        <h3>Cassettes</h3>
        <h4>To modify an item, click on the artist entry for the item</br>
            To remove items check the boxes
        </h4>
        <input type="hidden" name="table" value="cd" />
        <table class="changer">
            <td><button class="button" type="submit" name="remove">Remove Items</button></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </table>
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
            <th style="width: 12%"><a href="displayTable.php?table=cassettes&type=Music&orderField=artist">Artist</a></th>
            <th style="width: 19%"><a href="displayTable.php?table=cassettes&type=Music&orderField=title">Title</a></th>
            <th style="width: 6%"><a href="displayTable.php?table=cassettes&type=Music&orderField=tapes">Tapes</a></th>
            <th style="width: 8%"><a href="displayTable.php?table=cassettes&type=Music&orderField=country">Country</a></th>
            <th style="width: 7%"><a href="displayTable.php?table=cassettes&type=Music&orderField=cond">Condition</a></th>                    
            <th style="width: 4%"><a href="displayTable.php?table=cassettes&type=Music&orderField=prod_year">Year</a></th>
            <th style="width: 10%"><a href="displayTable.php?table=cassettes&type=Music&orderField=upc">UPC/CAT#</a></th>                             
            <th style="width: 10%"><a href="displayTable.php?table=cassettes&type=Music&orderField=category">Category</a></th>
            <th style="width: 24%">Description</th>
            <?php foreach ($list as $cassette): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cassette['artist']); ?></td>
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




$field='game_ID';
$sort='ASC';
if(isset($_GET['sorting']))
{
if($_GET['sorting']=='ASC')
{
$sort='DESC';
}
else
{
$sort='ASC';
}
}
if($_GET['field']=='game_ID')
{
$field = "game_ID"; 
}
elseif($_GET['field']=='category_Name')
{
$field = "category_Name";
}
elseif($_GET['field']=='game_Title')
{
$field="game_Title";
}
$sql = "SELECT game_ID, category_Name, game_Title FROM yobash_game ORDER BY $field $sort";
$result = mysql_query($sql) or die(mysql_error());
echo'<table border="1">';
    echo'<th><a href="table1.php?sorting='.$sort.'&field=game_ID">Game Id</a></th>
    <th><a href="table1.php?sorting='.$sort.'&field=category_Name">Category Name</a></th>
    <th><a href="table1.php?sorting='.$sort.'&field=game_Title">Game Name</a></th>';
    while($row = mysql_fetch_array($result))
    {
    echo'<tr><td>'.$row['game_Id'].'</td><td>'.$row['category_Name'].'</td><td>'.$row['game_Title'].'</td></tr>';
    }
    echo'</table>';
?>
