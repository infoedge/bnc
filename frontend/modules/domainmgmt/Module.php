<?php

namespace app\modules\domainmgmt;

use Yii;
use frontend\modules\domainmgmt\assets\DomainAsset;

/**
 * domainmgmt module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\domainmgmt\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        //DomainAsset::register(Yii::$app->view);
        parent::init();

        // custom initialization code goes here
    }
}
