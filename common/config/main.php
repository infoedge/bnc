<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mydomain' => [
            'class' => 'common\components\Mydomain',
        ],
        'validation' => [
            'class' => 'common\components\Validation',
        ],
        'validInput' => [
            'class' => 'common\components\Validinput',
        ],
        'appArray' => [
            'class' => 'common\components\Apparrays',
        ],
        'display' => [
            'class' => 'common\components\Display',
        ],
    ],
];
