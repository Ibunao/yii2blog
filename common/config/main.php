<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //url美化配置
        'urlManager' => [
            'enablePrettyUrl' => true,//开启美化
            'showScriptName' => false,//关闭脚本文件
            // 'suffix' => '.html',//添加后缀
        ],
    ],
];
