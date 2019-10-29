<?php

namespace backend\modules\project\models;

use Yii;
use yii\base\Model;

class ProjectAllocationBatch extends Model
{
	public $batch_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			 [['batch_name'], 'required'],
		
        ];
    }
}
