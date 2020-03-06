<?php
    require_once '../load.php';

    // $_UPPERCASE means this is a built in PHP variable
    // php.net has a manual that explains these variables
    // $word is a variable made by us
    $ip = $_SERVER['REMOTE_ADDR']; //REMOTE_ADDR uses the IP address from the user

    if(isset($_POST['submit'])){
        // trim cuts off extra space
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // if any are empty, instead of logging the user in, send a message
        if(!empty($username) && !empty($password)){
            // log user in
            $message = login($username, $password, $ip);
        }else{
            $message = 'Please fill out the required fields';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
</head>
<body>
    <h2>Login Page</h2>
    <?php echo !empty($message)? $message: ''; ?>
    <form action="admin_login.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" value="">

        <button name="submit">Submit</button>
    </form>


</body>
</html>