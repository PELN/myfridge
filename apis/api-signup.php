<?php
// ini_set('display_errors', 1);
session_start();

if (isset($_POST['submitSignup'])){
    require_once __DIR__.'/../connect.php';

    $sEmail = $_POST['signupEmail'] ?? '';
    $sUsername = $_POST['signupUsername'] ?? '';
    $sPassword = $_POST['signupPassword'] ?? '';
    $sConfirmPassword = $_POST['signupConfirmPassword'] ?? '';

    if(!filter_var($sEmail, FILTER_VALIDATE_EMAIL)){
        $_SESSION['signupMessage'] = "email is not valid";
        header('location:../index.php');
        exit;
    }

    if(empty($sEmail) || empty($sUsername) || empty($sPassword) || empty($sConfirmPassword) ){
        $_SESSION['signupMessage'] = "fields cant be empty";
        header('location:../index.php');
        exit;
    }

    if( $sPassword != $sConfirmPassword ){
        $_SESSION['signupMessage'] = "passwords does not match";
        header('location:../index.php');
        exit;
    }

    try{
        // ********** check if username is already in db, send error msg ************
        $stmt = $db->prepare(" SELECT * FROM users WHERE username = :username ");
        $stmt->bindValue(':username',"$sUsername");
        $stmt->execute();

        $aRows = $stmt->fetchAll();
        // if rows returned are more than 0, then we know the username already exist
        if( count($aRows) > 0 ){
            foreach($aRows as $aRow){
                $_SESSION['signupMessage'] = "sorry username taken";
                header('location:../index.php');
                exit;
            }
        }
       
        // ********** check if email is already in db, send error msg ************
        $stmt = $db->prepare(" SELECT * FROM users WHERE email = :email ");
        $stmt->bindValue(':email',"$sEmail");
        $stmt->execute();

        $aRows = $stmt->fetchAll();
        // if rows returned are more than 0, then we know the email already exist
        if( count($aRows) > 0 ){
            foreach($aRows as $aRow){
                $_SESSION['signupMessage'] = "sorry email taken";
                header('location:../index.php');
                exit;
            }
        }
      
        
        else{
            // else user does not exist -> hash password and insert user into db
            $sHashedPassword = password_hash($sPassword, PASSWORD_DEFAULT);

            $stmt = $db->prepare( 'INSERT INTO users VALUES(null, :sEmail, :sUsername, :sPassword)' );
            $stmt->bindValue(':sEmail', $sEmail);
            $stmt->bindValue(':sUsername', $sUsername);
            $stmt->bindValue(':sPassword', $sHashedPassword);

            $stmt->execute();

            $_SESSION['signupMessage'] = "you have signed up, go ahead and login";
            header('location:../index.php');
            exit;
        
        }
    }

    catch( PDOEXception $ex){
        echo $ex;
    }

}
