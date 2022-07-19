<?php
    include "mymodel.php";
    $
    $curling8 = new mydomain();
    $thedomain = $_GET['domanName'];
    $theyears = $_GET['numyears'];
    $data = array("years"=>$theyears);
    $result8 = $curling8->doCurl($data ,'getPricing',$thedomain);
    $curling8->resStr=json_decode($result8,true);
    if(array_key_exists('renewalPrice', $curling->resStr)){
        $transferPrice = $curling8->resStr["renewalPrice"];
        echo json_encode(['renewalPrice'=>$renewalPrice, 'msg'=>'success']);
    }elseif(array_key_exists('message', $curling->resStr)){
        echo json_encode(['renewalPrice'=>0, 'msg'=>'failed']);
    }
    exit;

?>