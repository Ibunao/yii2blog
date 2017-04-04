<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class MemberController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
}