<?php
/**
 * @author Edward Cooney <ec789115@wcupa.edu>
 * File: include/links.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description: Create the links dsplay based on whether a user is logged in.
 * Logged in superuser has the ability to add/remove/edit items.
 */
require_once "include/Session.php";
$session = new Session();

// compute status settings
$loggedIn = FALSE;
$superUser = FALSE;
if (isset($session->user)) {
    $loggedIn = TRUE;
    $superUser = $session->user->level > 0;
}
?>
<li><a href=".">Home</a></li> 
<li><a href="#">Music</a>
    <ul>
        <li><a href="displayTable.php?table=cds&type=Music">CDs</a></li>
        <li><a href="displayTable.php?table=cassettes&type=Music">Cassettes</a></li>
        <li><a href="displayTable.php?table=vinyl&type=Music">Vinyl</a></li>
    </ul>
</li>
<li><a href="#">Video</a>
    <ul>
        <li><a href="displayTable?type=dvd.php">DVDs</a></li>
        <li><a href="displayTable?type=vhs.php">VHS</a></li>
    </ul>
</li>
<?php if ($superUser): ?>  
    <li><a href="#">Add Item</a>
        <ul>
            <li><a href="#">Music</a>
                <ul>
                    <li><a href="addCd.php">Add CD</a></li>
                    <li><a href="addCassette.php">Add Cassette</a></li>
                    <li><a href="addVinyl.php">Add Vinyl</a></li>
                </ul>
            </li>
            <li><a href="#">Video</a>
                <ul>
                    <li><a href="addDVD.php">Add DVD</a></li>
                    <li><a href="addVHS.php">Add VHS</a></li>
                </ul>
            </li>
        </ul>
    </li>

<?php endif ?> 
<li> 
    <?php if (!$loggedIn): ?>
        <a href="login.php">Login</a>
    <?php else: ?>
        <a href="logout.php">Logout</a>
    <?php endif ?>
</li>