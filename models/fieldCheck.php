<?php
    $myfields=array('domainName'=>'infoedgenetwork.com','authCode'=>'23434561','purchasePrice'=>12.99);
    $myjson = "\'".json_encode($myfields)."\'";
    echo($myjson);
?>