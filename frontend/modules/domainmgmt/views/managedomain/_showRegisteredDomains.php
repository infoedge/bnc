
<?php
$regcnt=count($regArray);
echo('<h4>The following domains have been registered</h4>');
echo('# of domains: '.$regcnt.'<br>');
echo('<table class="table table-striped" border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Order No</th>
                <th>Amount Paid ($)</th>
            </tr>
        </thead>
        <tbody>');
foreach($regArray as $item){
    echo('<tr>');
        
        echo("<td>".$item['domain']."</td>");
        echo("<td>".$item['order']."</td>");
        echo("<td>".$item['totalPaid']."</td>");
        
    echo('</tr>');
}

echo('</tbody>');
echo('</table>');
// print_r($regArray);
?>