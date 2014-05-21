<?php

/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: include/DB.php
 * Date: 05/15/2014
 * PHP version: 5.3
 * Description: DB class 
 * Contains DB functions and other essential table element retrieval functions.
 * ToDo:
 */
require_once "rb.php";

class DB {

  public static function getProps() { // un-comment one of these
    return self::mysqlProps();
    //return self::sqliteProps();
  }

  private static $_initialized = false;

  public static function init() {
    $props = self::getProps();
    if (self::$_initialized) {
      return $props;
    }
    if ($props['db'] == 'mysql') {
      R::setup($props['url'], $props['username'], $props['password']);
    } elseif ($props['db'] == 'sqlite') {
      R::setup($props['url']);
    }
    R::freeze(true);
    self::$_initialized = true;
    return $props;
  }

  private static function mysqlProps() {
    $host = 'localhost';
    $dbname = 'dmbCollection';
    $username = 'guest';
    $password = '';
    $url = "mysql:host=$host;dbname=$dbname";
    return array(
        'db' => 'mysql',
        'dbname' => $dbname,
        'username' => $username,
        'password' => $password,
        'host' => $host,
        'url' => $url,
    );
  }

  private static function sqliteProps() {
    $dbname = __DIR__ . DIRECTORY_SEPARATOR .
            'db' . DIRECTORY_SEPARATOR . 'database.sqlite';
    return array(
        'db' => 'sqlite',
        'dbname' => $dbname,
        'url' => "sqlite:$dbname",
    );
  }

  
    /**
   * Gets the epoch timestamp held in the appropriate table and converts to 
   * user friendly format
   * @param type $id table id
   * @param type $with_time Determines if we need to add time to date
   * @return type Formatted timestamp
   * @throws Exception
   */
  public static function getAddedDate($table, $id, $with_time = false) {
    $item = R::findOne($table, "id=?", array($id));
    if (is_null($item)) {
      throw new Exception("Cannot find date for ($table: $id)");
    }
    $fmt = "M j, Y";
    if ($with_time) {
      $fmt .= " H:i:s";
    }
    return date($fmt, $item->created_at);
  }
  
  public static function getCategories() {
    return array('BONUS DISC', 'DIGITAL', 'LIVE', 'PROMO ALBUM', 'PROMO SINGLE', 
        'PROMO COMPILATION', 'RADIO COMPILATION', 'SINGLE IMPORT', 'SINGLE US', 'STUDIO');
  }
  
  
  public static function getYears() {
    $start = '1990'; // first possible year of material;
    $current = date('Y');
    $years = range($start, $current);
    arsort($years);
    return $years;
  }
}
