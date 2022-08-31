<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title='Transfer Domain Out';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['index']];
$this->params['breadcrumbs'][]=Yii::t('app', $this->title);
?>
<h1><?= html::encode($this->title) ?></h1>

<div>
    <?php $form = ActiveForm::begin(['id' => 'transfer-out-form', 'method'=>'post', 'action'=> Url::to(["transfer-out"]) ]); ?>
        
        <h4>Are you sure you want to tranfer domain <?= $model->domain ?> to another registrar? </h4>
        <p>
            <?= $form->field($model, 'confirmtrx')->radioList([0=>'No',1=>'Yes'],['id'=>'trxOut'])->label('Confirm Transfer?')?>>
            &nbsp;&nbsp;<?= Html::a(Yii::t("app","Transfer"),Url::to(['transfer-out']),['class'=>'btn btn-success'])?>
        </p>
    <?php ActiveForm::end(); ?>
</div>
