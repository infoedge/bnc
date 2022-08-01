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

    $cnt=$trxtype=$chkRegister=$chkSearch=$regConfirmation=0;
    $domain = "";
    $validity = new validation();
    $trxtype = $_SESSION['trxtype'];
    $data = $_SESSION['thedomain'];
    $cycleCnt = $_SESSION['cycleCnt'];
    $chkavailability=1;
    $regArray = array();
    if(isset($_POST['confirmRegDomain'])){
        // header('location: registerdomain.php');
        $chkRegister=1;
    }elseif(isset($_POST['confirmRegBtn'])){//Register now
        $regConfirmation = 1;
        include 'models/buildRegArr.php';
    }else{
    //check domain

    $curling = new mydomain();
    //$domains = explode(",",$data,50);
    $domains= $validity->checkErrors($data,'url');
    $result= $curling->doCurl($domains,'checkAvailability');
    $curling->resStr = json_decode($result, true);  
    $cnt = count($curling->resStr['results']);   
    }
?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Check Availability</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/local.css" />
        <script src="js/jquery-3.6.0.min.js"></script>
        <Script src="js/animate.js"></script>
        <Script src="js/domDetails.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="wrapper">
        <a href="<?php echo str_replace($_SERVER['PHP_SELF'],'index.php',$_SERVER['REQUEST_URI']); ?>">Home</a>
        <form method="post" action="chkavailability.php">
        <input name="token" value="39ba071cce1bfc9bc571653ecd0a3763092302f1" type="hidden">
        <?php
        if($cnt>0 && (!$chkRegister )){
                //print_r($domains);
                ?>
        <div class="container text-center">
            <h1><?php echo($trxtype==1?"Check Available Domains":"Search for Domain");?></h1>
        </div>
        <?php
        include 'models/showavailabledomains.php';
            }elseif($chkRegister){
                $ids = array();
                foreach($_POST['dom'] as $val){
                    $ids[] = (int) $val;
                }
                $ids = implode(',', $ids);
                $chkIds = explode(',',$ids);
                //print_r($chkIds); 
                $totPrice=0;?>
        <div class="container text-center">
            <h1><?php echo("Confirm Domain Registration"); ?></h1>
        </div>
        <?php
        include 'models/confirmreg.php';
             } 
             elseif($regConfirmation){
                //Array $regArray must be created first
                include 'models/showRegisteredDomains.php';
            }
            ?>
            <!--   &nbsp; &nbsp; &nbsp;-->
            </form>
            <!--</div>-->
        </div>
        <script src="" async defer></script>
    </body>
</html>