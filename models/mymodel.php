<?php

include 'mydomain.php';

    $curling = new mydomain();
    $domains = array("dolcerealestate.com","infoedgenetwork.com","broadnotescloud.org","andantefarm.org");
    $result= $curling->doCurl($domains,'checkAvailability');
    
    if(!empty($curling->myerr)){
        echo('Error: '.$curling->myerr);
    }else{
        $curling->resStr = json_decode($result, true);
        print_r($curling->resStr);
        $curling->confirmDomainDetails();
        
        echo('# of Arrays: '. sizeof($curling->resStr['results'])."\n" );
        for($i=0;$i< sizeof($curling->resStr['results']);$i++){
            $theDomain = $curling->resStr['results'][$i]["domainName"];
            if($curling->resStr['results'][$i]['purchasable']==1){
                if ($curling->resStr['results'][$i]['purchaseType']=='registration'){
                    echo($theDomain.' is available @ $'.$curling->resStr['results'][$i]["purchasePrice"]."\n");
                }else{
                    echo($theDomain.' is renewable @ $'.$curling->resStr['results'][$i]["renewalPrice"]."\n");
                }
            }else{
                echo($theDomain.' is available NOT available'."\n");
            }
        }
        
    }
    // $curling2 = new mydomain();
    // $domains = array("infoedgenetwork.com");
    // $result2= $curling2->doCurl($domains,'getAuthCode');
    // if(!empty($curling->myerr)){
    //     echo('Error: '.$curling2->myerr);
    // }else{
    //     $resStr2 = json_decode($result2, true);
    //     print_r($resStr2);
    // }

    $curling3 = new mydomain();
    $data = array('domainName'=>'infoedgenetwork.com','authCode'=>'Authc0de','purchasePrice'=>12.99);
    $result3 = $curling3->doCurl($data,'transfers');
    echo('Json Encoded Str: '."'". json_encode($data)."'"."<br>");
    echo('Data String: '.$curling3->anArrayToString($data)."<br>");
    echo("TransferDomain \n");
    print_r($result3);

    $curling4 = new mydomain();
    $data = array('purchasePrice'=>15.99);
    $result4 = $curling4->doCurl($data ,'renew','infoedgenetwork.com');
    echo("RenewDomain \n");
    print_r($result4);

    $curling5 = new mydomain();
    $data = array();
    $result5 = $curling5->doCurl($data ,'getAuthCode','infoedgenetwork.com');
    echo("GetAuthCode \n");
    print_r($result5);
     $curling5->resStr = json_decode($result5,true);
     print_r($curling5->resStr);

    $curling6 = new mydomain();
    $data = array("domain"=>array("domainName"=>"dolcevaultestate.com"),"purchasePrice"=>14.99);
    $result6 = $curling6->doCurl($data ,'createDomain');
    echo("CreateDomain \n");
    print_r($result6);
    $domainArr = $curling6->resStr["domain"];
    print_r($domainArr);
    //echo("transferPrice: ".$transferPrice);

    $curling7 = new mydomain();
    $data = array();
    $result7 = $curling7->doCurl($data ,'disableAutorenew','infoedgenetwork.com');
    echo("disableAutorenew \n");
    print_r($result7);

    $curling8 = new mydomain();
    $data = array("years"=>2);
    $result8 = $curling8->doCurl($data ,'getPricing','infoedgenetwork.com');
    echo("getPricing <br>");
    print_r($result8);
    $curling8->resStr=json_decode($result8,true);
    $transferPrice = $curling8->resStr["transferPrice"];
    echo("transferPrice: ".$transferPrice);

    $curling9 = new mydomain();
    $data = array();
    $result9 = $curling9->doCurl($data ,'enableAutorenew','safaricom.com');
    echo("enableAutorenew <br>");
    print_r($result9);
    $curling9->resStr=json_decode($result9,true);
    print_r($curling9->resStr);
        echo('TransferPrice: $'.    $curling9->resStr['']);

    $curling10 = new mydomain();
    $data = array("keyword"=>"andante files");
    $result10 = $curling10->doCurl($data ,'search','andante files');
    echo("search <br>");
    print_r($result10);
    echo("Search Array <br>");
    $curling->resStr = json_decode($result10,true);
    print_r($curling->resStr);

    $curling11 = new mydomain();
    $data = array("keyword"=>"blue lagoon");
    $result11 = $curling11->doCurl($data ,'searchStream','blue lagoon');
    echo("search Stream \n");
    $curling->resStr = json_decode($result11,true);
    //(, '{n}.domainName', '{n}.purchasePrice',  '{n}.renewalPrice', '{n}.renewalPrice'); 
    print_r($curling->resStr);

    $curling12 = new mydomain();
    $data = array();
    $result12 = $curling12->doCurl($data ,'getDomain','infoedgenetwork.com');
    echo("Get Domain \n");
    $curling->resStr = json_decode($result12,true);
     
    print_r($curling->resStr);
    
    $curling13 = new mydomain();
    $data = array();
    $result13 = $curling13->doCurl($data ,'setNameservers','infoedgenetwork.com');
    echo("Get Domain \n");
    $curling13->resStr = json_decode($result13,true);
     
    print_r($curling13->resStr);
    
    $curling14 = new mydomain();
    $data = array();
    $result14 = $curling14->doCurl($data ,'listDomains');
    echo("List Domains \n");
    $curling14->resStr = json_decode($result14,true);
     
    print_r($curling14->resStr);
?>