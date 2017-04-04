<?php
namespace common\widgets\hot;
/**
 * 留言板组件
 */
use Yii;
use yii\base\Object;
use yii\bootstrap\Widget;
use common\models\PostExtendModel;
use common\models\PostsModel;
use yii\db\Query;

/**
* 热门浏览组件
*/
class HotWidget extends Widget
{
	public $title = '';
	public $limit = 6;
	public function run()
	{
		$res = (new Query)
			->select('a.browser browser, b.id id, b.title title')
			->from(['a'=>PostExtendModel::tableName()])
			->join('LEFT JOIN', ['b'=>PostsModel::tableName()], 'a.post_id = b.id')
			->where('b.is_valid = '. PostsModel::IS_VALID)
			->orderBy(['browser'=>SORT_DESC, 'id'=>SORT_DESC])
			->limit($this->limit)
			->all();

		$result['title'] = $this->title?:'热门浏览';
		$result['body'] = $res?:[];
		return $this->render('index',['data'=>$result]);
	}
}