<?php
//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title="Registered Domains";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['/domainmgmt/managedomain/index']];
// get previous url
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['/domainmgmt/managedomain/index']];
$this->params['breadcrumbs'][]= ['label' => Yii::t('app', $this->title)];
?>
<div class="container text-center">
<h1><?= html::encode($this->title)?> </h1>         
</div>


<div>
    <?php $form = ActiveForm::begin(['id'=>'confirm-registration']); ?>
        
        <?= $this->render('_showRegisteredDomains', [

            'regArray'=>$regArray,
        ]) ?>
    <?php ActiveForm::end(); ?>
</div>
