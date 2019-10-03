<?php

if(isset($_GET['remove'])){
    $rowId = $_GET['remove'];
    require_once __DIR__.'/../connect.php';

    $stmt = $db->prepare( "DELETE FROM users_items WHERE id = :rowId" );
    $stmt->bindValue(':rowId', $rowId);
    $stmt->execute();

    $_SESSION['message'] = "Item has been deleted";

    header('location:../profile');

}

