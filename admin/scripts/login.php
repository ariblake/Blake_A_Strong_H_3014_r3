<?php

function login($username, $password, $ip){
    // debug
    // sprintf lets us use placeholders that fill in with the value at the end
    // $message = sprintf('You are trying to log in with username %s and password %s', $username, $password);

    $pdo = Database::getInstance()->getConnection();
    //Check existance
    $check_exist_query = 'SELECT COUNT(*) FROM tbl_user WHERE user_name= :username'; //:username is a placeholder for preventing SQL injection
    $user_set = $pdo->prepare($check_exist_query);
    $user_set->execute(
        array(
            ':username' => $username,
        )
    );

    if($user_set->fetchColumn()>0){
        //User exists
        //$message = 'User Exists!';

        // check in my user table if there is a row that matches username and password
        $get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username';
        $get_user_query .= ' AND user_pass = :password';
        $user_check = $pdo->prepare($get_user_query);
        $user_check->execute(
            array(
                ':username'=>$username,
                ':password'=>$password
            )
        );
        
        // if the username and password are right, log in
        while($found_user = $user_check->fetch(PDO::FETCH_ASSOC)){
            $id = $found_user['user_id'];
            // Logged in!
            $message = 'You just logged in!';
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $found_user['user_fname'];

            // TODO: finish the following lines so that when user logs in the user_ip column gets updated by the ip
            $update_query = 'UPDATE tbl_user SET user_ip = :ip WHERE user_id = :id';
            $update_set = $pdo->prepare($update_query);
            $update_set->execute(
                array(
                    ':ip'=>$ip,
                    ':id'=>$id
                )
            );
        }

        if(isset($id)){
            redirect_to('index.php');
        }

    }else{
        //User does not exist
        $message = 'User does not exist';
    }

    //Log user in

    return $message;
}

//function to check the user's session
function confirm_logged_in(){
    if(!isset($_SESSION['user_id'])){
        redirect_to('admin_login.php');
    }
}

function logout(){
    session_destroy();
    redirect_to('admin_login.php');
}