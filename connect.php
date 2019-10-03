<?php

try{
  $sUserName = 'root';
  $sPassword = 'root';
  $sConnection = "mysql:host=localhost; dbname=myfridge; charset=utf8mb4";


  $aOptions = array(
    // if you want to use try-catch, then you can't use the if statements, because the errmode exception is on, and goes straight to catch
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    // FETCH_OBJ instead of FETCH_ASSOC(iative array) - data returned as objects (access properties with arrows instead of square brackets)
    // fx $users['email'];
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

  );

  $db = new PDO( $sConnection, $sUserName, $sPassword, $aOptions );
}catch( PDOException $e){
  echo $e;
  // echo '{"status":0,"message":"cannot connect to database"}';
  exit();
}












