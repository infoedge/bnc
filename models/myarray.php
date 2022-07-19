class myarrays{
    public $myarr1 = array("checkDomains"=>array("infoedgenetwork.org","dolce.com","saxaphone.org"));

    function showArr()
    {
        $json_arr =  json_encode($myarr1,true,2);
        echo($json_arr);
    }
}