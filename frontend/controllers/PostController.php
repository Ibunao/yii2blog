<?php
namespace frontend\controllers;

use Yii;
use frontend\controllers\base\BaseController;
use frontend\models\PostForm;
use common\models\CatModel;

/**
* 文章控制器
*/
class PostController extends BaseController
{
	//类似于写了一个actionUpload方法
	public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
            'class' => 'common\widgets\ueditor\UeditorAction',
            'config'=>[
                //上传图片配置
                'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            ]
        ]
        ];
    }
	/**
	 * 文章类表页面
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		// echo Yii::$app->params['ding'];exit;
		return $this->render('index');
	}
	/**
	 * 创建文章的表单
	 */
	public function actionCreate()
	{
		$model = new PostForm();
		$cats = CatModel::getAllCats();//获取分类
		return $this->render('create',['model'=>$model, 'cats'=>$cats]);
	}
}