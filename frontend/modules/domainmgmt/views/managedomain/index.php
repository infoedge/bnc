<?php
//@import::using('yii\bootstrap\ActiveForm');

use yii\helpers\Url;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

use frontend\assets\AppAsset;
AppAsset::register($this);

//\frontend\assets\AppAsset::register($this);

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
            <?= $form->field($myoptn, 'trxoptn')->radioList([1=>'Check Availability',2=>'Search',6=>'Show Details',7=>'Transfer Domain', 8=>'List DNS Records'/*, 9=>'List all Domains'*/],['id'=>'trxOptn','name'=>'trxOptn'])->label('<h3>I want to: </h3>') ?>
            
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


    <div class="col-sm-2 ">
        <p></p><p></p><?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block', 'name' => 'submitBtn', 'id'=>'submitBtn']) ?>
        
    </div>
</div>
<?php ActiveForm::end(); ?>
    </div>
<?php   
$script = <<<JS
$(document).ready(function(){
        //alert('Looking at JS in Index!');
    $('input[type=radio][name="trxOptn"]').change(function(){
         //alert('Looking at JS in Index!');
        //var myoptn=$('input[name="trxOptn":checked]').val();
        var myoptn = $('input[type=radio][name="trxOptn"]:checked').val();
        //alert('Option ' + myoptn + ' has been chosen' );
        //switch( myoptn ) {
            if( myoptn == 1 ) {/* check-availability*/
                $("#options-domain").prop('placeholder',"Enter upto 50 comma seperated possible domains. e.g. xyz.com, abc.org, ....");
                $("#submitBtn").html("Check Domain Avaiability");
                }
            else if( myoptn == 2 ) {/* search */
                $("#options-domain").prop('placeholder','Enter comma seperated keywords for your domain e.g. space, cat, geranium, ....');
                $("#submitBtn").html("Search for a Domain");
                }
            else if( myoptn == 6 ) { /* show details */
                $("#options-domain").prop('placeholder','Enter a valid domain. e.g. abcxyz.com');
                $("#submitBtn").html("Show Domain Details");
                }
            else if( myoptn ==  7 ) { /* transfer domain */
                $("#options-domain").prop('placeholder','Enter a valid domain. e.g. abcxyz.com');
                $("#submitBtn").html("Transfer a Domain In");
                }
            else if( myoptn ==  8 ) { /* List DNS Records */
                $("#options-domain").prop('placeholder','Enter a valid domain. e.g. abcxyz.com');
                $("#submitBtn").html("List DNS Records");
                }
//             else if( myoptn ==  9 ) { /* List All Domains */
//                 $("#options-domain").prop('placeholder','Enter a valid domain. e.g. abcxyz.com');
//                 $("#submitBtn").html("List All Domains");
//                 }
            else {
                $("#submitBtn").html("Submit");
                }
        
    });
});
JS;
$this->registerJs($script);
?>
</div>
