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
<?php   
$script = <<< JS
$(document ).ready(function (){
    $('#trxOptn').change(function(){
        var myoptn=$('input[id="trxOptn":checked]').val();
        alert('Option ' + myoptn + ' has been chosen' );
        switch(myoptn) {
            case 1:/* check-availability*/
                $('#options-domain').attr('placeHolder',"Enter upto 50 comma seperated possible domains. e.g. xyz.com, abc.org");
                $("#submitBtn").attr("value", "Check Domain Avaiability");
            case 2:/* */
                $("#options-domain").attr('placeholder','Enter comma seperated keywords for your domain e.g. space, cat, geranium');
                $("#submitBtn").attr("value", "Search for a Domain");
            
            case 6:
                $("#options-domain").attr('placeholder','Enter a valid domain. e.g. abcxyz.com');
                $("#submitBtn").attr("value", "Show Domain Details");
            
            case 7:
                $("#options-domain").attr('placeholder','Enter a valid domain. e.g. abcxyz.com');
                $("#submitBtn").attr("value", "Transfer a Domain In");
            default:
            
        }
    });
 });
JS;
    $this->registerJs($script);
?>
</div>