<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
// ??
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        // 使用自己定义语言包中的语言  common是语言包   Blog是要显示对应的词
        'brandLabel' => Yii::t('common','Blog'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $leftMenus = [
        //使用yii自定义的语言包
        ['label' => Yii::t('yii','Home'), 'url' => ['/site/index']],
        ['label' => '文章', 'url' => ['/site/about']],
       // ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
        //显示头像
        //将src参数配置在params文件中
            'label' => '<img src="'.Yii::$app->params['avatar']['small'].'" alt="'.Yii::$app->user->identity->username.'"> ',
            //添加的类
            'linkOptions'=>['class'=>'avatar'],
            //下拉列表
            'items'=>[
            //加入图标
                ['label'=>'<i class="fa fa-sign-out"></i> 退出','url'=>['/site/logout'],'linkOptions'=>['data-method'=>'post']],
                ['label'=>'个人中心']
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        //如果输出的是标签的代码，需要将编码关闭
        'encodeLabels'=>false,
        'items' => $menuItems,
    ]);
    //显示在左边导航栏
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenus,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
