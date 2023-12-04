<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules'=>[
        'gridview' => ['class' => 'kartik\grid\Module'],
         'formatter'=>[
                                      'class'=>'yii\i18n\formatter',
                                      'currencyCode'=>'$',

                                      ],
        'rbac' => [
            'class' => 'yii2mod\rbac\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
         'i18n' => [
            'translations' => [
                'yii2mod.user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/user/messages',
                ],
                'yii2mod.rbac' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/rbac/messages',
                ],
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
                // ...
            ],
        ],
    ],
];
