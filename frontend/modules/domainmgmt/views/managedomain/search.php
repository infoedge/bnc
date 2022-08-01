<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title='Search For Domain';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['index']];
$this->params['breadcrumbs'][]=Yii::t('app', $this->title);
?>
<h1><?= html::encode($this->title) ?></h1>

<div>
    <?php $form = ActiveForm::begin(['id' => 'search-form', 'method'=>'post', 'action'=> Url::to(["search"]) ]); ?>
        
        <?= $this->render('_showavailabledomains', [
            'resStr'=>$resStr,
            'appArr'=>$appArr,
            'regcnt'=>$regcnt,
        ]) ?>
    <?php ActiveForm::end(); ?>
</div>
