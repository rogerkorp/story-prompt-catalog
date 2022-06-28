<?php
include_once 'connect.php';

if (mysqli_connect_errno()) {
    die ("Database connection failed: " .
      mysqli_connect_error() .
      " (" . mysqli_connect_errno() . ")"
    );
  };

if (isset($_POST['account-submit'])){ //Creates a new account into the system
  $username = mysqli_real_escape_string($db_connection, $_POST['username']);
  $password = mysqli_real_escape_string($db_connection, $_POST['password']);
  $hash = password_hash($password, PASSWORD_DEFAULT); //Hashes the users password before entry into the database.
  $query = "INSERT INTO `users` (`username`, `hashed_password`) "; 
  $query .= "VALUES ('{$username}', '{$hash}')";
  echo ($query);

  $db_results = mysqli_query($db_connection, $query);
  if($db_results){
    header ('Location: login.php'); //Redirects user to login page.
  } else {
    echo "Query failed.";
  };
}

//To do:

// 1. Add in a link to the sign-up page.
// 2. Add in a proper error message to the login page (possibly a POST request?)
// 3. Add in errors for blank username and password values.

if (isset($_POST['login-submit'])){
    $username = mysqli_real_escape_string($db_connection, $_POST['username']);
    $password = mysqli_real_escape_string($db_connection, $_POST['password']);
    $query = "SELECT hashed_password FROM `users` WHERE (username = '{$username}')";
    $db_results = mysqli_query($db_connection, $query);

    if ($db_results){
      $row = mysqli_fetch_assoc($db_results);
      $hash = $row['hashed_password'];
      $valid = password_verify($password, $hash);
      if ($valid){
        echo ('password is true');
        if (password_needs_rehash ($hash, PASSWORD_DEFAULT)){
          $newHash = password_hash ($hashed_password, PASSWORD_DEFAULT);
          $newPassQuery = "UPDATE `users` SET `hashed_password` = '{$newHash}' WHERE (username = '{$username}')";
          echo ($newPassQuery);
        }
        $_SESSION['user'] = $username;
        header('Location: index.php');
      } else {
        header('Location: login.php?success=false');
      }
      
    }

};

?>