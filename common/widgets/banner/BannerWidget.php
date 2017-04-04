<?php
namespace common\widgets\banner;

use yii\bootstrap\Widget;//继承bootstrap
use Yii;
use yii\helpers\Url;
use yii\data\Pagination;
use common\models\PostsModel;
use frontend\models\PostForm;
/**
* 自定义组件
* 轮播图组件
*/
class BannerWidget extends Widget
{
	public $items = [];

	/**
	 * 初始化设置，设置默认值
	 * @return [type] [description]
	 */
	public function init()
	{
		if (empty($this->items)) {
			//设置默认显示的图片
			$this->items = [
				[
					'label'=>'dome', 
					'image_url'=>'/statics/images/banner/b_0.jpg', 
					'url'=>['site/index'],
					'html'=>'',
					'active'=>'active',
				],
				[
					'label'=>'dome', 
					'image_url'=>'/statics/images/banner/b_1.jpg', 
					'url'=>['site/index'],
					'html'=>'',
					'active'=>'',
				],
				[
					'label'=>'dome', 
					'image_url'=>'/statics/images/banner/b_2.jpg', 
					'url'=>['site/index'],
					'html'=>'',
					'active'=>'',
				],
			];
			
		}
	}
	public function run()
	{
		$data['items'] = $this->items;
		return $this->render('index', ['data'=>$data]);
	}

}