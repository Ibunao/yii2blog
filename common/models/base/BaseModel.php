<?php
namespace common\models\base;

/**
* 基本模型
*/
class BaseModel extends \yii\db\ActiveRecord
{
	/**
	 * 获取分页数据
	 * @param  query  $query    查询对象
	 * @param  integer $curPage  当前页
	 * @param  integer $pageSize 显示条数
	 * @param  array  $search   查询条件
	 * @return [type]            [description]
	 */
	public function getPages($query, $curPage = 1, $pageSize = 10, $search = null)
	{
		if ($search) {
			$query = $query->addFilerWhere($search);
		}
		$data['count'] = $query->count();
		if (!$data['count']) {
			return ['count'=>0, 'curPage'=>$curPage, 'pageSize'=>$pageSize, 'start'=>0, 'end'=>0, 'data'=>[]];
		}
		//不为空时
		//当前页,超过实际页数，不取curPage为当前页
		$curPage = (ceil($data['count']/$pageSize)<$curPage)?ceil($data['count']/$pageSize):$curPage;
		$data['curPage'] = $curPage;
		//每页显示条数
		$data['pageSize'] = $pageSize;
		//起始页
		$data['start'] = ($curPage-1)*$pageSize + 1;
		//末页
		$data['end'] = (ceil($data['count']/$pageSize) == $curPage)?$data['count']:($curPage-1)*$pageSize+$pageSize;
		$data['data'] = $query
			->offset(($curPage-1)*$pageSize)
			->limit($pageSize)
			->asArray()
			->all();
		return $data;
	}
}