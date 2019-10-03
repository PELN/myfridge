<?php
ini_set('display_errors',1);
require_once __DIR__.'/../connect.php';
session_start();


try{

    $sUserId = $_SESSION['sUserId'];
    $iItemId = $_POST['itemId'];
    $expiry_day = $_POST['expiry_day'];
    $iItemStatus = 1;
    $sItemNotes = $_POST['itemNotes'];
    
    $query1 = $db->prepare('INSERT INTO users_items VALUES (NULL, :sUserId, :iItemId, :expiry_day, :iItemStatus)');
    $query1->bindValue(':sUserId', $sUserId);
    $query1->bindValue(':iItemId', $iItemId);
    $query1->bindValue(':expiry_day', $expiry_day);
    $query1->bindValue(':iItemStatus', $iItemStatus);
    $query1->execute();

    
    $iUserItemId = $db->lastInsertId(); //get id for last item inserted
    $query2 = $db->prepare('INSERT INTO user_item_notes VALUES (null, :iUserItemId, :itemNote)');
    $query2->bindValue(':iUserItemId', $iUserItemId);
    $query2->bindValue(':itemNote', $sItemNotes);
    $query2->execute();

    $_SESSION['message'] = "Item was added to your list";
    
    header('location:../profile.php');


}catch(PDOException $ex){
    echo $ex;
}


