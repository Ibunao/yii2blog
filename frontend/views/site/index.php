<?php

use common\widgets\banner\BannerWidget;
use yii\base\widget;
use common\widgets\chat\ChatWidget;
use common\widgets\post\PostWidget;

$this->title = '博客-首页';
?>
<div class="row">
    <div class="col-lg-9">
    <!-- 轮播组件 -->
        <?=BannerWidget::widget() ;?>
    </div>
    <div class="col-lg-3">
        222
    </div>
    <!-- 文章列表组件 -->
    <div class="col-lg-9">
        <?=PostWidget::widget() ;?>
    </div>
</div>