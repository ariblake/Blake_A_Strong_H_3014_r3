<?php

function login($username, $password, $ip){

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

            



            // $check_new_query = 'SELECT user_isNew FROM tbl_user WHERE user_id = :id';
            // $user_new = $pdo->prepare($check_new_query);
            // $user_new->execute(
            //     array(
            //         ':id'=>$id
            //     )
            // );
            // $results = $pdo->query($check_new_query);
            // echo $results;

            // if($check_new_query == "1"){
            //     // first time user is logging in = go to edit user page
            //     //redirect_to('admin_edituser.php');
            //     echo "user is new";
            //     // set user_isNew to 0 because they are no longer new

            // } else {
            //     // the user is not new, load dashboard page
            //     //redirect_to('index.php');
            //     echo "user is not new";
            // }
        }

        if(isset($id)){
            // get current date and time 
            $currentDate = date("Y-m-d H:i:s");

            if ($currentDate >= ['user_timeout']){
                $message = 'account has been timed out';
            } else {
                redirect_to('index.php');
            }
            
            // $pdo = Database::getInstance()->getConnection();
            // $check_new_query = 'SELECT user_isNew FROM tbl_user WHERE user_id = :id';
            // $user_new = $pdo->prepare($check_new_query);
            // $user_new->execute(
            //     array(
            //         ':id'=>$id
            //     )
            // );

            // if($isNew == '1'){
            //     // first time user is logging in = go to edit user page
            //     //redirect_to('admin_edituser.php');
            //     echo "user is new";
            //     // set user_isNew to 0 because they are no longer new

            // } else {
            //     // the user is not new, load dashboard page
            //     //redirect_to('index.php');
            //     echo "user is not new";
            // }
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