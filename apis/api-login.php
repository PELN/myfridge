<?php

if (isset($_POST['submitLogin'])){
    require_once __DIR__.'/../connect.php';

    $sUsername = $_POST['loginUsername'] ?? '';
    $sPassword = $_POST['loginPassword'] ?? '';

    if( empty($sUsername) || empty($sPassword) ){
        $_SESSION['loginMessage'] = "Fields cant be empty";
        header('location:../index.php');
        exit;
    }

    try{
        // Check if username is in db
        $stmt = $db->prepare(" SELECT * FROM users WHERE username = :username ");
        $stmt->bindValue(':username', "$sUsername");
        $stmt->execute();

        $aRows = $stmt->fetchAll();
        
        if( count($aRows) > 0 ){
            foreach($aRows as $aRow){
                // echo json_encode($aRow);
                if(password_verify($sPassword, $aRow->password)){
                    session_start();
                    // set user session data
                    $_SESSION['sUserId'] = $aRow->id;
                    $_SESSION['sUser'] = $aRow->username;
                    $_SESSION['sPassword'] = $aRow->password;
                    $_SESSION['sEmail'] = $aRow->email;
    
                    $_SESSION['loginMessage'] = "Logged in as $sUsername";
                    header('location:../profile.php');
                    exit;
                }
            }
        }
        // user does not exist - or wrong password/username
        $_SESSION['loginMessage'] = "Wrong username or password";
        header('location:../index.php');
        exit;
    }
    
    catch( PDOEXception $ex){
        echo $ex;
    }
}
