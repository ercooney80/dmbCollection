<?php

/**
 * @author Robert Kline <kline@wcupa.edu>
 * File: include/Session.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description: Session class.  Provides easier access to and creation of 
 * session variables
 * ToDo:
 */
session_start();  // start session

define("SECRET", "-set-this-to-make-sessions-secure-");
define("HASH", md5(__DIR__ . SECRET));
define("KEY", "sess_" . HASH);

class Session {

    public function __set($name, $value) {
        $_SESSION[KEY][$name] = $value;
    }

    public function & __get($name) {
        return $_SESSION[KEY][$name];
    }

    public function __toString() {
        return isset($_SESSION[KEY]) ? print_r($_SESSION[KEY], true) : "null";
    }

    public function __isset($name) {
        return isset($_SESSION[KEY][$name]);
    }

    public function __unset($name) {
        unset($_SESSION[KEY][$name]);
    }

    public function unsetAll() {
        unset($_SESSION[KEY]);
    }

}
