<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sign-overlay"></div>
<div class="signpanel"></div>

<div class="panel signin">
    <div class="panel-heading">
        <h4 class="panel-title">欢迎登陆博客系统</h4>
    </div>
    <div class="panel-body">
      <button class="btn btn-primary btn-quirk btn-fb btn-block">联系我们</button>
      <div class="or">or</div>
		<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

		    <?= $form->field($model, 'username', [
		    	//配置显示的属性
		    	'inputOptions' =>[
		    		'placeholder' => '请输入账户',
		    	],
		    	//调整模板布局结构   {input}是表示input的内容的位置
		    	'template' =>
		    		'<div class="input-group">
		    			<span class="input-group-addon"><i class="fa fa-user"></i></span>{input}
		    		</div>'
		    	])->textInput(['autofocus' => true]) ?>

		    <?= $form->field($model, 'password', [
		    	//配置显示的属性
		    	'inputOptions' =>[
		    		'placeholder' => '请输入账户',
		    	],
		    	//调整模板布局结构   {input}是表示input的内容的位置  label(false)不显示label内容
		    	'template' =>
		    		'<div class="input-group">
		    			<span class="input-group-addon"><i class="fa fa-lock"></i></span>{input}
		    		</div>'
		    	])->passwordInput()->label(false) ?>

		    <?= $form->field($model, 'rememberMe')->checkbox() ?>

		    <div class="form-group">
		        <?= Html::submitButton('登陆', ['class' => 'btn btn-success btn-quirk btn-block', 'name' => 'login-button']) ?>
		    </div>

		<?php ActiveForm::end(); ?>
    </div>
</div><!-- panel -->
  