<?php

use yii\base\widget;
use common\widgets\banner\BannerWidget;
use common\widgets\chat\ChatWidget;
use common\widgets\post\PostWidget;
use common\widgets\hot\HotWidget;
use common\widgets\tag\TagWidget;

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
        <!-- 热门浏览组件 -->
        <?=HotWidget::widget() ;?>
        <!-- 标签云组件 -->
        <?=TagWidget::widget() ;?>
    </div>
</div>