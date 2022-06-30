<?php

include_once 'connect.php';

date_default_timezone_set('EST');

if (mysqli_connect_errno()) {
    die ("Database connection failed: " .
      mysqli_connect_error() .
      " (" . mysqli_connect_errno() . ")"
    );
  }

if (isset($_POST['submit'])){

$prompt = mysqli_real_escape_string($db_connection, $_POST['prompt']);
$tag = mysqli_real_escape_string($db_connection, $_POST['tag']);
$date = date('m-d-Y');

$query = "INSERT INTO `catalog_" . $_SESSION['user'] . "` (`date`, `prompt`, `tag`) "; 
$query .= "VALUES (str_to_date('{$date}', '%m-%d-%Y'), '{$prompt}', '{$tag}')";

echo ($query);

$db_results = mysqli_query($db_connection, $query);
if($db_results){
    header ('Location: index.php');
} else {
    echo "Query failed.";
};
};
?>