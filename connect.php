<?php
include 'config.php';

$db_connection = mysqli_connect( //This connects to mySQL database, with the three parameters.
    $db_host,
    $db_user,
    $db_password,
    $db_name
);

if (!$db_connection){
    echo 'No connection to database. Check the connect file.';
};

session_start();

?>