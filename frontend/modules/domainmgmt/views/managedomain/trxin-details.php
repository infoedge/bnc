<?php
//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title = "Transfer Domain In";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['/domainmgmt/managedomain/index']];
$this->params['breadcrumbs'][]= ['label' => Yii::t('app', $this->title)];
?>
<h1><?= Html::encode($this->title) ?></h1>
<h3>Domain: <?= $domain ?></h3>
<div >
<?php $form = ActiveForm::begin() ?>
    <div >
        
            <div class="row"> 
            <span id='tfr_Area'>
            <!-- <span id="auth_code"> -->
            <p ><strong>To transfer a domain name in, there are a few requirements to be met namely:-</strong>
                <ul><li>The domain name must have been registered within the last 60 days.</li>
                    <li>The domain name must NOT have been transferred within the last 60 days.</li>
                    <li>The domain name must be unlocked at the current registrar.</li>
                    <li>You will need to get the domain name's transfer authorization/EPP code from the current registrar.</li>
                    </ul>
                    
                </p>
                
            <!-- </span> -->
            </span>
</div>
        
    <div class="row align-items-center">
    <div class="col">
                Enter Authorization/EPP Code &nbsp;<input type="text" id="eppcode" name="eppcode" title="EPP Code">
    </div>
    
        <div class="col">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'Transfer', 'id'=>'submitBtn']) ?>
        </div>
    </div> 
    <?php $form = ActiveForm::end() ?>
</div>
