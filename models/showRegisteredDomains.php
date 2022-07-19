
<div class="container text-center">
            <h1>Registered Domains</h1>
</div>
<?php
echo('<h4>The following domains have been registered</h4>');
echo('# of domains: '.$regcnt.'<br>');
echo('<table class="table table-striped" border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Order No</th>
                <th>Amount Paid</th>
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
//print_r($regArray);
echo('</tbody>');
echo('</table>');
?>