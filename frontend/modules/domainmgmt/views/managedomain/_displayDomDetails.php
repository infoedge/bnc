<?php
use yii\helpers\ArrayHelper;

echo("<div >"
."<div class='details details1'>"
."<div class='domhead1'>"
."<h3>Domain Details</h3></div><br>");
$domainDetTypesArr = $appArr["domainDetTypesArr"];
$domDetTypNamesArr = $appArr["domDetTypNamesArr"];
for($domDetCnt=0;$domDetCnt<count($domainDetTypesArr);$domDetCnt++){
    if($domDetCnt==4||$domDetCnt==6){
        continue;//skip autoRenewEnabled and PrivacyEnabled
    }elseif( $domDetCnt==7 && ArrayHelper::keyExists('nameservers', $resStr)){//nameservers
        echo("<strong>Name Servers </strong><br>");
        for($m=0;$m<count($resStr['nameservers']);$m++){
            echo("<div class=\"displayItem\"><span class='lft'>&nbsp;&nbsp;".($m +1)
            ."&nbsp;<input type=\"text\" name=\"nsvrtxt[]\" id=\"nsvrtxt[$m]\"  value =\"".$resStr['nameservers'][$m]."\" disabled=\"disabled\"  size=\"15\" />"
            ."<input type=\"hidden\" name=\"nsvrtxt-s[]\" id=\"nsvrtxt-s[$m]\"  value =\"".$resStr['nameservers'][$m]."\" disabled=\"disabled\" size=\"15\"/>"
            ."</span>"
            ."<span class=\"rgt\"><input type=\"checkbox\" name=\"nsvrbox[$m]\" id=\"nsvrbox[$m]\" value=\"$m\"  />"
            ."</span>"
            ."</div>"
            ."<br>");
            $nameSvrArr[$m] = $resStr['nameservers'][$m];
        }
    }else{
        if( ArrayHelper::keyExists($domainDetTypesArr[$domDetCnt],$resStr)){
            echo("<strong>".$domDetTypNamesArr[$domDetCnt]."</strong>");
            echo($resStr[$domainDetTypesArr[$domDetCnt]]);
            echo("<br>");//Next line
        }else{
            echo("<strong>".$domDetTypNamesArr[$domDetCnt]."</strong>: NOT Found<br>");
        }
    }
}
echo("</div></div>");
?>