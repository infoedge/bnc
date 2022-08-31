<?php
//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title="Confirm Registration";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['/domainmgmt/managedomain/index']];
// get previous url
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['/domainmgmt/managedomain/index']];
$this->params['breadcrumbs'][]= ['label' => Yii::t('app', $this->title)];
?>
<h1><?= html::encode ($this->title)?></h1>

<div>
    <?php $form = ActiveForm::begin(['id'=>'confirm-registration']); ?>
        
        <?= $this->render('_confirmreg', [
            // 'resStr'=>$resStr,
            // 'appArr'=>$appArr,
            // 'regcnt'=>$regcnt,
            'chkIds'=>$chkIds,
            'totPrice'=>$totPrice,
        ]) ?>
    <?php ActiveForm::end(); ?>
</div>
