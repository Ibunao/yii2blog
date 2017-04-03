<?php
namespace frontend\controllers;

use Yii;
use frontend\controllers\base\BaseController;
use frontend\models\PostForm;
use common\models\CatModel;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
* 文章控制器
*/
class PostController extends BaseController
{
	/**
	 * 行为过滤器，在执行动作action前和后会调用
	 * @return [type] [description]
	 */
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),//权限验证过滤器，配置登陆后才允许访问的action
                'only' => ['index', 'create', 'upload', 'ueditor'],//过滤的action  包括actions方法中定义的action
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],//表示不登陆可以访问
                    ],
                    [
                        'actions' => ['create', 'upload', 'ueditor'],
                        'allow' => true,
                        'roles' => ['@'],//登陆才可以访问
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),//请求方式过滤器 ，指定允许的请求方式
                'actions' => [
                    '*' => ['get', 'post'],//所有的action都可以用get和post进行访问
                    // 'create' => ['post'],
                ],
            ],
        ];
    }
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
		//定义场景
		$model->setScenario(PostForm::SCENARIOS_CREATE);
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if (!$model->create()) {
				//在页面头部位置生成一个现实错误信息的显示框，可以点×号关闭掉的
				Yii::$app->session->setFlash('warning', $model->_lastError);
			}else{
				//跳转页面
				return $this->redirect(['post/view', 'id'=>$model->id]);
			}
		}
		$cats = CatModel::getAllCats();//获取分类
		return $this->render('create',['model'=>$model, 'cats'=>$cats]);
	}
	/**
	 * 参数yii可以直接获取视图层通过get或post传递过来的对应参数
	 */
	public function actionView($id)
	{
		$model = new PostForm();
		$data = $model->getViewById($id);

		return $this->render('view', ['data' => $data]);
	}
}