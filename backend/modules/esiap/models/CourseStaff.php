<?php

namespace backend\modules\esiap\models;

use Yii;
use backend\modules\staff\models\Staff;


/**
 * This is the model class for table "sp_course_staff".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property int $staff_id
 * @property string $updated_at
 * @property int $staff_order
 */
class CourseStaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_course_staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
            [['crs_version_id', 'staff_id', 'staff_order'], 'integer'],
            [['updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crs_version_id' => 'Crs Version ID',
            'staff_id' => 'Staff Name',
            'updated_at' => 'Updated At',
            'staff_order' => 'Staff Order',
        ];
    }
	
	public function getStaff(){
		return $this->hasOne(Staff::className(), ['id' => 'staff_id'])->orderBy('id ASC');
	}
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }

	
}
