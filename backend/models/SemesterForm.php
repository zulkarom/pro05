<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class SemesterForm extends Model
{
    public $semester_id;
	public $action;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['semester_id'], 'integer'],
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'semester_id' => 'Pilih Semester',
        ];
    }

}
