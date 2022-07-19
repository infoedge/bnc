<?php
//include 'mydomain.php";
class mydomain{
    public $domainStr;
    public $dataArr;
    public $resStr;
    public $myerr=array();
    public function doCurl($dataArr= array(),$actionVerb='',$theDomain='')
    {
        $ch = curl_init();
        if($ch){
            switch($actionVerb){
                case 'checkAvailability':
                    // $curling = new mydomain();
                    // $domains = array("dolcerealestate.com","infoedgenetwork.com","broadnotescloud.org");
                    // $result= $curling->doCurl($domains,'checkAvailability');
                    if(!empty($theDomain)){
                        $eDomain = $this->postfixSlash($theDomain)."domains:";
                    }else{ 
                        $eDomain=''."domains:"; 
                    }
                    $this->domainStr = $this->convertArrayToStr($dataArr);
                    $fields = '{"domainNames":['.$this->domainStr.']}';
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    break;
                case 'transfers':
                    //$curling3 = new mydomain();
                    // $data = array('domainName'=>'infoedgenetwork.com','authCode'=>'Authc0de','purchasePrice'=>12.99);
                    // $result3 = $curling3->doCurl($data,'transfers');
                    $eDomain='';
                    //$fields = '"'. str_replace('"','\"',json_encode($this->domainStr)).'"';
                    //$fields =  str_replace('"','\"',json_encode($this->domainStr));
                    $fields =  json_encode($this->domainStr);
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    break;
                case 'renew':
                    // $curling4 = new mydomain();
                    // $data = array('purchasePrice'=>15.99);
                    // $result4 = $curling4->doCurl($data ,'renew','infoedgenetwork.com');
                    $eDomain =  'domains/'.$theDomain.':';
                    $fields =  json_encode($dataArr);
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    break;
                case 'getAuthCode':
                    // $curling5 = new mydomain();
                    // $data = array();
                    // $result5 = $curling5->doCurl($data ,'getAuthCode','infoedgenetwork.com');                   
                    $eDomain =  'domains/'.$theDomain.':';
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb);
                    break;
                case 'createDomain':
                    // $curling6 = new mydomain();
                    // $data = array("domain"=>array("domainName"=>"dolcerealestate.com"),"purchasePrice"=>14.99);
                    // $result6 = $curling6->doCurl($data ,'createDomain's);
                    $eDomain =  'domains';
                    //$domainStr = array("domain"=>array("domainName"=>"infoedgenetwork.com"),"purchasePrice"=>12.99)
                    $fields =  json_encode($dataArr);
                    //$fields = "'". json_encode($dataArr)."'";
                    //$fields = '"'. str_replace('"','\"', json_encode($dataArr)).'"';
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    break;
                case 'disableAutorenew':
                    // $curling7->doCurl($data ,'disableAutorenew','infoedgenetwork.com');
                    $eDomain =  'domains/'.$theDomain.':';
                    
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    break;
                case 'enableAutorenew':
                    // $curling7->doCurl($data ,'enableAutorenew','<infoedgenetwork.com>');
                    $eDomain =  'domains/'.$theDomain.':';
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    break;
                case 'getPricing':
                    //$data=array("years"=><n<10>);
                    $eDomain =  'domains/'.$theDomain.':';
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb);
                    if(count($dataArr)>0)
                    {
                        $fields = json_encode($dataArr);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    }
                    break;
                case 'unlock':
                    // $curling9->doCurl($data ,'unlock','<infoedgenetwork.com>');
                    $data=array();
                    
                    $eDomain =  'domains/'.$theDomain.':';
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    break;
                case 'lock'://lockDomain
                    //$data=array();
                    // $curling9->doCurl($data ,'unlock','<infoedgenetwork.com>');
                    $eDomain =  'domains/'.$theDomain.':';
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    break;
                case 'search':
                    $eDomain =  'domains:';
                    $fields =  json_encode($dataArr);
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    break;
                case 'searchStream':
                    $eDomain =  'domains:';
                    $fields =  json_encode($dataArr);
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    break;
                case 'getDomain':
                    $eDomain =  'domains/'.$theDomain;
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain);
                    break;
                case 'setContacts':
                    //'{"contacts":{"registrant":{"firstName":"Jane","lastName":"Doe","address1":"123 Main St.","city":"Denver","state":"CO","country":"US","phone":"+1.3035551212","email":"admin@example.net"}
                    //$data=array("contacts"=>array(
                    //      "registrant"=>array(
                    //      "firstName"=>"Jane","lastName"=>"Doe","address1"=>"123 Main St.","city"=>"Denver","state"=>"CO","country"=>"US","phone"=>"+1.3035551212","email"=>"admin@example.net"
                    //         )
                    //      "admin"=>array(
                    //      "firstName"=>"Jane","lastName"=>"Doe","address1"=>"123 Main St.","city"=>"Denver","state"=>"CO","country"=>"US","phone"=>"+1.3035551212","email"=>"admin@example.net"
                    //         )
                    //      "tech"=>array(
                    //      "firstName"=>"Jane","lastName"=>"Doe","address1"=>"123 Main St.","city"=>"Denver","state"=>"CO","country"=>"US","phone"=>"+1.3035551212","email"=>"admin@example.net"
                    //         ) 
                    //      "billing"=>array(
                    //      "firstName"=>"Jane","lastName"=>"Doe","address1"=>"123 Main St.","city"=>"Denver","state"=>"CO","country"=>"US","phone"=>"+1.3035551212","email"=>"admin@example.net"
                    //         )   
                    //     )
                    // );
                    $data=json_encode($dataArr);
                    // $curling9->doCurl($data ,'unlock','<infoedgenetwork.com>');
                    $eDomain =  'domains/'.$theDomain.':';
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    break;
                case 'setNameservers'://setNameServers
                    $data=json_encode($dataArr);
                    $eDomain =  'domains/'.$theDomain.':';
                    curl_setopt($ch, CURLOPT_URL, "https://api.dev.name.com/v4/".$eDomain.$actionVerb );
                    curl_setopt($ch, CURLOPT_POST, 1);
                    break;
                case 'listDomains':
                    $data= $dataArr;
                    $eDomain =  'domains';
                    curl_setopt($ch, CURLOPT_URL, "https://api.devname.com/v4/".$eDomain);
                    curl_setopt($ch, CURLOPT_POST, 1);
            }
            
            
            
            // set URL and other appropriate options
            //curl_setopt($ch, CURLOPT_URL, "http://www.example.com/");
            
            curl_setopt($ch, CURLOPT_HEADER, 0);
            
            //curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("\'Content-Type:application/json\'"));
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//retrieve output in a variable

            // -u 'username:token'
            include 'models/thekey.php';
            curl_setopt($ch, CURLOPT_USERPWD, $usrname);

            // grab URL and pass it to the browser
            $myval= curl_exec($ch);
            if(curl_error($ch)){
                $this->myerr =  curl_error($ch);
                
            }
            // close cURL resource, and free up system resources
            curl_close($ch);
            //curl -u 'username:token' 'https://api.dev.name.com/v4/domains:checkAvailability' -X POST -H 'Content-Type: application/json' --data '{"domainNames":["example.org"]}' 
         }else { /*what to do if curl_init fails*/
            $myval = array("unable to open channel");
        }
        return $myval;
    }
    function convertArrayToStr($myArr){
        $outStr = '';
        for( $i=0;$i<count($myArr);$i++){
            if($i!==0){
                    $outStr .= ', ';
                }
                $outStr .= '"'.$myArr[$i].'"' ;
        }
        return $outStr;
    }
    
    function postfixSlash($aDomain, $chr='/')
    {
        if(!substr_compare($aDomain,$chr,-1,1)){
            return $aDomain;
        }
        return $aDomain .$chr;
    }

    protected function prependStr($item,$strElem=':')
    {
        if(!substr($item,1,1,)==$strElem){
            return $strElem.$item;
        }
        return $item;
    }
    function confirmDomainDetails()
    {
        
        for($i=0;$i< sizeof($this->resStr['results']);$i++){
            $this->dataArr[$this->resStr['results'][$i]["domainName"]]["Name"] = $this->resStr['results'][$i]["domainName"];
            $this->dataArr[$this->resStr['results'][$i]["domainName"]]["tld"] = $this->resStr['results'][$i]["tld"];
            if (array_key_exists("purchasable",$this->resStr['results'][$i])){
                if($this->resStr['results'][$i]["purchasable"]==1){
                    $this->dataArr[$this->resStr['results'][$i]["domainName"]]["available"] = 1;
                    $this->dataArr[$this->resStr['results'][$i]["domainName"]]["purchaseType"] = $this->resStr['results'][$i]["purchaseType"];
                    $this->dataArr[$this->resStr['results'][$i]["domainName"]]["purchasePrice"] = $this->resStr['results'][$i]["purchasePrice"];
                    $this->dataArr[$this->resStr['results'][$i]["domainName"]]["renewalPrice"] = $this->resStr['results'][$i]["renewalPrice"];
                }else{
                    $this->dataArr[$this->resStr['results'][$i]["domainName"]]["available"] = 0;
                }

            }
        }
        return ;
    }

    function anArrayToString($myarr)
    {
        $outStr = '';
        $keys= array_keys($myarr);
        for($i=0;$i<count($keys);$i++){
            if($i>0){
               $outStr.=", ";
            }else{
                $outStr.='{';  
            }
            $outStr .= '"'.$keys[$i].'":';
            if(is_array($myarr[$keys[$i]])){
                //recursive
                $this->anArrayToString($myarr[$keys[$i]]);
            }else{
                if(ctype_digit($myarr[$keys[$i]])){
                   $outStr .=$myarr[$keys[$i]]; 
                }else{// is a string
                    $outStr .= '"'.$myarr[$keys[$i]].'"';
                }
                               
            }
        }
        $outStr .="}";
        return $outStr;
    }
}

       
?>