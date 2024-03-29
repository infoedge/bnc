<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title='List Records';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'DNS Management'), 'url' => ['index']];
$this->params['breadcrumbs'][]=Yii::t('app', $this->title);
?>
<h1><?= html::encode($this->title) ?></h1>

<div>
    <?php $form = ActiveForm::begin(['id' => 'list-records-form', 'method'=>'post', 'action'=> Url::to(["list-domains"]) ]); ?>
        <?=
            GridView::widget([
                'dataProvider'=> $provider,
                'columns'=>[
                    ['class'=>'yii\grid\SerialColumn'],
                    'domainName',
                    'host',
                        
                    'fqdn',
                    'type',
                    'answer',
                    'ttl',
                    'priority',

                    ['class' => 'yii\grid\ActionColumn',
                        'template'=> '{checkdetails}',// &nbsp;&nbsp;{salaryrecommendation}&nbsp;&nbsp;{salaryapproval}',
                        'header'=>'Action',
                        'headerOptions'=>['width'=>'80'],
                        'buttons'=>[
                            'checkdetails'=> function($url,$model){
                                    Url::remember();
                                    return Html::a( '<span class="glyphicon glyphicon-thumbs-up" id="chkDetails" title="Check Details" ></span>',  ['chkDetails']);
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
