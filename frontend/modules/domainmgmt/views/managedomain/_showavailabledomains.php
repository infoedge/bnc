<?php
use yii\helpers\ArrayHelper;

    echo('<br>');
    echo("# of domains checked: ". $regcnt."<br>" );
    echo('<table border="1" cellpadding="1" class="table table-striped">
    <thead>
        <tr>
        <th>Domain</th>
        <th>Details</th>
        
        <th>Required ?</th>
        </tr>
    </thead>
    <tbody>');
    for($i=0;$i<$regcnt ;$i++){
        $counter = $i+1;
        if(ArrayHelper::keyExists('purchasable', $resStr[$i])){
            echo( 
            '<tr>'
            ."<td>$counter <input type=\"text\" name=\"urlDomain[$counter]\" value=\"". $resStr[$i]['domainName']."\" disabled= true /></td>"
            .'<td>Avalable for '. $resStr[$i]['purchaseType']
            .' @ $'. $resStr[$i]['purchasePrice'].' per Annum'
            .'; Renewable @ $'. $resStr[$i]['renewalPrice']
            ."<input type=\"hidden\" name=\"purchasePrice[$counter]\" id=\"purchasePrice[$counter]\""
            ." value=". $resStr[$i]['purchasePrice']." /></td>"
            ."<td class='ccheckbox'><input type=\"checkbox\" name=\"dom[$counter]\" id=\"dom[$counter]\" value=$counter  /></td>"
            .'</tr>');
            $_SESSION["Domain[".$counter."]"]=$aDomain[$counter]['urlDomain']= $resStr[$i]['domainName'];
            $_SESSION["Price[".$counter."]"]=$aDomain[$counter]['purchasePrice']= $resStr[$i]['purchasePrice'];
        }else{
            echo('<tr>'
            ."<td>$counter &nbsp;".  $resStr[$i]['domainName']."</td>"
            .'<td> is NOT available</td>'
            .'<td class="ccheckbox"></td>'
            .'</tr>');
        }
        
    } 
    
    echo('</tbody>
    </table>');
    echo('<input class = "btn btn-warning" type="submit" name="confirmRegDomain" id="confirmRegDomain"  value="Confirm Registration"  title="Cick Checkbox to the right of domain(s) required" >');
?>