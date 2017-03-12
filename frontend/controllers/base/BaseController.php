<?php
namespace frontend\controllers\base;
use yii\web\Controller;
/**
* 基础控制器
*/
class BaseController extends Controller
{
	public function beforeAction($action)
	{
		//?这是干嘛的？
		//如果父类返回了false则自己也返回false
		if (!parent::beforeAction($action)) {
			return false;
		}
		return true;
	}
}