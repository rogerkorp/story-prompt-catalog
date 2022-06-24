<?php 

include_once 'connect.php';

$password = "admin";
$hashed_password = sha1($password);
echo $hashed_password

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Prompt Catalog</title>
        <link rel="stylesheet" href="stylesheet.css">
        <link rel="icon" sizes="any" type="image/svg+xml" href="pen-nib-logo.svg">
    </head>
    <body> 
        <main>
            <form action="login-process.php" class="form-group" method="post">
                <input type="text" name="username" id="username" placeholder="Username" value="">
                <input type="text" name="password" id="password" placeholder="Password" value="">
                <input id="submit" type="submit" name="submit" value="Log In">
            </form>
    
        </main>

    </body>
</html>