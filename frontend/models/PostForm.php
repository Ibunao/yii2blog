<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use yii\db\Query;
use common\models\PostsModel;
use common\models\RelationPostTagsModel;
use common\models\PostExtendModel;
/**
* 文章表单模型
*/
class PostForm extends Model
{
	/**
	 * 定义场景
	 * SCENARIOS_CREATE创建场景
	 * SCENARIOS_UPDATE更新场景
	 * @var [type]
	 */
	const SCENARIOS_CREATE = 'create';
	const SCENARIOS_UPDATE = 'update';

	/**
	 * 定义事件
	 * EVENT_AFTER_CREATE 创建之后的事件
	 * EVENT_AFTER_UPDATE 更新之后的事件
	 */
	const EVENT_AFTER_CREATE = 'eventAfterCreate';
	const EVENT_AFTER_UPDATE = 'eventAfterUpdate';

	public $id;
	public $title;
	public $content;
	public $label_img;//标签图
	public $cat_id;//分类
	public $tags;//标签

	public $_lastError = '';

	/**
	 * 重写场景的方法
	 * 定义每个场景使用到的字段,每个场景限制了只能改变定义的这些属性的值，其他的属性不能更改
	 * 这个里面，两个场景一样
	 */
	public function scenarios()
	{
		$scenarios = [
			self::SCENARIOS_CREATE =>['title','content','label_img','cat_id','tags'],
			self::SCENARIOS_UPDATE =>['title','content','label_img','cat_id','tags'],
		];
		return array_merge(parent::scenarios(),$scenarios);
	}
	public function rules()
	{
		return [
			[['id', 'title', 'content', 'cat_id'], 'required'],
			[['id', 'cat_id'], 'integer'],
			['title', 'string', 'min'=>4, 'max'=>50],//最短4，最长50
		];
	}

	public function attributeLabels()
	{
		return [
			'id'=>'编码',
			'title'=>'标题',
			'content'=>'内容',
			'label_img'=>'标签图',
			'tags'=>'标签',
		];
	}
	/**
	 * 创建文章
	 */
	public function create()
	{
		//yii事务
		$transaction = Yii::$app->db->beginTransaction();
		// try{
			$model = new PostsModel();
			//将值快速复制给model对象的相应属性
			//$this->attributes获取属性及值，其实就是$this->getAttributes();
			$model->setAttributes($this->attributes);//将form中定义的字段值(指定场景的)全部加在到AR模型中

			//添加需要额外添加的值
			$model->summary = $this->_getSummary();//取文章摘要
			//取当前登录用户的信息，和user表对应
			$model->user_id = Yii::$app->user->identity->id;//取当前登录用户的id
			$model->user_name = Yii::$app->user->identity->username;//取当前登录用户的username
			$model->created_at = time();
			$model->updated_at = time();
			$model->is_valid = PostsModel::IS_VALID;
			//保存
			if (!$model->save()) {
				throw new \Exception('文章保存失败');//抛出异常
			}
			//添加成功，保存当前记录id
			$this->id = $model->id;

			//调用事件
			//model的属性数组覆盖this的属性数组，保证数据会更全一点
			$data = array_merge($this->getAttributes(), $model->getAttributes());
			$this->_eventAfterCreate($data);

			$transaction->commit();//提交事务
			return true;
		// }catch(\Exception $e){
		// 	$transaction->rollBack();//事务回滚
		// 	$this->_lastError = $e->getMessage();
		// 	return false;
		// }
	}

	/**
	 * 截取文章摘要
	 * @param  integer $s    开始位置
	 * @param  integer $e    结束位置
	 * @param  string  $char 字符编码
	 * @return [type]        [description]
	 */
	private function _getSummary($s = 0, $e = 90, $char = 'utf-8')
	{
		if (empty($this->content)) {
			return null;
		}
		//过滤掉标签,并截取
		return (mb_substr(str_replace('&nbsp;','', strip_tags($this->content)), $s, $e, $char));
		
	}
	/**
	 * 文章创建后触发的事件
	 * @return [type] [description]
	 */
	public function _eventAfterCreate($data)
	{
		//事件绑定，绑定this的_eventAddTag方法
		$this->on(self::EVENT_AFTER_CREATE, [$this, '_eventAddTag'], $data);

		//触发事件
		$this->trigger(self::EVENT_AFTER_CREATE);
	}
	/**
	 * 添加标签
	 * @return [type] [description]
	 */
	public function _eventAddTag($event)
	{
		//保存标签
		$tag = new TagForm();
		$tag->tags = $event->data['tags'];
		$tagIds = $tag->saveTags();

		//删除原先文章和标签的关联关系
		RelationPostTagsModel::deleteAll(['post_id' => $event->data['id']]);

		//批量保存文章与标签的关系
		if (!empty($tagIds)) {
			foreach ($tagIds as $k => $id) {
				$row[$k]['post_id'] = $this->id;
				$row[$k]['tag_id'] = $id;
			}
			//批量插入
			$res = (new Query())->createCommand()
				->batchInsert(RelationPostTagsModel::tableName(),['post_id', 'tag_id'], $row)
				->execute();
			if (!$res) {
				throw new \Exception("关联关系保存失败");
			}
		}
	}

	/**
	 * 通过id获取相应的数据
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getViewById($id)
	{
		$res = PostsModel::find()
			->with('relate.tag', 'extend')//关联表 通过relation_post_tags表关联tags表，分别在PostsModel类中和RelationPostTagsModel中定义了getRelate和getTag方法 ,关联post_extends表
			->where(['id' => $id])
			->asArray()
			->one();
		if (!$res) {
			//抛出404页面
			throw new NotFoundHttpException("文章不存在");
		}
		// var_dump($res);
		//处理标签格式
		$res['tags'] = [];
		if (isset($res['relate']) && !empty($res['relate'])) {
			foreach ($res['relate'] as $list) {
				$res['tags'][] = $list['tag']['tag_name'];
			}
		}
		unset($res['relate']);
		return $res;
	}
	/**
	 * 文章列表组件获取文章列表
	 * @param  array  $cond     查询条件
	 * @param  integer $curPage  当前页
	 * @param  integer $pageSize 显示大小
	 * @param  array   $orderBy  排序规则
	 * @return [type]            [description]
	 */
	public static function getList($cond, $curPage = 1, $pageSize = 5, $orderBy = ['id'=>SORT_DESC])
	{
		$model = new PostsModel;
		//查询语句
		$select = ['id', 'title', 'summary', 'label_img', 'cat_id', 'user_id', 'user_name', 'is_valid', 'created_at', 'updated_at'];
		$query = $model->find()
			->select($select)
			->where($cond)
			->with('relate.tag', 'extend')
			->orderBy($orderBy);

		//获取分页数据
		$res = $model->getPages($query, $curPage, $pageSize);
		//格式化
		$res['data'] = self::_formatList($res['data']);
		return $res;
	}
	private static function _formatList($data)
	{
		foreach ($data as &$list) {
			$list['tags'] = [];
			if (isset($list['relate']) && !empty($list['relate'])) {
				foreach ($list['relate'] as $lt) {
					$list['tags'][] = $lt['tag']['tag_name'];
				}
			}
			unset($list['relate']);
		}
		return $data;
	}
}