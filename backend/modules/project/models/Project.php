<?php

namespace backend\modules\project\models;

use Yii;
use common\models\Application;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $pro_name
 * @property string $date_start
 * @property string $date_end
 * @property string $location
 * @property int $course_id
 * @property int $semester_id
 * @property string $collaboration
 * @property string $purpose
 * @property string $background
 * @property string $pro_time
 * @property string $pro_target
 * @property string $agency_involved
 * @property int $prepared_by
 * @property int $fasi_id
 * @property int $supported_by
 * @property int $approved_by
 * @property string $approval_note
 * @property string $approved_at
 * @property string $created_at
 * @property string $supported_at
 * @property string $updated_at
 *
 * @property ProExpBasic[] $proExpBasics
 * @property ProExpRent[] $proExpRents
 * @property ProExpTool[] $proExpTools
 * @property ProObjective[] $proObjectives
 * @property ProResource[] $proResources
 * @property ProTtfDay[] $proTtfDays
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'created_at', 'pro_token'], 'required', 'on' => 'fasi-create'],
			
			[['pro_name', 'pro_token', 'application_id', 'location', 'collaboration', 'purpose', 'background', 'pro_target', 'agency_involved', 'updated_at'], 'required', 'on' => 'update-main'],
			
			[['updated_at'], 'required', 'on' => 'update'],
			
            [['date_start', 'date_end', 'approved_at', 'created_at', 'supported_at', 'updated_at'], 'safe'],
			
            [['application_id', 'prepared_by', 'supported_by', 'approved_by'], 'integer'],
			
            [['purpose', 'background', 'approval_note'], 'string'],
			
            [['pro_name', 'location', 'collaboration', 'pro_time', 'pro_target', 'agency_involved'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'pro_token' => 'Token',
            'pro_name' => 'Tajuk Kertas Cadangan',
            'date_start' => 'Tarikh Mula',
            'date_end' => 'Tarikh Akhir',
            'location' => 'Lokasi Program',
            'collaboration' => 'Dengan Kerjasama',
            'purpose' => 'Tujuan',
            'background' => 'Pengenalan / Latar Belakang',
            'pro_time' => 'Masa',
            'pro_target' => 'Kumpulan Sasaran',
            'agency_involved' => 'Agensi yang terlibat',
            'prepared_by' => 'Prepared By',
            'supported_by' => 'Supported By',
            'approved_by' => 'Approved By',
            'approval_note' => 'Approval Note',
            'approved_at' => 'Approved At',
            'created_at' => 'Created At',
            'supported_at' => 'Supported At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function getApplication()
    {
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseBasics()
    {
        return $this->hasMany(ExpBasic::className(), ['pro_id' => 'id'])->orderBy('exp_order ASC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseRents()
    {
        return $this->hasMany(ExpRent::className(), ['pro_id' => 'id'])->orderBy('exp_order ASC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseTools()
    {
        return $this->hasMany(ExpTool::className(), ['pro_id' => 'id'])->orderBy('exp_order ASC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectives()
    {
        return $this->hasMany(Objective::className(), ['pro_id' => 'id'])->orderBy('obj_order ASC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        return $this->hasMany(Resource::className(), ['pro_id' => 'id'])->orderBy('rs_order ASC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTentativeDays()
    {
        return $this->hasMany(TentativeDay::className(), ['pro_id' => 'id']);
    }
}
