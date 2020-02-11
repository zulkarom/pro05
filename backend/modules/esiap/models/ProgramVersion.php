<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_program_version".
 *
 * @property int $id
 * @property int $program_id
 * @property string $version_name
 * @property int $status
 * @property int $plo_num
 * @property int $is_developed
 * @property int $is_published
 * @property int $trash
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $prepared_by
 * @property string $prepared_at
 * @property int $verified_by
 * @property string $verified_at
 * @property string $faculty_approve_at
 * @property string $senate_approve_at
 */
class ProgramVersion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_program_version';
    }
	
	public function getDefaultPloNumber(){
		return 8;
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			
			[['program_id', 'version_name', 'created_by', 'created_at', 'is_developed', 'plo_num'], 'required', 'on' => 'create'],
			
			[['program_id', 'version_name', 'updated_at', 'is_developed', 'plo_num', 'is_published'], 'required', 'on' => 'update'],
			
			
			
            [['program_id', 'status', 'plo_num', 'is_developed', 'is_published', 'trash', 'created_by', 'prepared_by', 'verified_by'], 'integer'],
            [['created_at', 'updated_at', 'prepared_at', 'verified_at', 'faculty_approve_at', 'senate_approve_at'], 'safe'],
            [['version_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'program_id' => 'Program ID',
            'version_name' => 'Version Name',
            'status' => 'Status',
            'plo_num' => 'Plo Num',
            'is_developed' => 'Is Developed',
            'is_published' => 'Is Published',
            'trash' => 'Trash',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'prepared_by' => 'Prepared By',
            'prepared_at' => 'Prepared At',
            'verified_by' => 'Verified By',
            'verified_at' => 'Verified At',
            'faculty_approve_at' => 'Faculty Approve At',
            'senate_approve_at' => 'Senate Approve At',
        ];
    }
	
	public function getVersionType(){
        return $this->hasOne(VersionType::className(), ['id' => 'version_type_id']);
    }
	
	public function getPloNumber(){
		return $this->versionType->plo_num;
	}
	
	public function pageHeader(){
		return '<div class="row">
		<div class="col-md-9"><h4>' . $this->program->pro_name . '<br />
		<i>' . $this->program->pro_name_bi . '</i></h4></div>
		<div class="col-md-3"><span style="margin-top:10px"><b>Version:</b>' . $this->version_name . '<br />
		<b>PLO:</b>' . $this->ploNumber .' Domains</span></div>
		
		
		
		</div>
		<br />';
	}
	
	private function yesNoLabel($field){
		$status = '';
		switch($field){
			case 1:
			$status = 'YES';
			$color = 'success';
			break;
			
			case 0:
			$status = 'NO';
			$color = 'danger';
			break;
		}
		return '<span class="label label-'.$color.'">' . $status . '</span>';
	}
	
	public function getPloNumberArray(){
		$array = array();
		for($i=1;$i<=12;$i++){
			$array[$i] = $i;
		}
		return $array;
	}
	
	public function getProgram(){
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }
	
	public function getLabelPublished(){
		return $this->yesNoLabel($this->is_published);
	}
	
	public function getLabelActive(){
		return $this->yesNoLabel($this->is_developed);
	}
	
	public function getLabelStatus(){
		$arr = $this->statusArray;
		$status = '';
		switch($this->status){
			case 0:
			$status = 'DRAFT';
			$color = 'default';
			break;
			
			case 10:
			$status = 'SUBMITTED';
			$color = 'info';
			break;
			
			case 20:
			$status = 'VERIFIED';
			$color = 'success';
			break;
		}
		return '<span class="label label-'.$color.'">' . $status . '</span>';
	}
	
	public function getStatusArray(){
		return [0=>'DRAFT', 10=>'SUBMITTED', 20 => 'VERIFIED'];
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
