<?php

chdir(__DIR__);

require_once "../include/DB.php";

$config = DB::getProps();

echo "\nsetup/init.php -- url: {$config['url']}\n\n";

if ($config['db'] == 'mysql') {
    $dbname = $config['dbname'];
    $password = $config['password'];
    $username = $config['username'];
    $password_entry = "";
    if (!empty($password)) {
        $password_entry = "-p'$password'";
    }
    $scripts = array(
        "mysql $password_entry -u $username $dbname < cassette-mysql.sql",
        "mysql $password_entry -u $username $dbname < cd-mysql.sql",
        "mysql $password_entry -u $username $dbname < dvd-mysql.sql",
        "mysql $password_entry -u $username $dbname < vinyl-mysql.sql",
        "mysql $password_entry -u $username $dbname < user-mysql.sql",
    );
} elseif ($config['db'] == 'sqlite') {
    $dbname = $config['dbname'];
    $scripts = array(
        "sqlite3 $dbname < cassette-sqlite.sql",
        "sqlite3 $dbname < cd-sqlite.sql",
        "sqlite3 $dbname < dvd-sqlite.sql",
        "sqlite3 $dbname < vinyl-sqlite.sql",
        "sqlite3 $dbname < user-sqlite.sql",
    );
}

foreach ($scripts as $shell_script) {
    echo "running: $shell_script: ";
    $stat = system($shell_script);
    if ($stat == 0) {
        echo "OK\n";
    } else {
        echo "Failed\n";
    }
}
