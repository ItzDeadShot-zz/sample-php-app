<?php

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */

require "config.php";

$connection = new mysqli($host, $username, $password, $dbname);

if ($connection->connect_errno) {
    echo ("Connection Error" . $connection->connect_errno);
} else {
    $sql = file_get_contents("data/init.sql");
    $connection->exec($sql);
    echo "Database and table users created successfully.";
    $connection->close();
}
