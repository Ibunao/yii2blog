<?php
namespace frontend\models;

use yii\base\Model;
use common\models\TagsModel;
/**
* 标签的表单模型
*/
class TagForm extends Model
{
	
	public $id;
	public $tags;

	public function rules()
	{
		return [
			['tags', 'required'],
			['tags', 'each', 'rule'=>['string']],//遍历它，遍历的值为字符串
		];
	}

	/**
	 * 保存标签集合
	 * @return [type] [description]
	 */
	public function saveTags()
	{
		$ids = [];
		if (!empty($this->tags)) {
			foreach ($this->tags as $tag) {
				$ids[] = $this->_saveTag($tag);
			}
		}

		return $ids;
	}
	/**
	 * 保存单个标签
	 * @return [type] [description]
	 */
	private function _saveTag($tag)
	{
		$model = new TagsModel();
		$res = $model->find()
			->where(['tag_name' => $tag])
			->one();

		if (!$res) {
			//新建
			$model->tag_name = $tag;
			$model->post_num = 1;
			if (!$model->save()) {
				throw new \Exception('保存标签失败');
			}
			return $model->id;
		}else{
			//更新post_num字段,post_num字段增加 1，保存
			$res->updateCounters(['post_num'=>1]);
		}
		return $res->id;
	}
}