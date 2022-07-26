<?php
//@import::using('yii\bootstrap\ActiveForm');

use yii\helpers\Url;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;



/* @var $this yii\web\View */
$this->title='Domain Management';
?>
<h1>Manage Domains</h1>
<h4><?= (!empty(Yii::$app->session['domain']))? 'Domain: '.Yii::$app->session['domain']:''; ?></h4>
<h4><?= (!empty($trxoptn))?'You have picked option '.$trxoptn :''; ?></h4>
<div>
    <div>
    <?php $form = ActiveForm::begin(); ?>

<?= $form->field($myoptn, 'trxoptn')->radioList([1=>'Check Availability',2=>'search',6=>'show Details',7=>'Transfer Domain In'])->label('<h3>I want to: </h3>') ?>
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
