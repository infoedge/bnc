<?php

namespace app\modules\domainmgmt\controllers;

use Yii;

use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;

use common\models\Dnsrecord;
use common\models\Options;
use common\models\Dnslist;

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
        
                
        $domains= $validity->checkErrors($data,'url');

        $domains= $validity->checkErrors($data,'url');
        $result= $curling->doCurl($domains,'checkAvailability');
        $curling->resStr = json_decode($result, true);  
        if(array_key_exists('results', $curling->resStr)){
            $cnt = count($curling->resStr['results']); 
            return $this->render('chk-availability',[
                    'resStr'=>$curling->resStr['results'],
                    'appArr'=>$this->appArr,
                    'regcnt'=>$cnt
                ]);
        }else{
            $session->setFlash('warning','Please enter valid domain(s)');
            $this->redirect(['index']);
            
        }
        
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
                    return $this->redirect(['show-details','domain'=>$myoptn->domain]);
                case 7:
                    return $this->redirect(['trxin-details']);
                case 8:
                    return $this->redirect(['list-records']);
                case 9:
                    return $this->redirect(['list-domains']);
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
        $session=Yii::$app->session;
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
        if($request->post('confirmRegDomain')&& $request->post('dom')){
            $ids = array();
                foreach($request->post("dom") as $val){
                    $ids[] = (int) $val;
                }
                $ids = implode(',', $ids);
                $chkIds = explode(',',$ids);
                //print_r($chkIds); 
                $totPrice=0;
            return $this->redirect(['confirm-register','ids'=>$ids]);
        }elseif($request->isPost){
            $session->setFlash("warning","There must be at least one domain chosen. Click the checkbox in the required column to select!");
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

    public function actionShowDetails($domain)
    {
        $data = array();
        $curling = Yii::$app->mydomain;
        //$domain=Yii::$app->session['domain'];
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
        if($this->confirmDomainInList($domain)){
            $this->redirect(['transfer-out']);
        }
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
            'domainsList'=> $domainsList,
        ]);
    }

    public function actionTransferOut()
    {
        $model=new Options();
        $model->scenario='trxout';
        $model->domain=Yii::$app->session['domain'];
        return $this->render('transfer-out',[
            'model'=>$model,
        ]);
        
    }

    public function actionListDnsRecords()
    {
        $session = Yii::$app->session;
        $thedomain= $session['domain'];
        $recsArr= $this->getDomainsListModel($thedomain);
        if(empty($recsArr) ){
            $session->setFlash("warning","No DNS records found!");
            return $this->redirect(['index']);
        }else{
            $provider= new ActiveDataProvider([
                'allModels' => $recsArr,
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                    'sort' => [
                        'attributes'=>['domainName'],
                    ],   
                ]);
        }
        return $this->render('list-dns-models',[
            'provider'=>$provider,
            'recsArr'=> $recsArr,
        ]);

    }

    public function actionListRecords($thedomain)
    {
        $session = Yii::$app->session;
        //$thedomain= $session['domain'];
        $recsArr= $this->getListRecords($thedomain);
        if(empty($recsArr) || !ArrayHelper::keyExists("records", $recsArr)){
            $session->setFlash("warning","No DNS records found!");
            return $this->redirect(['index']);
        }else{
            $provider= new ArrayDataProvider([
                'allModels' => $recsArr['records'],
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                    'sort' => [
                        'attributes'=>['domainName'],
                    ],   
                ]);
        }
        return $this->render('list-records',[
            'provider'=>$provider,
            'recsArr'=> $recsArr,
        ]);

    }
    
    public function actionLstdetails($domain)
    {
        Yii::$app->session['domain']=$domain;
        return $this->redirect(['listRecords']);
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
        $curling->resStr = json_decode($result,true);
        $outValue = $curling->resStr;
        //ArrayHelper::setValue($outValue, 'domains', 'id' => ArrayHelper::getValue($outValue, 'domains'));
        for($i=0;$i<count($outValue['domains']);$i++){
            $outValue['domains'][$i]['id'] = $i;
        }
        return $outValue;
    }
    
     public Function getDomainsListModel()
    {
        $curling = Yii::$app->mydomain;
        $data=array();
        $result = $curling->doCurl($data ,'listDomains');
        $models=array();
        $curling->resStr = json_decode($result,true);
        if(ArrayHelper::keyExists('domains', $curling->resStr,false)){
                foreach($curling->resStr['domains'] as $i=>$list){
                $models[$i]=new Dnslist();
                $models[$i]->domainName = ArrayHelper::getValue($list,'domainName');
                $models[$i]->locked = ArrayHelper::getValue($list,'locked');
                $models[$i]->autorenewEnabled = ArrayHelper::getValue($list,'autorenewEnabled');           
                $models[$i]->expireDate = ArrayHelper::getValue($list,'expireDate');
                $models[$i]->createDate =ArrayHelper::getValue($list,'createDate');
            }   
        }
        return $models;
    }
    public function confirmDomainInList($domainName)
    {
        $mylist = $this->getDomainsList();
        $domainNameListArr = ArrayHelper::getColumn($mylist['domains'],'domainName');
        return ArrayHelper::isIn($domainName,$domainNameListArr);
    }

    public function getListRecords($thedomain)
    {
        $data= array();
        $curling = Yii::$app->mydomain;
        $result = $curling->doCurl($data ,'records',$thedomain);
        $curling->resStr=json_decode($result,true);
        
        return $curling->resStr;
    }

}
