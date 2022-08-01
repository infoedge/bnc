<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title='Check Domain Availability';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['/domainmgmt/managedomain/index']];
$this->params['breadcrumbs'][]= ['label' => Yii::t('app', $this->title)];
?>
<h1><?= html::encode($this->title) ?></h1>

<div>
    <?php $form = ActiveForm::begin(['id'=>'check-availability-form']); ?>
        
        <?= $this->render('_showavailabledomains', [
            'resStr'=>$resStr,
            'appArr'=>$appArr,
            'regcnt'=>$regcnt,
        ]) ?>
    <?php ActiveForm::end(); ?>
</div>
