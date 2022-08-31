<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Domregtypesarr */

$this->title = 'Create Domregtypesarr';
$this->params['breadcrumbs'][] = ['label' => 'Domregtypesarrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domregtypesarr-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
