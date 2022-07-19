<?php

$myregArr=array();
$regcnt=count($_POST["chkbox"]);
foreach($_POST['chkbox'] as $val){
    //if(isset($val)){// Is Chkbox checked?
        //echo('checking '.$l);
        $curling6 = new mydomain();
        $data = array("domain"=>array("domainName"=>$_POST['adomain'][$val]),"purchasePrice"=>$_POST['avalue'][$val]);
        $result6 = $curling6->doCurl($data ,'createDomain');
        $curling6->resStr = json_decode($result6,true); 
        if(array_key_exists('message',$curling6->resStr)){
            $myregArr[$val]=array('message'=>$curling6->resStr['message']);
        }elseif(array_key_exists('domain',$curling6->resStr)){
            $myregArr[$val]=array('domain'=>$curling6->resStr['domain']['domainName'],
                                'order'=>$curling6->resStr['order'],
                                'totalPaid'=>$curling6->resStr['totalPaid'],
                                'message'=>'OK');
        }
    ///}                                                       
}
$regArray = $myregArr;
?>