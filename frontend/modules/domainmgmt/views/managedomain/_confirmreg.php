<?php
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
        $totPrice +=  $_SESSION["Price[".$chkIds[$j]."]"];
    }
    echo("<tr><td><strong> Total Price $</strong> </td><td><strong>".$totPrice."</strong></td><td ><strong><span id='calc_total'>0.00</span></strong><input type='hidden' name='theCalcTotal' id='theCalcTotal' value='0' /></td>"
    ."<tr><td></td><td></td>"
    ."<td><input name='confirmRegBtn' id='confirmRegBtn' class='btn btn-warning' value='confirm' type='submit'></td></tr>");
    $_SESSION['TotalPrice']= $totPrice;
    echo('</tbody>
    </table>');


?>