<?php 

use common\widgets\post\PostWidget;
use yii\base\Widget;
?>
<div class="row contain">
	<div class="col-lg-9">
	<!-- 使用自定义组件,可以在括号内配置属性值 -->
		<?=PostWidget::widget(['page'=>true, 'limit'=>1]) ;?>
	</div>
	<div class="col-lg-3">
		ding
	</div>
</div>