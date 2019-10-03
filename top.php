<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>MYFRIDGE</title>    
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->

<?= $sLinkToCss ?? ''; ?>

<style>
*{
    margin: 0px;
    padding: 0px;
    box-sizing: border-box;
  }
  body{
    width: 100vw;
    height: 100vh;
    font-size: 16px;
    overflow: hidden;
    overflow-y: scroll;
    background-color: whitesmoke;
    font-family: "Avenir";
  }
  nav {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    position: fixed;
    top: 0px;
    left: 0px;
    width: 100vw;
    height: 66px;
    padding: 0px;
    font-size: 20px;
    color: white;
    /* background-image: linear-gradient(#027AC9, #19426F); */
    background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(151,221,176,1) 0%, rgba(5,175,157,1) 100%);
    z-index: 1;
  }
  nav div.active{
    background-color: rgba(0,0,0,.1);
  }
  nav > div{
    display: grid;
    justify-content: center;
    align-content: center;
    cursor: pointer;
    /* background-color: rgba(0,0,0,.7); */
  } 
  button:focus {
    outline: none;
  }

 
  /************************************************************/
  .page{
    position: absolute;
    top: 100px; left: 0px;
    padding: 20px 15%;
    display: none;
  }
  /************************************************************/

  #logo{
    width: 50px;
  }

  /************************** FORMS GENERAL **********************************/

  .form-control{
    margin-bottom: 15px;
  }

  label {
    margin-top: .5rem;
  }

  input[type=submit] {
      background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(151,221,176,1) 0%, rgba(5,175,157,1) 100%);
      color: white;
  }
  input[type=submit]:hover {
      opacity: 0.8;
      transition: .3s ease;
  }


 /* .form-control:focus {
    border-color: #FF0000;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
  } */

  @media only screen and (min-width: 600px){
  
  
  }

  @media only screen and (min-width: 768px) {

  
  }

  @media only screen and (min-width: 992px) {

  
  }


  @media only screen and (min-width: 1200px) {
  
  
  }

  @media only screen and (min-width: 1824px) {
  
  }


</style>
</head>

<body>

<?php
if(isset($_SESSION['sUserId'])){
    echo '
        <nav>
            <div><img id="logo" src="imgs/refrigerator-icon.png"></div>
            <div class="navLink active" data-showPage="fridge">MY FRIDGE</div>
            <div class="navLink" data-showPage="addItem">ADD ITEM</div>
            <div class="navLink" data-showPage="profile">PROFILE</div>
        </nav>';


}else{
    echo '
        <nav>
            <div><img id="logo" src="imgs/refrigerator-icon.png"></div>
            <div class="navLink active" data-showPage="login">LOGIN</div>
            <div class="navLink" data-showPage="signup">SIGNUP</div>
        </nav>';
}
?>


