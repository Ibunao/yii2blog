<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'zh-CN',//语言配置  语言包会根据这个进行选择对应的语言包
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
        //语言包配置 定义自己的语言包
        'i18n'=>[
        	'translations'=>[
        		'*' => [
        			// 引入语言包的配置类
        			'class'=>'yii\i18n\PhpMessageSource',
        			// 指向语言包的文件目录  相对于根目录 ，默认的可以不用写
        			// 'basePath' => '/messages',
        			'fileMap'=>[//fileMap 语言包指向文件，多个语言包都追加到这个数组中
        				'common' => 'common.php',
        			]
        			//文件地址如yii\advanced\frontend\messages\zh-CN\common.php
        		]
        	]
        ]
    ],
];
