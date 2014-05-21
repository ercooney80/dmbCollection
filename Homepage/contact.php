<?php
/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: Homepage/contact.php
 * Date: 05/16/2014
 * PHP version: 5.3
 * Description: The form for processing user information to contact the site owner
 * ToDo: setup mail server.  Form is functional but cannot connect to server
 * REMOVE THE RESTRAINER VARIABLE TO MAKE FUNCTIONAL
 */
require_once "include/Session.php";
$session = new Session();

$params = (object) $_REQUEST;
$restrainer = FALSE;
if (isset($params->emailbutton) && $restrainer) {
  try {
    $name = $params->name;
    $email = $params->email;
    $message = $params->message;

    if (($name == "") || ($email == "") || ($message == "")) {
      if ($name == "") {
        $empty = "name";
      }
      if ($email == "") {
        $empty = "email";
      }
      if ($message == "") {
        $empty = "message";
      }
      throw new Exception("All fields are required + $empty");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Check your email address");
    }

    $from = "From: $name<$email>\r\nReturn-path: $email";
    $subject = "Message sent using your contact form -- DMBCOLLECTION";
    mail("brinks56@yahoo.com", $subject, $message, $from);
    $warning = "Email Sent";
  } catch (Exception $ex) {
    $warning = $ex->getMessage();
  }
} else {
  $params->name = '';
  $params->email = '';
  $params->message = '';
  $warning = '';
}
?>

<form  action="" method="POST" enctype="multipart/form-data">
  <h3>Contact Me</h3>
  <h4><b><?php echo $warning ?></b><h4>
      <h5>Name:</h5>
      <input name="name" type="text" value="<?php echo htmlspecialchars($params->name) ?>"/>
      <h5>Email:</h5>
      <input name="email" type="text" value="<?php echo htmlspecialchars($params->email) ?>"/>
      <h5>Message:</h5>
      <textarea name="message" rows="7" cols="30" maxlength="300"><?php
        echo htmlspecialchars($params->message)
        ?></textarea>
      <td class="button"><button type="submit" name="emailbutton">Send Message</button></td>  
      </form>