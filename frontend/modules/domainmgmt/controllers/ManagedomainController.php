<?php

namespace app\modules\domainmgmt\controllers;

use Yii;
use common\models\Options;
use yii\web\Response;

class ManagedomainController extends \yii\web\Controller
{
    public $trxoptn=0;
    public function actionChkAvailability()
    {
        return $this->render('chk-availability');
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
                    return $this->redirect(['trx-details']);
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
        return $this->render('search');
    }

    public function actionShowDetails()
    {
        return $this->render('show-details');
    }

    public function actionTrxDetails()
    {
        return $this->render('trx-details');
    }

}
