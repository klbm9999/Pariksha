<?php

$config = include('config.php');
$password = md5($config['admin_pass']);

session_start();
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
}

if (isset($_POST['password'])) {
    if (md5($_POST['password']) == $password) {
        $_SESSION['loggedIn'] = true;
    } else {
        die ('Incorrect password');
    }
} 

if (!$_SESSION['loggedIn']): 

?>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <p class="p-5 text-center h1">You need to login</p>
            <div class="d-flex justify-content-center">
                <form method="post" class="form-group">
                    <label for="password">Password: </label> 
                    <input type="password" name="password" class="form-control" placeholder="Enter the password"> <br />
                    <input type="submit" class="btn btn-md btn-info" name="submit" value="Login">
                </form>
            </div>
        </div>
    </body>
 </html>

<?php
exit();
endif;
?>