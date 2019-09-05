<?php

namespace backend\modules\project\models;

use Yii;

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
            [['pro_name', 'application_id', 'created_at', 'pro_token'], 'required', 'on' => 'fasi-create'],
			
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
            'pro_name' => 'Nama Projek',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'location' => 'Location',
            'course_id' => 'Course ID',
            'semester_id' => 'Semester ID',
            'collaboration' => 'Collaboration',
            'purpose' => 'Purpose',
            'background' => 'Background',
            'pro_time' => 'Pro Time',
            'pro_target' => 'Pro Target',
            'agency_involved' => 'Agency Involved',
            'prepared_by' => 'Prepared By',
            'fasi_id' => 'Fasi ID',
            'supported_by' => 'Supported By',
            'approved_by' => 'Approved By',
            'approval_note' => 'Approval Note',
            'approved_at' => 'Approved At',
            'created_at' => 'Created At',
            'supported_at' => 'Supported At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProExpBasics()
    {
        return $this->hasMany(ProExpBasic::className(), ['pro_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProExpRents()
    {
        return $this->hasMany(ProExpRent::className(), ['pro_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProExpTools()
    {
        return $this->hasMany(ProExpTool::className(), ['pro_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProObjectives()
    {
        return $this->hasMany(ProObjective::className(), ['pro_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProResources()
    {
        return $this->hasMany(ProResource::className(), ['pro_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProTtfDays()
    {
        return $this->hasMany(ProTtfDay::className(), ['pro_id' => 'id']);
    }
}
