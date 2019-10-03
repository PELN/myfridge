<?php

session_start();


$sUserId = $_SESSION['sUserId'];

require_once __DIR__.'/../connect.php';
$stmt = $db->prepare( "DELETE FROM users WHERE id = :sUserId" );
$stmt->bindValue(':sUserId', $sUserId);
$stmt->execute();

session_destroy();

header('location:../index.php');
