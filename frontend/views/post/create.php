<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = '创建';//设置页面title
$this->params['breadcrumbs'][] = ['label'=>'文章','url'=>['post/index']];//设置面包屑导航
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-lg-9">
		<div class="panel-title box-title">
			<span>创建文章</span>
		</div>
		<div class="panel-body">
			<!-- 使用表单组件生成表单 -->
			<?php $form = ActiveForm::begin() ?>
			<!-- 使用ActiveForm的小部件 -->
			<!--field($model,'title'),model中定义的title; ['maxlength'=>true]，true会匹配rules中定义的规则  -->
			<?=$form->field($model, 'title')->textinput(['maxlength'=>true]) ;?>
			<?=$form->field($model, 'cat_id')->dropDownList($cats);//['1'=>'分类1', '2'=>'分类2']) ;?><!--下拉列表-->
			<!-- widget(),加载自定义的小部件 -->
			<?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
			        'config'=>[
			        ]
			    ]) ?><!--上传图片-->

			<!-- 第三方插件，百度的ueditor,富文本编辑器 -->
			<?=$form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
				    'options'=>[
				        'initialFrameWidth' => 850,//宽度，不设置为100%
				        'initialFrameHeight' => 400,//高度，不设置为100%
				        // 'toolbars' = [] //配置需要使用的小功能按钮
				    ]]) ;?>
			<?=$form->field($model, 'tags')->widget('common\widgets\tags\TagWidget') ;?>

			<!-- 提交按钮 -->
			<div class="form-group">
				<?=Html::submitButton('发布', ['class'=>'btn btn-success']) ;?>
			</div>
			<?php ActiveForm::end() ?>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="panel-title box-title">
			<span>注意事项</span>
		</div>
		<div class="panel-body">
			<p>1.aaaaaaa</p>
			<p>2.bbbbbbb</p>
		</div>
	</div>
</div>