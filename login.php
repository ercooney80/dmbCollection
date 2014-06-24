<?php
/**
 * @author Edward Cooney <ec789115@wcupa.edu>
 * File: login.php
 * Section: CSC417-80
 * Date: 04/17/2014
 * PHP version: 5.3
 * Description: 
 */
require_once "include/Session.php";
$session = new Session();
if (isset($session->user)) {
  require_once "index.php";
  exit();
}

$message = $session->message;
$username = $session->username;
unset($session->message);
unset($session->username);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>Login</title>

    <link rel="stylesheet" type="text/css" href="css/superfish.css" />
    <link rel="stylesheet" type="text/css" href="css/layout.css" />
    <link rel="stylesheet" type="text/css" href="css/form-layout.css" />
    <style type="text/css">

    </style>  
  </head>
  <body >
  <section class="container">
    <header class="header"><?php require_once "include/header.php" ?></header>
    <section class="navigation"><?php require_once "include/navigation.php" ?></section>
    <section class="content"><!-- content -->

      <h2>Login</h2>

      <p>Please enter access information</p>
      <form action="pwValidation.php" method="post" autocomplete="off">
        <table class="formtable">
          <tr>
            <th>user:</th>
            <td><input type="text" name="username" autofocus="on"
                       value="<?php echo htmlspecialchars($username) ?>" /></td>
          </tr>
          <tr>
            <th>password:</th>
            <td><input type="password" name="password" /></td>
          </tr>
          <tr>
            <td><button type="submit">Access</button></td>
          </tr>
        </table>
      </form>
      <h3 id="response"><?php echo $message ?></h3>

    </section><!-- content -->

  </section><!-- container -->

  <script type="text/javascript" src="js/textlength.js"></script>
  <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="js/superfish.min.js"></script>
  <script type="text/javascript" src="js/init.js"></script>
  <script type="text/javascript">
    /* local JavaScript */
  </script>
  <footer id="footer"><?php require_once 'footer.php'; ?></footer>
</body>
</html>