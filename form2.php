<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domain Register</title>
<?php

include 'models/mydomain.php';
include 'models/validation.php';
include 'models/myFieldTypes.php';

session_start();
    $cnt=0;
    $chkavailability=$searchBtn=$chkTransfer=$chkRegister=$chkDomain= $changeSvrs= $changeContacts=$confirmReg=$renewDomain =0;
    $validity = new validation();
    $domain = "";
    $changeContacts=0;
    $changeSvrs=0;
    $servers=array();
    $msgs = array(array());
    if(isset($_POST['checkAvailabilityBtn']))
    {
        $chkavailability=1;
        $curling = new mydomain();
        $data = $_POST["domain"];
        //$domains = explode(",",$data,50);
        
         $domains= $validity->checkErrors($data,'url');
        // for($cnt=0;$cnt<count($domains);$i++){
        //     $url = trim(htmlspecialchars($domains[$cnt]));
	    //     $url = filter_var($url, FILTER_VALIDATE_URL);

        //     if ($url === false) {
        //         $curling->myerr[$cnt]='Invalid URL';
        //     }
        // }
        $result= $curling->doCurl($domains,'checkAvailability');
        $curling->resStr = json_decode($result, true);  
        $cnt = sizeof($curling->resStr['results']);
        //$available = $result[];
    }elseif(isset($_POST["searchBtn"])){
        $adomain=array(array());
        $chkSearch=true;
        //$data = array("keyword"=>htmlspecialchars($_POST["domain"]));
        $curling = new mydomain();
        $data = $_POST["domain"];
        $domains= array("keyword"=>$data);
        $result1= $curling->doCurl($domains,'search',$data);
        $curling->resStr = json_decode($result1, true);  
        $cnt = sizeof($curling->resStr['results']);
        //print_r($curling->resStr);
    }elseif(isset($_POST["transferBtn"])){
        $adomain=array(array());
        $chkTransfer = true;
        $curling = new mydomain();
        $data = $_POST["domain"];
        $trfType = $_POST["tfr_Optn"];
        $eppCode = $_POST["eppcode"];
        $confirmTransfer= $_POST["confirmTransfer"];
        if($trfType==1 && $confirmTransfer){// OUT
            $domains= array();
            //unlock first
            $result3 = $curling->doCurl($domains,'unlock',$data);
            //End Unlock First
            $result2= $curling->doCurl($domains,'getAuthCode',$data);
            $curling->resStr = json_decode($result2,true);
        }elseif($trfType==1 && !$confirmTransfer){// OUT transfer NOT confirmed

        }elseif($trfType==2){// IN
            
            $curling9 = new mydomain();
            $mydata = array();
            $result9 = $curling9->doCurl($mydata ,'getPricing',$data);
            $curling9->resStr=json_decode($result9,true);
            $transferPrice = $curling9->resStr["transferPrice"];
            $domains = array('domainName'=>$data,'authCode'=>$eppCode,'purchasePrice'=>$transferPrice);
            $result  = $curling->doCurl($domains,'transfers');
            $curling->resStr = json_decode($result,true);
        }
        
    }elseif(isset($_POST["registerBtn"])){
        $chkRegister = true;
    }elseif(isset($_POST['chkDetailsBtn'])){
        $chkDomain=true;
        $domain = $_POST["domain"];
        $curling = new mydomain();
        $data = array();
        $result = $curling->doCurl($data ,'getDomain',$domain);
        //echo("Get Domain \n");
        $curling->resStr = json_decode($result,true);
        $domDetArr=array("contacts"=>
                array("registrant"=>
                    array(
                        "admin"=>array(),
                        "tech"=>array(),
                        "billing"=>array()
                    )
                )
               // "nameservers"=>array()
        );
        $nameSvrArr=array();
    }elseif(isset($_POST['chgRegDtlsBtn'])){
        $curling = new mydomain();
        $result = $curling->doCurl($data ,'getDomain',$domain);
        $curling->resStr = json_decode($result,true);
        $contacts= $curling->resStr['contacts'];//all default values put in contacts
        $changeContacts = 1;
        for($typCnt=0;$typCnt<count($domRegTypesArr);$typCnt++){
            for($fldCnt=0;$fldCnt< count($domFieldsArr);$fldCnt++){
                //get checkbox name

                if(!empty($_POST['contbox['.$typCnt .']['.$fldCnt.']'])){
                    $contacts[$domRegTypesArr[$typCnt]][$domFieldsArr[$fldCnt]]= $_POST['contbox['.$typCnt .']['.$fldCnt.']'];
                }
            }
        }
        // Change contacts
        $domains= array("contacts"=>$contacts);
        $data = $_POST["domain"];
        $mydomain = $curling->resStr["domainName"];
        $result4= $curling->doCurl($domains,'setContacts',$data);
        $curling->resStr = json_decode($result4, true);
        if(!array_key_exists('message', $curling->resStr)){
            $curling = new mydomain();
            $data = array();
            $result = $curling->doCurl($data ,'getDomain',$domain);
            
            $curling->resStr = json_decode($result,true);
        }  

    }elseif(isset($_POST['confirmRegBtn']) && floatval($_POST['theCalcTotal'])>0){//confirm Registration
        $confirmReg=1;
        foreach($_POST['chkbox'] as $val){
            $ids[] = (int) $val;
        }
        $ids = implode(',', $ids);
        $chkIds = explode(',',$ids);
        for($j=0;$j< count($chkIds) ; $j++){
            //register the domain
            $domain = $_POST['adomain['.$j.']'];
            $price = $_POST['avalue['.$j.']'];
            $curling = new mydomain();
            $data = array("domain"=>array("domainName"=>$domain),"purchasePrice"=>$price);
            $result = $curling->doCurl($data ,'createDomain');
            //confirm if registration was successful
            $curling->resStr = json_decode($result,true);
            $msgs[$j]['domain'] = $curling->resStr['domain']['domainName'];
            if(array_key_exists('message', $curling->resStr)){
                //failed domain registration
                $msgs[$j]['error'] = $curling->resStr['message'];
                $msgs[$j]['totalPaid'] = '0';
            }else{// successful domail Registration
                $totRegVal+=$price;
                $msgs[$j]['totalPaid'] = $curling->resStr['totalPaid'];
                $msgs[$j]['error'] ='';
            }
        }

    }elseif(isset($_POST['chgNameSvrBtn'])){
        $changeSvrs= 1;
        $domain = $_POST['domain'];
        $curling = new mydomain();
        //$servers=array();
        //$data=array();
        //$result = $curling->doCurl($data ,'getDomain',$domain);
        //$curling->resStr = json_decode($result,true);
        //$servers=$curling->resStr['nameservers'];
        
        //foreach($_POST["nsvrbox"] as $i=>$chkBox){
            //if(!empty($chkBox)){
        $servers =$_POST['nsvrtxt'];
        
            //}
        //}
        // change name servers
        $data= array("nameservers"=>$servers);
        
        $result4= $curling->doCurl($data,'setNameservers',$domain);
        $curling->resStr = json_decode($result4, true);
        // if(!array_key_exists('message', $curling->resStr)){
        //     $curling = new mydomain();
        //     $data = array();
        //     $result = $curling->doCurl($data ,'getDomain',$domain);
            
        //     $curling->resStr = json_decode($result,true);
        // }    
    }elseif(isset($_POST[''])){//renew domain
        $renewDomain=1;

    }
?>
<link rel="stylesheet" href="css/bootstrap.min.css"/>
<link rel="stylesheet" href="css/local.css" />
<script src="js/jquery-3.6.0.min.js"></script>
<Script src="js/animate.js"></script>
<Script src="js/domDetails.js"></script>

</head>
<body>
<?php ?>
<div class="wrapper">
<h1 class="animation animated-item-1">Register / Transfer Domains</h1>
<!--<p><?php echo($_SERVER['SERVER_NAME'])?></p>-->
<div class="container text-center">

<form method="post" action="form2.php">
<input name="token" value="39ba071cce1bfc9bc571653ecd0a3763092302f1" type="hidden">
<div class="row">
    <h3>Transaction Type</h3>
    <p><strong>I want to:</strong></p>
        <p>
        
            Confirm Available Domain(s)<input type="radio" name="trxOptn" value="1" checked=true /> &nbsp; &nbsp; &nbsp;
        Search <input type="radio" name="trxOptn" value="2"  />  &nbsp; &nbsp; &nbsp;
        Renew Domain<input type="radio" name="trxOptn" value="3"  />  &nbsp; &nbsp; &nbsp;
         
        Transfer Domain<input type="radio" id ="trxOptn4" name="trxOptn" value="4"  /> &nbsp; &nbsp; &nbsp;
        Register Domain(s) <input type="radio" name="trxOptn" value="5"  />  &nbsp; &nbsp; &nbsp;
        Show Domain Details <input type="radio" name="trxOptn" value="6"  />  &nbsp; &nbsp; &nbsp;
        </p>
</div>
<div class="row">
<div class="col-md-5 col-md-offset-1 col-sm-5" col-sm-offset-1="">
 <input class="form-control" name="domain" id="domain" placeholder="Find your Domain Name" autocapitalize="none" type="text" width="50" value="<?php echo($domain);  ?>">
 <span id='tfr_Area'> 
     &nbsp; &nbsp; <label for="tfr_Optn1" >Out</label><input type="radio" id="tfr_Optn1" name="tfr_Optn" value=1  />
 &nbsp;&nbsp;<label for="tfr_Optn2" >In</label><input type="radio" id="tfr_Optn2" name="tfr_Optn" value=2  /><input type="hidden" id="confirmTransfer" name="confirmTransfer" value=0 />
 &nbsp;&nbsp;<span id="auth_code">Authorization Code <input type="text" id="eppcode" name="eppcode" title="EPP Code"><p>To transfer a domain name, there are a few requirements to be met namely:-
         <ul><li>The domain name must have been registered at least 60 days ago.</li>
            <li>The domain name cannot have been transferred within the last 60 days.</li>
            <li>The domain name must be unlocked at the current registrar.</li>
            <li>You will need to get the domain name's transfer authorization/EPP code from the current registrar.</li>
            </ul>
        </p></span>
</span>
<span id='renew_Area'>
    Renew with $ <span id=renewAmt></span> for <input type="text" id="numyears" name="numyears" title="Number Of Years" value=1 size="2"> years
</span> 
 </div>
 <div>
     <p>
         <?php
         //echo("Data recieved: ".$data);
            
            if($cnt>0 && ($chkavailability || $chkSearch )){
                //print_r($domains);
                
                echo('<br>');
             echo("# of valid domains: ". $cnt."<br>" );
             echo('<table border="1" cellpadding="1" class="table table-striped">
             <thead>
                 <tr>
                    <th>Domain</th>
                    <th>Details</th>
                    
                    <th>Required ?</th>
                 </tr>
             </thead>
             <tbody>');
                for($i=0;$i<$cnt ;$i++){
                    $counter = $i+1;
                   if(array_key_exists('purchasable',$curling->resStr['results'][$i])){
                       echo( 
                        '<tr>'
                        ."<td>$counter <input type=\"text\" name=\"urlDomain[$counter]\" value=\"".$curling->resStr['results'][$i]['domainName']."\" disabled= true /></td>"
                        .'<td>Avalable for '.$curling->resStr['results'][$i]['purchaseType']
                        .' @ $'.$curling->resStr['results'][$i]['purchasePrice'].' per Annum'
                        .'; Renewable @ $'.$curling->resStr['results'][$i]['renewalPrice']
                        ."<input type=\"hidden\" name=\"purchasePrice[$counter]\" id=\"purchasePrice[$counter]\""
                        ." value=".$curling->resStr['results'][$i]['purchasePrice']." /></td>"
                        . "<td class='ccheckbox'><input type=\"checkbox\" name=\"dom[$counter]\" id=\"dom[$counter]\" value=$counter  /></td>"
                        .'</tr>');
                        $_SESSION["Domain[".$counter."]"]=$aDomain[$counter]['urlDomain']=$curling->resStr['results'][$i]['domainName'];
                        $_SESSION["Price[".$counter."]"]=$aDomain[$counter]['purchasePrice']=$curling->resStr['results'][$i]['purchasePrice'];
                   }else{
                       echo('<tr>'
                       ."<td>$counter". $curling->resStr['results'][$i]['domainName']."</td>"
                       .'<td> is NOT available</td>'
                       .'<td class="ccheckbox"></td>'
                       .'<tr>');
                   }
                   
                } 
                echo('</tbody>
                </table>');
            }elseif($chkTransfer && $trfType==1 ){ //transfer out
                if(array_key_exists('authCode', $curling->resStr)){
                    echo("Transfer for domain ' $data ' autorization code= ".$curling->resStr["authCode"] );
                }elseif(array_key_exists('message', $curling->resStr)){
                    echo($curling->resStr['message']);
                }else{
                    echo("Autorization code for domain ' $data ' NOT found");
                }
            }elseif($chkTransfer && $trfType==2 ){// transfer in
                if(array_key_exists('transfer', $curling->resStr)){
                    echo('Domain:'.$curling->resStr['transfer']['DomainName']."<br>");
                    echo('Status:'.$curling->resStr['transfer']['status']."<br>");
                    echo('Order No:'.$curling->resStr['order']."<br>");
                    echo('Total Paid:'.$curling->resStr['totalPaid']."<br>");
                }else{//no EPP code
                    echo($curling->resStr['message']);
                }
            }elseif($chkRegister){
                $ids = array();
                foreach($_POST['dom'] as $val){
                    $ids[] = (int) $val;
                }
                $ids = implode(',', $ids);
                $chkIds = explode(',',$ids);
                //print_r($chkIds); 
                $totPrice=0;
                echo("<strong>You have selected the following domains:</strong> <br>");
                echo('<table class="table table-striped" border="1" cellpadding="5">
                <thead>
                    <tr>
                       <th>Domain</th>
                       <th>Price ($)</th>
                       
                       <th>Confirmed ?</th>
                    </tr>
                </thead>
                <tbody>');
                for($j=0;$j< count($chkIds) ; $j++){
                   echo('<tr><td> '. $_SESSION["Domain[".$chkIds[$j]."]"]."&nbsp"
                   ."<input type='hidden' name='adomain[".$j."]' id='adomain-".$j."' value='".$_SESSION["Domain[".$chkIds[$j]."]"]."'"
                   ."</td>");
                   echo('<td>'. $_SESSION["Price[".$chkIds[$j]."]"]
                   ."<input type='hidden' name='avalue[".$j."]' id='avalue-".$j."' value='".$_SESSION["Price[".$chkIds[$j]."]"]."'"
                   ."</td>"
                   ."<td class='ccheckbox'><input type=\"checkbox\" name=\"chkbox[$j]\" id=\"chkbox[$j]\" value=$j  /></td></tr>");
                   $totPrice +=  $_SESSION["Price[".$chkIds[$j]."]"];
                }
                echo("<tr><td><strong> Total Price $</strong> </td><td><strong>".$totPrice."</strong></td><td ><strong><span id='calc_total'>0.00</span></strong><input type='hidden' name='theCalcTotal' id='theCalcTotal' value='0' /></td>"
                ."<tr><td></td><td></td>"
                ."<td><input name='confirmRegBtn' id='confirmRegBtn' class='btn btn-warning' value='confirm' type='submit'></td></tr>");
                $_SESSION['TotalPrice']= $totPrice;
                echo('</tbody>
                </table>');
            }elseif($chkDomain  || $changeContacts ){
                if(array_key_exists('message', $curling->resStr)){
                    echo("Error: ".$curling->resStr['message']);
                }elseif(array_key_exists('domainName', $curling->resStr)){
                    //print_r($curling->resStr);
                    echo("<div class='row domheader'>"
                    ."<div class='action_btns'>"
                    ."<input type='submit' name='chgNameSvrBtn' id='chgNameSvrBtn' class='btn btn-primary' value='Change Name Servers' disabled='disabled'/>"
                    ."<input type='hidden' name='chgNameSvrCnt' id='chgNameSvrCnt' value=0 />"
                    ."&nbsp;&nbsp<input type='submit' name='chgRegDtlsBtn' id='chgRegDtlsBtn' class='btn btn-primary' value='Change Registration Details'  disabled='disabled'/>"
                    ."<input type='hidden' name='chgRegDtlsCnt' id='chgRegDtlsCnt' value=0 />"
                    ."</div></div><br>");
                    include 'models/displayDomDetails.php';
                    //."<div class='dom-header'><h3>Contacts</h3>"
                    include 'models/displayContacts.php';
                    //echo("</div'>");
                    echo('<br>');
                    
                }
            }elseif($changeSvrs){
                print_r($servers);
                if(array_key_exists('message', $curling->resStr)){
                    echo("Error: ".$curling->resStr['message']);
                }else{
                    //domain name

                    echo("<strong>Name Servers </strong><br>");
                    echo("Data<br>");
                    print_r($data);
                    print_r($curling->resStr);
                        for($m=0;$m<count($curling->resStr['nameservers']);$m++){
                            echo("<div class=\"displayItem\"><span class='lft'>&nbsp;&nbsp;".($m +1)
                            ."&nbsp;<input type=\"text\" name=\"nsvrtxt[$m]\" id=\"nsvrtxt[$m]\"  value =\"".$curling->resStr['nameservers'][$m]."\" disabled=\"disabled\" />"
                            ."<input type=\"hidden\" name=\"nsvrtxt-s[$m]\" id=\"nsvrtxt-s[$m]\"  value =\"".$curling->resStr['nameservers'][$m]."\" disabled=\"disabled\" />"
                            ."</span>"
                            ."<span class=\"rgt\"><input type=\"checkbox\" name=\"nsvrbox[$m]\" id=\"nsvrbox[$m]\" value=\"$m\"  />"
                            ."</span>"
                            ."</div>"
                            ."<br>");
                            $nameSvrArr[$m] = $curling->resStr['nameservers'][$m];
                        }
                    }
            }
            
         ?>
     </p>
 </div>
 
<div class="col-sm-12">
<div class="btn-group" role="group" aria-label="Basic example">
        <button type="submit" class="btn btn-success" name="checkAvailabilityBtn" id="checkAvailabilityBtn">Confirm Availability</button>
        <button type="submit" class="btn btn-primary" name="searchBtn" id="searchBtn" >Search</button>
        <button type="submit" class="btn btn-danger" name="renewBtn" id="renewBtn" >Renew Domain</button>
        <button type="submit" class="btn btn-dark" name="transferBtn" id="transferBtn">Transfer</button>
        <button type="submit" class="btn btn-warning" name="registerBtn" id="registerBtn" >Register</button>
        <button type="submit" class="btn btn-info" name="chkDetailsBtn" id="chkDetailsBtn">Show Domain Details</button>
</div>
<br>
       </div>
</div>
</form> </div>
</div>
        </div>
</body>
</html>