<?php
namespace common\components;

use Yii;
use yii\base\Component;

class Display extends Component{
    public $domRegTypesArr = Yii::$app->appArrays->domRegTypesArr;
    public $domFieldsArr = Yii::$app->appArrays->domFieldsArr;
    public $domFieldNamesArr = Yii::$app->appArrays->domFieldNamesArr;
    public $totPrice=0;
    public $cnt;
    public function contacts($contacts=array()){
        echo("<div class='domhead2'><h3>Contacts</h3>"
            ."<div class='details2'>");
        for($typeCnt=0;$typeCnt<count($this->domRegTypesArr);$typeCnt++){
            echo("<div class='details3'><h4>".ucfirst($this->domRegTypesArr[$typeCnt])."</h4>");
            for($regTypeCnt=0;$regTypeCnt< count($$this->domFieldsArr);$regTypeCnt++){
                $itemLen = strlen($contacts[$this->domRegTypesArr[$typeCnt]][$this->domFieldsArr[$regTypeCnt]]);
                $itemLen = $itemLen<10? 5:$itemLen-1;
                echo("<div class=\"displayItem\">"
                    ."<span class=\"lft\">"
                    ."<strong>".$this->domFieldNamesArr[$regTypeCnt]."</strong>"
                    ."<input type=\"text\" name=\"conttxt[".$this->domRegTypesArr[$typeCnt]."-".$this->domFieldsArr[$regTypeCnt]."]\" id=\"conttxt[".$this->domRegTypesArr[$typeCnt]."][".$this->domFieldsArr[$regTypeCnt]."]\"  value = \"".$contacts[$this->domRegTypesArr[$typeCnt]][$this->domFieldsArr[$regTypeCnt]]."\"  size=\"$itemLen\"/></span>"
                    ."<input type=\"hidden\" name=\"conttxt-s[".$this->domRegTypesArr[$typeCnt]."-".$this->domFieldsArr[$regTypeCnt]."]\" id=\"conttxt-s[".$this->domRegTypesArr[$typeCnt]."][".$this->domFieldsArr[$regTypeCnt]."]\"  value = \"".$contacts[$this->domRegTypesArr[$typeCnt]][$this->domFieldsArr[$regTypeCnt]]."\"  size=\"$itemLen\"/></span>"
                    // .$curling->resStr['contacts'][$domRegTypesArr[$typeCnt]][$domFieldsArr[$regTypeCnt]]."</span>"
                //."<span class=\"rgt\">"
                
                //."<input type=\"checkbox\" name=\"contbox[".$typeCnt."][".$regTypeCnt."]\" id=\"contbox[".$typeCnt."][".$regTypeCnt."]\" value = \"".$domRegTypesArr[$typeCnt]."-".$domFieldsArr[$regTypeCnt]."\" />"
                
                ."</span><br></div>");
                $domDetArr['contacts'][$this->domRegTypesArr[$typeCnt]][$this->domFieldsArr[$regTypeCnt]]= $contacts[$this->domRegTypesArr[$typeCnt]][$this->domFieldsArr[$regTypeCnt]];
            }
        echo("</div>");
        }
        echo("</div></div>");
    }

    public function registerQuest($chkIds)
    {

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
        ."<input type='hidden' name=\"adomain[$j]\" id='adomain-".$j."' value='".$_SESSION["Domain[".$chkIds[$j]."]"]."'"
        ."</td>");
        echo('<td>'. $_SESSION["Price[".$chkIds[$j]."]"]
        ."<input type='hidden' name=\"avalue[$j]\" id='avalue-".$j."' value='".$_SESSION["Price[".$chkIds[$j]."]"]."'"
        ."</td>"
        ."<td class='ccheckbox'><input type=\"checkbox\" name=\"chkbox[]\" id=\"chkbox[$j]\" value=$j  /></td></tr>");
        $this->totPrice +=  $_SESSION["Price[".$chkIds[$j]."]"];
    }
    echo("<tr><td><strong> Total Price $</strong> </td><td><strong>".$this->totPrice."</strong></td><td ><strong><span id='calc_total'>0.00</span></strong><input type='hidden' name='theCalcTotal' id='theCalcTotal' value='0' /></td>"
    ."<tr><td></td><td></td>"
    ."<td><input name='confirmRegBtn' id='confirmRegBtn' class='btn btn-warning' value='confirm' type='submit'></td></tr>");
    $_SESSION['TotalPrice']= $this->totPrice;
    echo('</tbody>
    </table>');
    }

    public function availableList($showArr)
    {
        // if($this->cnt>0 && ($chkavailability || $chkSearch )){
            //print_r($domains);
        $this->cnt=count($showArr);    
            echo('<br>');
         echo("# of valid domains: ". $this->cnt."<br>" );
         echo('<table border="1" cellpadding="1" class="table table-striped">
         <thead>
             <tr>
                <th>Domain</th>
                <th>Details</th>
                
                <th>Required ?</th>
             </tr>
         </thead>
         <tbody>');
            for($i=0;$i<$this->cnt ;$i++){
                $counter = $i+1;
               if(array_key_exists('purchasable',$showArr[$i])){
                   echo( 
                    '<tr>'
                    ."<td>$counter <input type=\"text\" name=\"urlDomain[$counter]\" value=\"".$showArr[$i]['domainName']."\" disabled= true /></td>"
                    .'<td>Avalable for '.$showArr[$i]['purchaseType']
                    .' @ $'.$showArr[$i]['purchasePrice'].' per Annum'
                    .'; Renewable @ $'.$showArr[$i]['renewalPrice']
                    ."<input type=\"hidden\" name=\"purchasePrice[$counter]\" id=\"purchasePrice[$counter]\""
                    ." value=".$showArr[$i]['purchasePrice']." /></td>"
                    . "<td class='ccheckbox'><input type=\"checkbox\" name=\"dom[$counter]\" id=\"dom[$counter]\" value=$counter  /></td>"
                    .'</tr>');
                    $_SESSION["Domain[".$counter."]"]=$aDomain[$counter]['urlDomain']=$showArr[$i]['domainName'];
                    $_SESSION["Price[".$counter."]"]=$aDomain[$counter]['purchasePrice']=$showArr[$i]['purchasePrice'];
                }else{
                    echo('<tr>'
                    ."<td>$counter". $showArr[$i]['domainName']."</td>"
                    .'<td> is NOT available</td>'
                    .'<td class="ccheckbox"></td>'
                    .'<tr>');
                }
                
            } 
             echo('</tbody>
             </table>');
    }
}
?>