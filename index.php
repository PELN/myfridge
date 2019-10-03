<?php
session_start();
$sLinkToCss = '<link rel="stylesheet" href="css/login.css">';
require_once 'top.php';

if(isset($_SESSION['sUserId']))
{
    //not logged in
    header('Location: profile.php');
    exit();
}

?>

<div id="login" class="page">
    <div id="loginContainer">
        <div id="txtContainer">
            <h1>LOG IN</h1>
                <?php
                    if (isset($_SESSION['loginMessage'])) {
                        echo '<p style="text-align:center; color:mediumvioletred; font-weight:500;">'.$_SESSION['loginMessage'].'</p>';
                        unset($_SESSION['loginMessage']);
                    }
                ?>
        </div>
        <form id="loginForm" action="apis/api-login.php" method="POST" style="width:400px;">
            <label for="loginUsername">Username</label>
            <input name="loginUsername" id="loginUsername" type="text" placeholder="username" class="form-control">
            <label for="loginPassword">Password</label>
            <input name="loginPassword" id="loginPassword" type="text" placeholder="password" class="form-control">
            <input name="submitLogin" id="submitLogin" type="submit" value="LOGIN" class="form-control">
        </form>
    </div>
</div>


<div id="signup" class="page">

    <div id="signupContainer">
        <div id="txtContainer">
            <h1>SIGN UP</h1>
                <?php
                    if (isset($_SESSION['signupMessage'])) {
                        echo '<p style="text-align:center; color:mediumvioletred; font-weight:500;">'.$_SESSION['signupMessage'].'</p>';
                        unset($_SESSION['signupMessage']);
                    }
                ?>
        </div>

        <form id="signupForm" action="apis/api-signup.php" method="POST" style="width:400px;">
            <label for="signupEmail">Email</label>
            <input name="signupEmail" type="text" placeholder="email" class="form-control">
            <label for="signupUsername">Username</label>
            <input name="signupUsername" type="text" placeholder="username" class="form-control">
            <label for="signupPassword">Password</label>
            <input name="signupPassword" type="text" placeholder="password" class="form-control">
            <label for="signupPassword">Confirm password</label>
            <input name="signupConfirmPassword" type="text" placeholder="confirm password" class="form-control">
            <input name="submitSignup" id="signupBtn" type="submit" value="REGISTER" class="form-control">
        </form>

    </div>
</div>




<?php 
$sLinkToScript = '<script src="js/index.js"></script>';
require_once 'bottom.php';
?>

