<?php
include "validInput.php";
class validation
{
    public $commaCnt;
    public $vals= array();
    public $errStr='';
    public $errCnt=0;
    public $errArr = array();

    public $errMsgs = array();
    public $goodArr = array();
    public $searchStr='';

    function checkErrors($strIn,$strType = 'url'){
        $myvalid = new validInput();
        //get items in string nad their count
        $this->vals = explode(',',$strIn,50);
        $this->commaCnt = count($this->vals);
        switch( $strType){
            case 'url':
                for($i=0;$i< $this->commaCnt;$i++){
                    try{
                        $this->goodArr[]=$this->vals[$i];

                    }catch( Exception  $e){
                        $this->errMsgs[] = $e->getMessage();
                        $this->errArr[]=$this->vals[$i];
                        $this->errCnt++;
                        if(!$myvalid->url($this->vals[$i])&& $this->errCnt==0){
                            $this->errStr = strval($i);
                            $this->errArr[]=$this->vals[$i];
                            $this->errCnt++;
                        } elseif(!$myvalid->url($this->vals[$i])&& $this->errCnt>0){
                            $this->errStr = ', '.strval($i);
                            $this->errArr[]=$this->vals[$i];
                            $this->errCnt++;
                        }
                    }
                    
                }
                if($this->errCnt=1){
                $this->errStr =  "Item ".$this->errStr." is invalid";
                }elseif($this->errCnt>1){
                    $this->errStr =  "Items ".$this->errStr." are invalid";
                }
                return $this->goodArr;
            case 'email':
                break;
            case 'int':
                break;
            case 'str':
                $myvalid = new validInput();
                //get items in string nad their count
                $this->vals = explode(',',$strIn,50);
                //get first string
                $strout = '';
                for($i=0;$i<strlen($this->vals[0]);$i++){
                    try{
                        if($this->vals[0][$i]==(' ' ||'.'))
                        {
                            break;
                        }else{
                            $strout .= '$this->vals[0][$i]';
                        }
                    }catch(Exception $e){
                        $this->errMsgs[] = $e->getMessage();
                            $this->errArr[]=$this->vals[$i];
                            $this->errCnt++;
                    }
                }
                $this->searchStr= $strout;
                return array("keyword"=>$strout);
                
        }
    }
    function checkSearchStr($strIn)
    {
        //get first string
        $searchStr = trim($strIn);
    }
}
?>