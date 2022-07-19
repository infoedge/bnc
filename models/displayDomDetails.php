<?php
echo("<div class='domdet'>"
."<div class='details details1'>"
."<div class='domhead1'>"
."<h3>Domain Details</h3></div><br>");
for($domDetCnt=0;$domDetCnt<count($domainDetTypesArr);$domDetCnt++){
 if($domDetCnt==4||$domDetCnt==6){
     continue;//skip autoRenewEnabled and PrivacyEnabled
 }elseif($domDetCnt==7 && array_key_exists('nameservers', $curling->resStr)){//nameservers
     echo("<strong>Name Servers </strong><br>");
     for($m=0;$m<count($curling->resStr['nameservers']);$m++){
         echo("<div class=\"displayItem\"><span class='lft'>&nbsp;&nbsp;".($m +1)
         ."&nbsp;<input type=\"text\" name=\"nsvrtxt[]\" id=\"nsvrtxt[$m]\"  value =\"".$curling->resStr['nameservers'][$m]."\" disabled=\"disabled\" />"
         ."<input type=\"hidden\" name=\"nsvrtxt-s[]\" id=\"nsvrtxt-s[$m]\"  value =\"".$curling->resStr['nameservers'][$m]."\" disabled=\"disabled\" />"
         ."</span>"
         ."<span class=\"rgt\"><input type=\"checkbox\" name=\"nsvrbox[$m]\" id=\"nsvrbox[$m]\" value=\"$m\"  />"
         ."</span>"
         ."</div>"
         ."<br>");
         $nameSvrArr[$m] = $curling->resStr['nameservers'][$m];
     }
 }else{
     if(array_key_exists($domainDetTypesArr[$domDetCnt],$curling->resStr)){
     echo("<strong>".$domDetTypNamesArr[$domDetCnt]."</strong>");
     echo($curling->resStr[$domainDetTypesArr[$domDetCnt]]);
     echo("<br>");//Next line
     }else{
         echo("<strong>".$domDetTypNamesArr[$domDetCnt]."</strong>: NOT Found<br>");
     }
 }

}
echo("</div>");
?>