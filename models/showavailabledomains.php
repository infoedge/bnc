<?php
                echo('<br>');
             echo("# of valid domains: ". $cnt."<br>" );
             echo('<table border="1" cellpadding="1" class="table table-striped">
             <thead>
                 <tr>
                    <th>Domain</th>
                    <th>Details</th>
                    
                    <th>Required ?</th>
                 </tr>
             </thead>
             <tbody>');
                for($i=0;$i<$cnt ;$i++){
                    $counter = $i+1;
                   if(array_key_exists('purchasable',$curling->resStr['results'][$i])){
                       echo( 
                        '<tr>'
                        ."<td>$counter <input type=\"text\" name=\"urlDomain[$counter]\" value=\"".$curling->resStr['results'][$i]['domainName']."\" disabled= true /></td>"
                        .'<td>Avalable for '.$curling->resStr['results'][$i]['purchaseType']
                        .' @ $'.$curling->resStr['results'][$i]['purchasePrice'].' per Annum'
                        .'; Renewable @ $'.$curling->resStr['results'][$i]['renewalPrice']
                        ."<input type=\"hidden\" name=\"purchasePrice[$counter]\" id=\"purchasePrice[$counter]\""
                        ." value=".$curling->resStr['results'][$i]['purchasePrice']." /></td>"
                        . "<td class='ccheckbox'><input type=\"checkbox\" name=\"dom[$counter]\" id=\"dom[$counter]\" value=$counter  /></td>"
                        .'</tr>');
                        $_SESSION["Domain[".$counter."]"]=$aDomain[$counter]['urlDomain']=$curling->resStr['results'][$i]['domainName'];
                        $_SESSION["Price[".$counter."]"]=$aDomain[$counter]['purchasePrice']=$curling->resStr['results'][$i]['purchasePrice'];
                   }else{
                       echo('<tr>'
                       ."<td>$counter". $curling->resStr['results'][$i]['domainName']."</td>"
                       .'<td> is NOT available</td>'
                       .'<td class="ccheckbox"></td>'
                       .'</tr>');
                   }
                   
                } 
                
                echo('</tbody>
                </table>');
                echo('<input class = "btn btn-warning" type="submit" name="confirmRegDomain" id="confirmRegDomain"  value="Confirm Registration"  title="Cick Checkbox to the right of domain(s) required" >');
                ?>