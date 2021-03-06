<?php
namespace common\widgets\tag;
/**
 * 标签云组件
 */
use Yii;
use yii\bootstrap\Widget;
use yii\base\Object;
use common\models\PostExtendModel;
use common\models\PostModel;
use yii\db\Query;
use common\models\TagsModel;

class TagWidget extends Widget
{
    public $title = '';
    
    public $limit = 20;
    
    public function run()
    {
        $res = TagsModel::find()
            ->orderBy(['post_num'=>SORT_DESC])
            ->limit($this->limit)
            ->all();
        
        $result['title'] = $this->title?:'标签云';
        $result['body'] = $res?:[];
        
        return $this->render('index',['data'=>$result]);
    }
  
    
}