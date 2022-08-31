<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title='List Domains';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domain Management'), 'url' => ['index']];
$this->params['breadcrumbs'][]=Yii::t('app', $this->title);
?>
<h1><?= html::encode($this->title) ?></h1>
<?php //print_r($domainsList)?>
<div>
    <?php $form = ActiveForm::begin(['id' => 'list-domains-form', 'method'=>'post', 'action'=> Url::to(["list-domains"]) ]); ?>
        <?=
            GridView::widget([
                'dataProvider'=> $provider,
                'columns'=>[
                    ['class'=>'yii\grid\SerialColumn'],
                    //'id',
                    'domainName',
                    [                      
                        'attribute' =>'locked',
                        'filter' => [ 0 =>'No', 1=>'Yes',null=>'N/A'],
                    ],
                        
                    'autorenewEnabled',
                    [
                        'attribute'=>'createDate',
                        'format'=>['date','php:d-M-Y H:i'],
                    ],
                    [
                        'attribute'=>'expireDate',
                        'format'=>['date','php:d-M-Y H:i'],
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template'=> '{listdetails}',//nbsp;&nbsp;{salaryrecommendation}&nbsp;&nbsp;{salaryapproval}',
                        'header'=>'Action',
                        'headerOptions'=>['width'=>'80'],
                        //'format' => 'raw',
                        'buttons'=>[
                            'listdetails'=> function($url,$model){
                                    Url::remember();
                                    //return Html::a( '<span class="glyphicon glyphicon-thumbs-up" id="listDetails" title="Show Details" ></span>',  ['show-details','domain'=>$model['domainName']]);
                                    return Html::a( '<span class="btn btn-success" id="listDetails" title="Show Details" >Details</span>',  ['show-details','domain'=>$model['domainName']]);
                            },
                            // 'salaryapproval'=> function($url){
                            //         \yii\helpers\Url::remember();
                            //         return Html::a( '<span class="glyphicon glyphicon-certificate id="approveicon" title="Approve" ></span>',  $url);
                            // },
                        ],
                    ],
                ],

            ]);
        ?>
    <?php ActiveForm::end(); ?>
</div>
