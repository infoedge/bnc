<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
<?php
include 'models/mydomain.php';
include 'models/validation.php';
include 'models/myFieldTypes.php';

session_start();
$chkDomain=true;
$trxOut=$chgContacts=$renDomain=0;
$domain = $_SESSION["thedomain"];
$curling = new mydomain();
// $contacts=array();

if(isset($_POST['transferOutBtn'])){//transfer out
        $trxOut=1;
            $domains= array();
            //unlock first
            $data = $domain;
            $result3 = $curling->doCurl($domains,'unlock',$data);
            //End Unlock First
            $result2= $curling->doCurl($domains,'getAuthCode',$data);
            $curling->resStr = json_decode($result2,true);
}elseif(isset($_POST['chgContacts'])){
    $chgContacts=1;
    $conttxt = $_POST['conttxt'];
    //$conttxt-s = $_POST['conttxt-s'];
    $curling = new mydomain();
    $data = array();
        $result = $curling->doCurl($data ,'getDomain',$domain);
        $curling->resStr = json_decode($result,true);
        $contacts= $curling->resStr['contacts'];//all default values put in contacts
        //look for changes
        for($typCnt=0;$typCnt<count($domRegTypesArr);$typCnt++){
            for($fldCnt=0;$fldCnt< count($domFieldsArr);$fldCnt++){
                //get checkbox name

                //if(($conttxt[$domRegTypesArr[$typCnt]."-".$domFieldsArr[$fldCnt]]!== $conttxts[$domRegTypesArr[$typCnt]."-".$domFieldsArr[$fldCnt]] )){
                    $contacts[$domRegTypesArr[$typCnt]][$domFieldsArr[$fldCnt]]= $conttxt[$domRegTypesArr[$typCnt]."-".$domFieldsArr[$fldCnt]];
                //}
            }
        }
        ///////////////////////// Change contacts
        $domains= array("contacts"=>$contacts);
        $data = $curling->resStr['domainName'];
        //$mydomain = $curling->resStr["domainName"];
        $curling = new mydomain();
        $result= $curling->doCurl($domains,'setContacts',$data);
        $curling->resStr = json_decode($result, true);
        ////////////////////////////////////////////////
        // if(!array_key_exists('message', $curling4->resStr)){
        //     $curling = new mydomain();
        //     $data = array();
        //     $result = $curling->doCurl($data ,'getDomain',$domain);
            
        //     $curling->resStr = json_decode($result,true);
        // }
}elseif(isset($_POST['renewBtn'])){// Renew a domain
    $renDomain = 1;
    // getPricing
    $data = array();
    $curling5 = new mydomain();
    $result5 = $curling5->doCurl($data ,'getPricing',$domain);
    $curling5->resStr = json_decode($result5,true);
    $renewalPrice = $curling5->resStr['renewalPrice'];

    // Renew for 1 year
    $curling = new mydomain();
    $data=array("purchasePrice"=>$renewalPrice);
    $result = $curling->doCurl($data ,'renew',$domain);
    $curling->resStr = json_decode($result,true);
    //$renDetails = $curling->resStr['domain']
}else{
    $data = array();
    $result = $curling->doCurl($data ,'getDomain',$domain);
    //echo("Get Domain \n");
    $curling->resStr = json_decode($result,true);
    ////////////////////////////////////////////////
    $contacts= $curling->resStr['contacts'];
    ////////////////////
    $domDetArr=array("contacts"=>
            array(
                "registrant"=>array(),
                "admin"=>array(),
                "tech"=>array(),
                "billing"=>array()
            )
        // "nameservers"=>array()
    );
    $nameSvrArr=array();
}
?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Show Details</title>
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
        <a href="<?php echo str_replace($_SERVER['PHP_SELF'],'index.php',$_SERVER['REQUEST_URI']); ?>">Home</a>
        <form method="post" action="showdetails.php">
        <input name="token" value="39ba071cce1bfc9bc571653ecd0a3763092302f1" type="hidden">
        <?php    if(!$trxOut && !$chgContacts){ ?>
        <div class="container text-center">
            <h1>Show Domain Details</h1>
            <?php 
                if($renDomain){
                    echo('<h5>Domain Renewed upto: '. $curling->resStr['domain']['expireDate']
                        .' for Renewal Price of $'.$curling->resStr['totalPaid'] .'( Order No: '.$curling->resStr['order'] );
                }
            ?>
        </div>
            <?php
                if(array_key_exists('message', $curling->resStr)){
                    echo("Error: ".$curling->resStr['message']);
                }elseif(array_key_exists('domainName', $curling->resStr)){
                    //print_r($curling->resStr);
                    
                    include 'models/displayDomDetails.php';
                    //."<div class='dom-header'><h3>Contacts</h3>"
                    include 'models/displayContacts.php';
                    //echo("</div'>");
                    echo('<br><br><br>');
                    ?>
                <?php 
                if(!$renDomain){// Dont show after renewing domain ?> 
                     <!-- buttons -->
                    <div class='row domheader'>
                    <div class="container text-center">
                    <div class='action_btns'>
                    
                    <input type='submit' name='chgContacts' id='chgContacts' class='btn btn-warning' value='Change Contact Details'  />
                    <input type='hidden' name='chgRegDtlsCnt' id='chgRegDtlsCnt' value=0 />
                    <input type='submit' name='renewBtn' id='renewBtn' class='btn btn-success' value='Renew Domain' />
                    <input type='submit' name='chgNameSvrBtn' id='chgNameSvrBtn' class='btn btn-primary' value='Change Name Servers' disabled='disabled'/>
                    <input type='hidden' name='chgNameSvrCnt' id='chgNameSvrCnt' value=0 />
                    <input type='submit' name='transferOutBtn' id='transferOutBtn' class='btn btn-danger' value='Transfer Out' />
                    
                    </div></div></div><br>
                <?php } 
                ?>
            <?php        
                }
            ?>
            <?php } elseif($trxOut){//transfer Out
            ?>
                <div class="container text-center">
                    <h1>Transfer Domain Out</h1>
                
                    <h4>
            <?php
                if(array_key_exists('authCode', $curling->resStr)){
                    echo("Transfer for domain <strong>' $data ' </strong>: Autorization/EPP code= ".$curling->resStr["authCode"] );
                }elseif(array_key_exists('message', $curling->resStr)){
                    echo($curling->resStr['message']);
                }else{
                    echo("Autorization/EPP code for domain <strong>' $data '</strong> NOT found");
                }
                echo("</h4>
                </div>");
                }elseif($chgContacts=1){//display changed contacts
                    ?>
                    <div class="container text-center">
                    <h1>Changed Contacts</h1>
                    <div>
                   <?php
                   echo('Domain: '. $domain);
                include 'models/displayContacts.php';
                //    print_r($contacts);
                //    print_r($curling->resStr['contacts']);
                }
            ?>
        </form>
        </div>
        <script src="" async defer></script>
    </body>
</html>