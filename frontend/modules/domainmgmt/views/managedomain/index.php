<?php
//@import::using('yii\bootstrap\ActiveForm');

use yii\helpers\Url;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;



/* @var $this yii\web\View */
$this->title='Manage Domains';
$this->params['breadcrumbs'][]= ['label' => Yii::t('app', $this->title)];

?>
<h1><?= html::encode(Yii::t("app",$this->title))  ?></h1>

<div>
    <div>
        <?php $form = ActiveForm::begin(['id'=>'manage-domain','method'=>'post', 'action'=>Url::to(['index'])]); ?>
        <div class="row">
            <div class="col-xs-8">
        <div class="compactRadioGroup ">
            <?= $form->field($myoptn, 'trxoptn')->radioList([1=>'Check Availability',2=>'Search',6=>'Show Details',7=>'Transfer Domain', 8=>'List DNS Records'],['id'=>'trxOptn'])->label('<h3>I want to: </h3>') ?>
            
        </div>
            </div>
        <div class="col-xs-2">
            <br><br>&nbsp;&nbsp;<?= Html::a(Yii::t("app","List All Domains"),Url::to(['list-domains']),['class'=>'btn btn-warning'])?>
        </div>
    </div>
</div>
<div class='row'>
    <div class="col-sm-12 col-md-8">
    <?= $form->field($myoptn, 'domain')->textInput() ?>
    </div>


    <div class="col-xs-4 ">
        <p></p><p></p><?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'submitBtn', 'id'=>'submitBtn']) ?>
        
    </div>
</div>
<?php ActiveForm::end(); ?>
    </div>
</div>
