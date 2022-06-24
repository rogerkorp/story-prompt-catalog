<?php
include_once 'connect.php';

if (mysqli_connect_errno()) {
    die ("Database connection failed: " .
      mysqli_connect_error() .
      " (" . mysqli_connect_errno() . ")"
    );
  }

if (isset($_POST['submit'])){

    $username = mysqli_real_escape_string($db_connection, $_POST['username']);
    $raw_password = mysqli_real_escape_string($db_connection, $_POST['password']);
    $password = sha1($raw_password);

    $query = "SELECT * FROM `users` WHERE";
    $query .= " username = '{$username}'";
    $query .= " AND password = '{$password}'";
    $query .= " LIMIT 1";

    $db_results = mysqli_query($db_connection, $query);

    if($db_results){
        header ('Location: index.php');
    } else {
        echo $username;
        echo $password;
        die('Query found no results');
    };

};

?>