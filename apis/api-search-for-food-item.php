<?php
require_once __DIR__.'/../connect.php';
session_start();

if (isset($_GET['txtSearch'])) {
    $sName = $_GET['txtSearch'];
    
    try {
        $stmt = $db->prepare('SELECT * FROM food_items WHERE name LIKE :sName LIMIT 20');
        $stmt->bindValue(':sName', "%$sName%"); //sanitizing - secure
        $stmt->execute();
        $aRows = $stmt->fetchAll();
    
        if( count($aRows) == 0 ){
            echo "Sorry, no items with that name <button id=\"addOwnItem\" class=\"tableBtn\">Add your own</button>";
            exit;
        }
        
        foreach($aRows as $aRow){
            echo "<a class=\"itemLink\" href=\"?txtSearch=$aRow->name&iItemId=$aRow->id\"><div>$aRow->name</div></a>\n"; //FETCH_OBJ
        }

    }
    catch( PDOEXception $ex){
        echo $ex;
    }
}

