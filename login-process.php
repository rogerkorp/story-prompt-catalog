<?php
include_once 'connect.php';

$valid_name = false;

if (mysqli_connect_errno()) {
    die ("Database connection failed: " .
      mysqli_connect_error() .
      " (" . mysqli_connect_errno() . ")"
    );
  };

if (isset($_POST['account-submit'])){ //Creates a new account into the system
  $username = mysqli_real_escape_string($db_connection, $_POST['username']);

  if ($username){
    $user_query = "SELECT id FROM users WHERE "; 
    $user_query .= "username = '{$username}'";
    $user_results = mysqli_query($db_connection, $user_query);
    $total_count = $user_results->num_rows;
    $total_row_count = $total_count;

    if(($total_row_count) == 0){
      $valid_name = true;
    } else {
      $valid_name = false;
    };

    if ($valid_name == true){
      $password = mysqli_real_escape_string($db_connection, $_POST['password']);
      $confirm_password = mysqli_real_escape_string($db_connection, $_POST['confirm-password']);
      
      if ($password == $confirm_password){
        $hash = password_hash($password, PASSWORD_DEFAULT); //Hashes the users password before entry into the database.
        $query = "INSERT INTO `users` (`username`, `hashed_password`) "; 
        $query .= "VALUES ('{$username}', '{$hash}')";
        $db_results = mysqli_query($db_connection, $query);
        if($db_results){

            $new_user_query = "CREATE TABLE `prompt_catalog`.`catalog_" .  $username . "` (`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Number', `date` date NOT NULL COMMENT 'Date of entry creation.', `prompt` longtext NOT NULL COMMENT 'The full prompt (max. 100 characters)', `tag` varchar(20) NOT NULL COMMENT 'A short word that described the prompt', PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
            $new_user_results = mysqli_query($db_connection, $new_user_query);
            if($new_user_results){
              header ('Location: login.php'); 
              end;
            } else {
              echo "User Results Query Failed.";
            }
            //Redirects user to login page.
        } else {
            echo "Query failed.";
        };
  
      } else {
        header ('Location: create-account.php?passcheck=false'); 
      };

    } else if ($valid_name == false){
      header ('Location: create-account.php?usercheck=false');
    };

  } else {
    header ('Location: create-account.php?usercheck=false');
  };
/* 
  $password = mysqli_real_escape_string($db_connection, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($db_connection, $_POST['confirm-password']);

  if ($valid_name == true){
    if ($password == $confirm_password){
      $hash = password_hash($password, PASSWORD_DEFAULT); //Hashes the users password before entry into the database.
      $query = "INSERT INTO `users` (`username`, `hashed_password`) "; 
      $query .= "VALUES ('{$username}', '{$hash}')";
      $db_results = mysqli_query($db_connection, $query);
      if($db_results){
          header ('Location: login.php'); 
          end;//Redirects user to login page.
      } else {
          echo "Query failed.";
      };

    } else {
      header ('Location: create-account.php?passcheck=false'); 
      end;
    };
  }; */


};




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