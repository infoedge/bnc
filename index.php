<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <![endif]-->


<html>
<head>
<?php
include 'models/mydomain.php';
include 'models/validation.php';
include 'models/myFieldTypes.php';

session_start();
$trxOptn=0;
$domain="";
if (isset($_POST['submitBtn'])) {
    $thedomain = $_POST['domain'];
    $_SESSION['thedomain']= $thedomain;
    $_SESSION['cycleCnt'] = 0;
    $trxOptn = $_POST['trxOptn'];

    switch($trxOptn){
        case 1:
            
            $_SESSION['trxtype'] = $trxOptn;
            if($thedomain){
                header('location: chkavailability.php');
            }
            break;
        case 2:
            $_SESSION['trxtype'] = $trxOptn;
            if($thedomain){
                header('location: search.php');
            }
            break;
        case 6:
            $_SESSION['trxtype'] = $trxOptn;
            if($thedomain){
                header('location: showdetails.php');
            }
            break;
    }
}
?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Home</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css" />
        <script src="js/jquery-3.6.0.min.js"></script>
        <Script src="js/animate.js"></script>
        <Script src="js/domDetails.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="wrapper">
        <div class="container text-center">
<h1 class="animation animated-item-1">Domain Management</h1>



<form method="post" action="index.php">
<input name="token" value="39ba071cce1bfc9bc571653ecd0a3763092302f1" type="hidden">
<div class="row">
    <!--<h3>Transaction Type</h3>-->
    <h3>I want to:</h3>
        <p>
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
    Confirm Available Domain(s)<input type="radio" name="trxOptn" id="confirmDomain" value="1"  > &nbsp; &nbsp; &nbsp;
    Search <input type="radio" name="trxOptn" id="search" value="2"  >  &nbsp; &nbsp; &nbsp;
    Show Domain Details <input type="radio" name="trxOptn" id="showDomain" value="6"  >  &nbsp; &nbsp; &nbsp;
    
    Transfer Domain In <input type="radio" name="trxOptn" id="trfDomain" value="7"  >  &nbsp; &nbsp; &nbsp;

    <br><br>
    </div>
    
    <div class='row'>
        <div class="col-sm-8">
            <input class="form-control" name="domain" id="domain"  autocapitalize="none" type="text" width="50" value="<?php echo($domain);  ?>">
        </div>
        <div class="col-sm-4">
            <input type="submit" class="btn btn-success" name="submitBtn" id="submitBtn" value="Submit">
        </div>
    </div>
    <div class='row authArea'>
    <span id='tfr_Area'> 
    <span id="auth_code">
     <p ><strong>To transfer a domain name in, there are a few requirements to be met namely:-</strong>
         <ul><li>The domain name must have been registered within the last 60 days.</li>
            <li>The domain name must NOT have been transferred within the last 60 days.</li>
            <li>The domain name must be unlocked at the current registrar.</li>
            <li>You will need to get the domain name's transfer authorization/EPP code from the current registrar.</li>
            </ul>
            Enter Authorization/EPP Code <input type="text" id="eppcode" name="eppcode" title="EPP Code">
        </p></span>
</span>
</div>
        </p>
</div>
</form>
        
        <script src="" async defer></script>
    </body>
</html>