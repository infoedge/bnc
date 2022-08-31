<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title="Domain Details";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['/domainmgmt/managedomain/index']];
$this->params['breadcrumbs'][]= ['label' => Yii::t('app', $this->title)];
?>
<h1><?= html::encode($this->title)?></h1>
<div>
<?php $form = ActiveForm::begin(['id'=>'domain-details']); ?>
    <!-- buttons -->
    <div class='row domheader'>
    <div class="container text-center">
    <div class='action_btns'>
    
    <input type='submit' name='chgContacts' id='chgContacts' class='btn btn-warning' value='Change Contact Details'  />
    <input type='hidden' name='chgRegDtlsCnt' id='chgRegDtlsCnt' value=0 />
    <input type='submit' name='renewBtn' id='renewBtn' class='btn btn-success' value='Renew Domain' />
    <input type='submit' name='chgNameSvrBtn' id='chgNameSvrBtn' class='btn btn-primary' value='Change Name Servers' disabled='disabled'/>
    <input type='hidden' name='chgNameSvrCnt' id='chgNameSvrCnt' value=0 />
    <input type='submit' name='transferOutBtn' id='transferOutBtn' class='btn btn-danger' value='Transfer Out' />
    
    </div>
    <?php if($errmsg==0){ ?>
        <div class='domdet'>
    <div>
        
        <?= $this->render('_displayDomDetails', [
             'resStr'=>$resStr,
            'appArr' => $appArr,
        ]) ?>
    </div>
    
    <div>
        <?= $this->render('_displayContacts', [
             'resStr'=>$resStr,
             'appArr' => $appArr,
        ]) ?>
    </div> 
        </div>
    <?php }  ?>     
</div></div><br>
<?php ActiveForm::end(); ?>
</div>
