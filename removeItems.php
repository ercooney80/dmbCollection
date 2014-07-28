<?php

/**
 * @author Edward Cooney <ercooney80@gmail.com>
 * File: removeItems.php
 * Date: 07/22/2014
 * PHP version: 5.3
 * Description: remove any number of items from a list
 * ToDo:  Catch the statement with some appropriate message
 * 
 * WORKING
 */
require_once "include/DB.php";
DB::init();
$params = (object) $_REQUEST;

$ids = $params->ids;        // list of corresponding ids to remove
$type = $params->type;      // content type
$table = $params->table;    // subcontent type


try {
    // Load and trash all content we want to get rid of  
    $beans = R::loadAll($table, $ids);
    R::trashAll($beans);

    // Format fields for URL
    if ($table != 'vinyl' && $table != 'vhs') {
        $table .= 's';
    }
    // Display updated list
    header('location: displayTable.php?table=' . $table . '&type=' . $type);
} catch (Exception $ex) {
    
}

