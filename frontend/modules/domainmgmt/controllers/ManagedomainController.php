<?php

namespace app\modules\domainmgmt\controllers;

use Yii;
use common\models\Options;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

class ManagedomainController extends \yii\web\Controller
{
    public $trxoptn= 0;
    public $regArray=array();
    public $appArr = array(
        'domRegTypesArr'=> array("registrant","admin","tech", "billing"),
        'domFieldNamesArr'=> array("First Name: ","Last Name: ","Address 1: ","City: ","State: ","Country: ","Phone: ","E-mail: "),
        'domFieldsArr'=> array('firstName','lastName','address1','city','state','country','phone','email'),
        'domainDetTypesArr' => array('domainName','createDate','expireDate','renewalPrice','autorenewEnabled','locked','privacyEnabled','nameservers'),
        'domDetTypNamesArr'=> array('Domain Name: ','Create Date: ','Expiry Date: ','Renewal Price: $','Auto Renewal Enabled: ','Locked: ','Privacy Enabled: ','Name Servers: ')
    );
    public function actionChkAvailability()
    {
        $request=Yii::$app->request;
        $session = Yii::$app->session;
        $data = Yii::$app->session['domain'];
        $chkavailability=$cnt=0;
        $curling= Yii::$app->mydomain;
        $validity=Yii::$app->validation;
        $adomain=array(array());
        $regArray = array();
        $chkSearch=true;
        if($request->post('confirmRegDomain')){
            $ids = array();
            if($request->post("dom")){
                foreach($request->post("dom") as $val){
                    $ids[] = (int) $val;
                }
                $ids = implode(',', $ids);
                //$chkIds = explode(',',$ids);
                //print_r($chkIds); 
                //$totPrice=0;
            return $this->redirect(['confirm-register','ids'=>$ids]);
            }else {
                $session->setFlash("warning", "There must be at least one domain checked as required !!");
            }
        }
        //$curling = new mydomain();
        //        $data = $_POST["domain"];
                //$domains = explode(",",$data,50);
                
                 $domains= $validity->checkErrors($data,'url');
                // for($cnt=0;$cnt<count($domains);$i++){
                //     $url = trim(htmlspecialchars($domains[$cnt]));
                //     $url = filter_var($url, FILTER_VALIDATE_URL);
        
                //     if ($url === false) {
                //         $curling->myerr[$cnt]='Invalid URL';
                //     }
                // }
                // $curling = new mydomain();
                //$domains = explode(",",$data,50);
                $domains= $validity->checkErrors($data,'url');
                $result= $curling->doCurl($domains,'checkAvailability');
                $curling->resStr = json_decode($result, true);  
                $cnt = count($curling->resStr['results']); 
                if($cnt){
                    $chkavailability=1;
                    //convert $curling->resStr to model
                    
                    
                }
        return $this->render('chk-availability',[
                    'resStr'=>$curling->resStr['results'],
                    'appArr'=>$this->appArr,
                    'regcnt'=>$cnt
                ]);
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $myoptn= new Options();
        if($myoptn->load($request->post())&& $myoptn->validate()){
            
            $session['domain']=$myoptn->domain;
            switch($myoptn->trxoptn){
                case 1:
                    return $this->redirect(['chk-availability']);
                case 2:
                    return $this->redirect(['search']);
                case 6:
                    return $this->redirect(['show-details']);
                case 7:
                    return $this->redirect(['trxin-details']);
            }
        }
        return $this->render('index',
            [
                'myoptn'=>$myoptn,
                'trxoptn'=> $myoptn->trxoptn,
            ]);
    }

    public function actionSearch()
    {
        $request=Yii::$app->request;
        $cnt=$trxtype=$chkRegister=$chkSearch=$regConfirmation=0;
        $domain = "";
        $validity = Yii::$app->validation;;
        //$trxtype = $_SESSION['trxtype'];
        $data = Yii::$app->session['domain'];
        //$cycleCnt = $_SESSION['cycleCnt'];
        $adomain=array(array());
        $regArray = array();
        $chkSearch=true;
        if($request->post('confirmRegDomain')){
            $ids = array();
                foreach($request->post("dom") as $val){
                    $ids[] = (int) $val;
                }
                $ids = implode(',', $ids);
                $chkIds = explode(',',$ids);
                //print_r($chkIds); 
                $totPrice=0;
            return $this->redirect(['confirm-register','ids'=>$ids]);
        }
        $curling = Yii::$app->mydomain;
        //$data = $_SESSION["domain"];
        $domains= array("keyword"=>$data);
        $result1= $curling->doCurl($domains,'search',$data);
        $curling->resStr = json_decode($result1, true);  
        $cnt = count($curling->resStr['results']);
            return $this->render('search',[
                'resStr'=>$curling->resStr['results'],
                'appArr'=>$this->appArr,
                'regcnt'=>$cnt,
            ]);
        // }
    }

    public function actionShowDetails()
    {
        $data = array();
        $curling = Yii::$app->mydomain;
        $domain=Yii::$app->session['domain'];
        $result = $curling->doCurl($data ,'getDomain',$domain);
        //echo("Get Domain \n");
        $curling->resStr = json_decode($result,true);
        ////////////////////////////////////////////////
        $resStr= $curling->resStr;
        $errmsg=0;
        if(ArrayHelper::keyExists('message',$resStr)){
            $errmsg = 1;
            Yii::$app->session->setFlash("warning",$domain.": ".$resStr["message"]);
        }
        return $this->render('show-details',[
            'resStr'=> $resStr,
            'appArr'=> $this->appArr,
            'errmsg'=> $errmsg,
        ]);
    }

    public function actionTrxinDetails()
    {
        $domain = Yii::$app->session['domain'];
        $model= new Options();
        $model->scenario='trxin';
        //set values
        $model->domain = $domain;
        $model->trxoptn = 7;
        $model->transferPrice = $this->getPricing($domain);
        if($model->load(Yii::$app->request->post())){
            
        }
        return $this->render('trxin-details',[
            'model'=> $model, 
        ]);
    }

    public function actionConfirmRegister($ids)
    {
        $request = Yii::$app->request;
        $chkIds = explode(',',$ids);
        $totPrice=$regcnt=0;
        
        if($request->post("confirmRegBtn")){
            $myregArr=array();
            //$regcnt=sizeof($request->post("chkbox"));
            if($request->post("chkbox")){
                foreach($request->post("chkbox") as $val){
                    //if(isset($val)){// Is Chkbox checked?
                        //echo('checking '.$l);
                        $curling6 = Yii::$app->mydomain;
                        $data = array("domain"=>array("domainName"=>$_POST['adomain'][$val]),"purchasePrice"=>$_POST['avalue'][$val]);
                        $result6 = $curling6->doCurl($data ,'createDomain');
                        $curling6->resStr = json_decode($result6,true); 
                        if(array_key_exists('message',$curling6->resStr)){
                            $myregArr[$val]=array('message'=>$curling6->resStr['message']);
                        }elseif(array_key_exists('domain',$curling6->resStr)){
                            $myregArr[$val]=array('domain'=>$curling6->resStr['domain']['domainName'],
                                                'order'=>$curling6->resStr['order'],
                                                'totalPaid'=>$curling6->resStr['totalPaid'],
                                                'message'=>'OK');
                        }
                    ///}                                                       
                }
                Yii::$app->session['regArray']= $myregArr;
                return $this->redirect(['confirmed-registration']);
            }else{//No Checkbox selected
                Yii::$app->session->setflash("warning","You have not confirmed any domain !!");
            }
        }
        return $this->render('confirm-register',[
            'chkIds'=>$chkIds,
            'totPrice'=>$totPrice,
            'regArray'=>$this->regArray,
        ]);
    }

    public function actionConfirmedRegistration()
    {
        return $this->render('confirmed-registrations',[
            'regArray'=>Yii::$app->session['regArray'],
        ]);
    }

    public function actionListDomains()
    {
        $session=Yii::$app->session;
        $domainsList = $this->getDomainsList();
        if(!ArrayHelper::keyExists('domains',$domainsList)){
            $session->setFlash('info','No domains found: '.$domainsList['message']);
            return $this->redirect(['index']);
        }else{
            $provider=$this->createArrProvider($domainsList);
        }
        return $this->render('list-domains',[  
            'provider'=>$provider,
            
        ]);
    }

    public function getPricing($thedomain,$pricetype='transferPrice')
    {
        $data=array();
        $trxInResult = 0;
        $curling8 = Yii::$app->mydomain;
        $result8 = $curling8->doCurl($data ,'getPricing',$thedomain);
        $curling8->resStr=json_decode($result8,true);
        if(ArrayHelper::keyExists('transferPrice',$curling8->resStr)){
            $trxInResult = $curling8->resStr[$pricetype];
        }
        
        return $trxInResult;
    }

    public function createArrProvider($arrData)
    {
        return $myArrProvider= new ArrayDataProvider([
            'allModels'=>$arrData['domains'],
            'pagination'=>[
                'pageSize'=>20,
            ],
        
            'sort' => [
                'attributes'=>['domainName','expireDate'],
            ],

        ]);
    }
    public Function getDomainsList()
    {
        $curling = Yii::$app->mydomain;
        $data=array();
        $result = $curling->doCurl($data ,'listDomains');
        return $curling->resStr = json_decode($result,true);
    }

    public function confirmDomainInList($domainName)
    {
        $mylist = $this->getDomainsList();
        $domainNameListArr = ArrayHelper::getColumn($mylist['domains'],'domainName');
        return ArrayHelper::isIn($domainName,$domainNameListArr);
    }

}
