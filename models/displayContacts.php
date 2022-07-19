<?php
    echo("<div class='domhead2'><h3>Contacts</h3>"
        ."<div class='details2'>");
    for($typeCnt=0;$typeCnt<count($domRegTypesArr);$typeCnt++){
        echo("<div class='details3'><h4>".ucfirst($domRegTypesArr[$typeCnt])."</h4>");
        for($regTypeCnt=0;$regTypeCnt< count($domFieldsArr);$regTypeCnt++){
            $itemLen = strlen($contacts[$domRegTypesArr[$typeCnt]][$domFieldsArr[$regTypeCnt]]);
            $itemLen = $itemLen<10? 5:$itemLen-1;
            echo("<div class=\"displayItem\">"
                ."<span class=\"lft\">"
                ."<strong>".$domFieldNamesArr[$regTypeCnt]."</strong>"
                ."<input type=\"text\" name=\"conttxt[".$domRegTypesArr[$typeCnt]."-".$domFieldsArr[$regTypeCnt]."]\" id=\"conttxt[".$domRegTypesArr[$typeCnt]."][".$domFieldsArr[$regTypeCnt]."]\"  value = \"".$contacts[$domRegTypesArr[$typeCnt]][$domFieldsArr[$regTypeCnt]]."\"  size=\"$itemLen\"/></span>"
                ."<input type=\"hidden\" name=\"conttxt-s[".$domRegTypesArr[$typeCnt]."-".$domFieldsArr[$regTypeCnt]."]\" id=\"conttxt-s[".$domRegTypesArr[$typeCnt]."][".$domFieldsArr[$regTypeCnt]."]\"  value = \"".$contacts[$domRegTypesArr[$typeCnt]][$domFieldsArr[$regTypeCnt]]."\"  size=\"$itemLen\"/></span>"
                // .$curling->resStr['contacts'][$domRegTypesArr[$typeCnt]][$domFieldsArr[$regTypeCnt]]."</span>"
            //."<span class=\"rgt\">"
            
            //."<input type=\"checkbox\" name=\"contbox[".$typeCnt."][".$regTypeCnt."]\" id=\"contbox[".$typeCnt."][".$regTypeCnt."]\" value = \"".$domRegTypesArr[$typeCnt]."-".$domFieldsArr[$regTypeCnt]."\" />"
            
            ."</span><br></div>");
            $domDetArr['contacts'][$domRegTypesArr[$typeCnt]][$domFieldsArr[$regTypeCnt]]= $contacts[$domRegTypesArr[$typeCnt]][$domFieldsArr[$regTypeCnt]];
        }
    echo("</div>");
    }
    echo("</div></div>");
?>