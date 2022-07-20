<?php
//get pricing
$curling8 = new $mydomain;
$result8 = $curling8->doCurl($data ,'getPricing',$thedomain);
$curling8->resStr=json_decode($result8,true);
$trxInResult = $curling8->resStr;
//complete transfer
$data = array('domainName'=>$thedomain,'authCode'=>$eppcode,'purchasePrice'=>$trxInResult['transferPrice']);
$result = $curling->doCurl($data,'transfers');
$curling->resStr= json_decode($result,true);

?>