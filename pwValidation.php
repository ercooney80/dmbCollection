<?php

/**
 * @author Dr. Robert Kline <rkline@wcupa.edu>
 * @author Edward Cooney <ec789115@wcupa.edu>
 * File: validate.php
 * Section: CSC417-80
 * Date: 04/17/2014
 * PHP version: 5.3
 * Description: Validates username and password for login.  Sends user to 
 * appropriate page based on whether user selected login link or was redirected.
 */
require_once "include/Session.php";
$session = new Session();

require_once "include/DB.php";
DB::init();

$params = (object) $_REQUEST;

$username = trim($params->username);
if (isset($session->redirect)) {
  $redirect = $session->redirect;
} else {
  $redirect = ".";
}

$user = R::findOne("user", "name=?", array($username));

if (!isset($user)) {
  $session->message = "Failed (username)";
  header("location: login.php");
} elseif (sha1($params->password) === $user->password) {  // correct
  $session->user = (object) $user->getProperties();
  // don't carry these fields in session
  unset($session->user->email);
  unset($session->user->password);
  unset($session->redirect);
  unset($session->login_msg);
  header("location: $redirect");
} else {
  $session->username = $params->username;
  $session->message = "Failed (password)";
  header("location: login.php");
}
