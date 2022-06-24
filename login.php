<?php 

include_once 'connect.php';

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
    <body id="login-body"> 
        <main>
            <form action="login-process.php" class="login-form" method="post">
                <input class="login-textbox" type="text" name="username" id="username" placeholder="Enter your username" value="">
                <input class="login-textbox" type="text" name="password" id="password" placeholder="Enter your password" value="">
                <input class="login-submit" id="submit" type="submit" name="submit" value="LOG IN">
            </form>
    
        </main>

    </body>
</html>