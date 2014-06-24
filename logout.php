<?php

/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: logout.php
 * Date: 05/17/2014
 * PHP version: 5.3
 * Description: Allow user to logout.
 * ToDo:
 */
require_once "include/Session.php";
$session = new Session();
unset($session->user);
header("location: .");
