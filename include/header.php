<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: include/header.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description:  Sitewide Header 
 * ToDo:
 */
require_once "include/Session.php";
$session = new Session();
?>
<img src="images/header.png" />
<?php if (isset($session->user)): ?>
  <div class="welcome">Welcome, <?php echo $session->user->name ?></div>
  <?php
 endif; 
