<?php

use yii\base\widget;
use common\widgets\banner\BannerWidget;
use common\widgets\chat\ChatWidget;
use common\widgets\post\PostWidget;

$this->title = '博客-首页';
?>
<div class="row">
    <div class="col-lg-9">
        <!-- 轮播组件 -->
        <?=BannerWidget::widget() ;?>
        <!-- 文章列表组件 -->
        <?=PostWidget::widget() ;?>
    </div>
    <div class="col-lg-3">
        <!-- 留言板组件 -->
        <?=ChatWidget::widget() ;?>
    </div>
</div>