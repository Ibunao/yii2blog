<?php
namespace common\widgets\chat;
/**
 * 留言板组件
 */
use Yii;
use yii\base\Object;
use yii\bootstrap\Widget;
use frontend\models\FeedForm;

/**
* 留言板组件
*/
class ChatWidget extends Widget
{
	public function run()
	{
		$feed = new FeedForm();
		$data['feed'] = $feed->getList();
		return $this->render('index', ['data'=>$data]);
	}
}