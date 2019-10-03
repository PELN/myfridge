<?php
// ini_set('display_errors',1);
require_once __DIR__.'/../connect.php';
session_start();

try{
    $sUserId = $_SESSION['sUserId'];
    $rowId = $_POST['rowId'] ?? '';
    $expiry_day = $_POST['editExpiryDay'] ?? '';
    $sItemNotes = $_POST['editItemNotes'] ?? '';
    $selectedItemId = $_POST['selectName'] ?? '';

    
    if($_POST['selectName']){
        //if not empty, (something is chosen) update to that item id
        $stmt = $db->prepare("UPDATE users_items SET users_items.item_fk = :selectedItemId WHERE users_items.id = :rowId");
        $stmt->bindValue(':selectedItemId', $selectedItemId);
        $stmt->bindValue(':rowId', $rowId);
        $stmt->execute();
    }

    if($_POST['editExpiryDay']){
        //if date is updated, update users_items expiry_day
        $stmt = $db->prepare("UPDATE users_items SET users_items.expiry_day = :expiryDate WHERE users_items.id = :rowId");
        $stmt->bindValue(':expiryDate', "$expiry_day");
        $stmt->bindValue(':rowId', $rowId);
        $stmt->execute();
    }

    if($_POST['editItemNotes']){
        //if note is updated, update user_item_notes
        $stmt = $db->prepare("UPDATE user_item_notes SET user_item_notes.note = :itemNotes WHERE user_item_fk = :rowId");
        $stmt->bindValue(':itemNotes', "$sItemNotes");
        $stmt->bindValue(':rowId', $rowId);
        $stmt->execute();
    }

    header('location:../profile.php');

}catch(PDOexception $ex){
    echo $ex;
}

