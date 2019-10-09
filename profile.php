<?php
session_start();
if(!isset($_SESSION['sUserId']))
{   //not logged in
    header('Location: index.php');
    exit();
}
$sLinkToCss = '<link rel="stylesheet" href="css/profile.css">';
require_once 'top.php';
$sUserId = $_SESSION['sUserId'];
$sUser = $_SESSION['sUser'];
$sEmail = $_SESSION['sEmail'];
?>

<div id="fridge" class="page">
    <div id="fridgeContainer">
        <h1>MY FRIDGE</h1>

        <div id="listContainer">
            <table id="listOfItems" rules=rows class="table-hover table-striped table-condensed">

            <?php
                require_once __DIR__.'/connect.php';
                $stmt = $db->prepare(  'SELECT food_items.name, users_items.expiry_day, user_item_notes.note, users_items.id
                                        FROM users
                                        INNER JOIN users_items ON users.id = user_fk
                                        INNER JOIN food_items ON food_items.id = item_fk
                                        INNER JOIN user_item_notes ON users_items.id = user_item_fk
                                        WHERE users.id = '.$sUserId.'
                                        ' );
                $stmt->execute();
                $aRows = $stmt->fetchAll();
            
                // get current time in unix time (seconds elapsed since UTC)
                $todayTime = time();

                if( count($aRows) > 0 ){
                    foreach($aRows as $aRow){
                        //convert database TIMESTAMP to unix timestamp - to calculate the difference in seconds (time, not date)
                        $expTime = strtotime($aRow->expiry_day);
                        
                        //if the current time has passed the expTime, show days ago
                        if($todayTime > $expTime){

                            $timeDifference = $expTime-$todayTime;
                            // calculate from seconds to days (60 seconds, 60 minutes, 24 hours)
                            // ceil = round number up, no decimals
                            // abs = absolute value of result
                            $daysLeft = abs(ceil($timeDifference / 60 / 60 / 24));

                            if($daysLeft == 0){
                                $expiryMessage = "expires today";
                            }else{
                                $expiryMessage = "expired $daysLeft days ago";
                            }
                            // current time has not passed expTime, show days left
                        }else{
                            $timeDifference = $expTime-$todayTime;
                            $daysLeft = ceil(abs($timeDifference) / 60 / 60 / 24 );
                            $expiryMessage = "expires in $daysLeft days";
                        }

                        echo '<tbody>
                                <tr>
                                    <td>'.$aRow->name.'</td>
                                    <td>'.$expiryMessage.'</td>
                                    <td>'.$aRow->note.'</td>
                                    <td>
                                        <a href="apis/api-remove-item.php?remove='.$aRow->id.'" class="tableBtn">REMOVE</a>
                                        <button data-id="'.$aRow->id.'" data-name="'.$aRow->name.'" data-expires="'.$aRow->expiry_day.'" data-note="'.$aRow->note.'" type="button" class="btn btn-success tableBtn editItemBtn">EDIT</button>
                                    </td>
                                </tr>
                            </tbody>';
                    }
                }
            ?>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Expiry date</th> 
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>

        
    </div>


<!-- ********************* EDIT ITEM MODAL ******************************************************* -->
    <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Edit item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="updateItemForm" action="apis/api-edit-item.php" method="POST">
                    <div class="modal-body">
                        <input name="rowId" id="rowId" type="hidden" value="<?=$_POST['rowId']?>">
                        <input disabled name="editItemName" value="" id="editItemName" type="text" placeholder="Edit name of item" class="form-control">
                        <?php
                            require_once __DIR__.'/connect.php';
                            $stmt = $db->prepare('SELECT * FROM food_items');
                            $stmt->execute();
                            $aRows = $stmt->fetchAll();
                        ?>
                        <select id="selectName" name="selectName" class="form-control">
                            <option disabled selected value>--------- Select new item ---------</option>
                            <?php
                                foreach($aRows as $aRow){
                                    echo "<option value=\"$aRow->id\">$aRow->name</option>";
                                }
                            ?>
                        </select>

                        <label for="editExpiryDay">Expiry date</label>
                        <input type="date" id="editExpiryDay" name="editExpiryDay" value="" min="2019-05-08" max="2030-12-31" class="form-control">
                        <label for="editItemNotes">Notes</label>
                        <textarea name="editItemNotes" id="editItemNotes" value="" cols="30" rows="4" placeholder="notes" class="form-control"></textarea>
                        <input name="addEditedItem" id="addEditedItem" type="submit" value="EDIT ITEM" class="form-control">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div id="addItem" class="page">
    
    <div id="addItemContainer">
        <h1>ADD ITEM</h1>

        <p>Search for an item here!</p>
        <form id="searchBar" method="GET">
            <input name="txtSearch" id="txtSearch" type="text" placeholder="Search for an existing item" class="form-control">
            <svg width="25" height="25" viewBox="0 0 1792 1792"><path d="M1216 832q0-185-131.5-316.5t-316.5-131.5-316.5 131.5-131.5 316.5 131.5 316.5 316.5 131.5 316.5-131.5 131.5-316.5zm512 832q0 52-38 90t-90 38q-54 0-90-38l-343-342q-179 124-399 124-143 0-273.5-55.5t-225-150-150-225-55.5-273.5 55.5-273.5 150-225 225-150 273.5-55.5 273.5 55.5 225 150 150 225 55.5 273.5q0 220-124 399l343 343q37 37 37 90z"/></svg>
        </form>
        <div id="searchResults"></div>

        <?php
            if (isset($_SESSION['message'])) {
                echo '<div id="sessionMessage">'.$_SESSION['message'].'</div>';
                unset($_SESSION['message']);
            }
        ?>

<!-- ************************************** ADD NEW ITEM TO DB **************************************** -->
        <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalLabel">Didn't find your item on the list?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="addNewItemToDb" action="apis/api-add-new-item-to-db.php" method="POST">
                        <div class="modal-body">
                        <label for="addNewItemName">Add your own item name</label>
                        <input name="addNewItemName" id="addNewItemName" type="text" placeholder="Item name" class="form-control">
                        
                        <?php
                            require_once __DIR__.'/connect.php';
                            $stmt = $db->prepare('SELECT * FROM food_categories');
                            $stmt->execute();
                            $aRows = $stmt->fetchAll();
                        ?>
                        <select name="selectCategory" id="selectCategory" class="form-control">
                            <option disabled selected value>Choose a Category</option>
                            <?php 
                                foreach($aRows as $aRow){
                                    echo "<option name=\"categoryName\" value=\"$aRow->id\">$aRow->category_name</option>";
                                }
                            ?>
                        </select>

                        <input name="addNewItemBtn" id="addNewItemBtn" type="submit" value="ADD" class="form-control">
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div id="addItemSection">
            <h4 style="text-align:center; padding:20px;">Add new item to your fridge!</h4>
            <form action="apis/api-add-item.php" method="POST">
                <label for="itemName">Name of item</label>
                <input disabled name="itemName" value="<?php echo $_GET['txtSearch']; ?>" id="itemName" type="text" placeholder="Item name" class="form-control">
                <input name="itemId" type="hidden" value="<?php echo $_GET['iItemId']; ?>">
                <label for="expiry_day">Expiry date</label>
                <input type="date" id="expiry_day" name="expiry_day" value="" min="2019-05-08" max="2030-12-31" class="form-control">
                <label for="itemNotes">Notes</label>
                <textarea name="itemNotes" id="itemNotes" cols="30" rows="4" placeholder="Write your notes here" class="form-control"></textarea>
                <input name="addItem" id="addItem" type="submit" value="ADD ITEM TO FRIDGE" class="form-control">
            </form>
        </div>
    </div>
</div>


<div id="profile" class="page">

    <h1>PROFILE</h1>
    <p>Welcome, <?php echo $sUser ?></p>
    <p>Email: <?php echo $sEmail ?></p>

    
    <div id="btnContainer">
        <div id="logoutBtn"><a href="logout.php">LOG OUT</a></div>
        <div id="deleteProfileBtn"><a href="apis/api-delete-profile.php">DELETE PROFILE</a></div>
    </div>

</div>

<?php
$sLinkToScript = '<script src="js/profile.js"></script>';
require_once 'bottom.php';
?>

