<?php
/* @var $this yii\web\View */
$this->title='Check Availability';
$data = Yii::$app->session['domain'];
$chkavailability=0;
$curling= Yii::$app->mydomain;
$validity=Yii::$app->validation;
//$curling = new mydomain();
//        $data = $_POST["domain"];
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
        $cnt = count($curling->resStr['results']);
        if($cnt){
            $chkavailability=1;
        }
?>
<h1>Domain Availability</h1>

<div>
    <?php if($chkavailability){
        Yii::$app->display->availableList($curling->resStr['results']);
    }?>
</div>
