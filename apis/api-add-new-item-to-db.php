<?php
// ini_set('display_errors',1);
require_once __DIR__.'/../connect.php';
session_start();
$itemName = $_POST['addNewItemName'] ?? '';

// check if item is already on the list
$check = $db->prepare("SELECT * FROM food_items WHERE lower(name) = lower('$itemName')");
$check->execute();
$rows = $check->fetchAll();

if(count($rows)>0){
    $_SESSION['message'] = 'Item is already on the list. Please enter a new name';
    header('location:../profile');
    exit;
}

try{
    $db->beginTransaction();
    // add item to food_items, if it does not exist
    $query1 = $db->prepare('INSERT INTO food_items VALUES(NULL, :itemName)');
    $query1->bindValue(':itemName', "$itemName");
    
    if( $query1->execute() ){
    
        $iItemId = $db->lastInsertId(); //get id for last item inserted
        
        if(!isset($_POST['selectCategory'])){
            $_SESSION['message'] = 'You have to choose a category for the item';
            header('location:../profile');
            exit;
        }

        $sCategoryId = $_POST['selectCategory'] ?? '';
        $query2 = $db->prepare('INSERT INTO food_items_categories VALUES (:iItemId, :sCategoryId)');
        $query2->bindValue(':iItemId', $iItemId);
        $query2->bindValue(':sCategoryId', $sCategoryId);

    }

    if( $query2->execute() ){
        $_SESSION['message'] = "Item has been added. Go ahead and search for it";
        header('location:../profile');
        $db->commit();
    }else{
        echo 'cannot insert item'.__LINE__;
        $db->rollBack();
        exit;
    }

}catch(PDOException $ex){
    $db->rollBack();
    echo $ex;
}

