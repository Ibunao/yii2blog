<?php
namespace common\widgets\post;

use yii\base\Widget;
use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use common\models\PostsModel;
use frontend\models\PostForm;
/**
* 自定义组件
* 文章列表组件
*/
class PostWidget extends Widget
{
	//文章列表标题
	public $title = '';
	//显示条数
	public $limit = 6;
	//是否显示更多
	public $more = true;
	//是否显示分页
	public $page =false;

	/**
	 * 实现组件的方法，外部可以通过PostWidget::widget(['page'=>true, 'limit'=>1])的方式调用
	 * @return [type] [description]
	 */
	public function run()
	{
		//获取页数，默认为1
		$curPage = Yii::$app->request->get('page', 1);
		//查询条件
		$cond = ['=', 'is_valid', PostsModel::IS_VALID];
		//查询数据
		$res = PostForm::getList($cond, $curPage, $this->limit);

		$result['title'] = $this->title?:'最新文章';
		$result['more'] = Url::to(['post/index']);
		$result['body'] = $res['data']?:[];
		//是否显示分页
		if ($this->page) {
			//为yii的分页插件定义参数
			$pages = new Pagination(['totalCount'=>$res['count'], 'pageSize'=>$res['pageSize'], ]);

			$result['page'] = $pages;
		}
		return $this->render('index', ['data'=>$result]);
	}
}