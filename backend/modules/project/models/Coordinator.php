<?php

namespace backend\modules\project\models;

use Yii;
use common\models\ApplicationGroup;
use backend\models\Course;
use common\models\Fasi;

/**
 * This is the model class for table "pro_coor".
 *
 * @property int $id
 * @property int $semester_id
 * @property int $fasi_id
 * @property int $course_id
 * @property int $group_id
 * @property string $created_at
 */
class Coordinator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_coor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['semester_id', 'fasi_id', 'course_id', 'group_id', 'created_at'], 'required'],
			
            [['semester_id', 'fasi_id', 'course_id', 'group_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'semester_id' => 'Semester',
            'fasi_id' => 'Penyelaras',
            'course_id' => 'Kursus',
            'group_id' => 'Kelas',
            'created_at' => 'Created At',
        ];
    }
	
	public function getFasi()
    {
        return $this->hasOne(Fasi::className(), ['id' => 'fasi_id']);
    }
	
	public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
	
	public function getGroup()
    {
        return $this->hasOne(ApplicationGroup::className(), ['id' => 'group_id']);
    }

}
