<?php

namespace backend\modules\esiap\models;

use backend\models\Department;
use Yii;

/**
 * This is the model class for table "sp_program".
 *
 * @property int $id
 * @property string $pro_name
 * @property string $pro_name_bi
 * @property string $program_code
 * @property int $pro_level 4=diploma,6=sarjana muda, 7=sarjana,8=phd
 * @property int $faculty_id
 * @property int $department_id
 * @property int $status 0=under development,1=offered
 * @property int $pro_cat
 * @property int $pro_field
 * @property int $grad_credit
 * @property string $prof_body
 * @property string $coll_inst
 * @property int $study_mode 1=coursework,2=mix,3=research
 * @property string $sesi_start
 * @property string $pro_sustain
 * @property int $full_week_long
 * @property int $full_week_short
 * @property int $full_sem_long
 * @property int $full_sem_short
 * @property int $part_week_long
 * @property int $part_week_short
 * @property int $part_sem_long
 * @property int $part_sem_short
 * @property string $full_time_year
 * @property string $full_max_year
 * @property string $part_max_year
 * @property string $part_time_year
 * @property string $synopsis
 * @property string $synopsis_bi
 * @property string $objective
 * @property string $just_stat
 * @property string $just_industry
 * @property string $just_employ
 * @property string $just_tech
 * @property string $just_others
 * @property string $nec_perjawatan
 * @property string $nec_fizikal
 * @property string $nec_kewangan
 * @property string $kos_yuran
 * @property string $kos_beven
 * @property string $pro_tindih_pub
 * @property string $pro_tindih_pri
 * @property string $jumud
 * @property string $admission_req
 * @property string $admission_req_bi
 * @property string $career
 * @property string $career_bi
 * @property int $trash
 */
class Program extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_program';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_name', 'pro_name_bi'], 'required'],
			
			[['pro_name', 'pro_name_bi', 'department_id', 'pro_cat', 'grad_credit', 'program_code', 'pro_level', 'study_mode'], 'required', 'on' => 'update'],
			
			
			
            [['pro_level', 'faculty_id', 'department_id', 'status', 'pro_cat', 'pro_field', 'grad_credit', 'study_mode', 'full_week_long', 'full_week_short', 'full_sem_long', 'full_sem_short', 'part_week_long', 'part_week_short', 'part_sem_long', 'part_sem_short', 'head_program', 'trash'], 'integer'],
			
            [['pro_sustain', 'synopsis', 'synopsis_bi', 'objective', 'just_stat', 'just_industry', 'just_employ', 'just_tech', 'just_others', 'nec_perjawatan', 'nec_fizikal', 'nec_kewangan', 'kos_yuran', 'kos_beven', 'pro_tindih_pub', 'pro_tindih_pri', 'jumud', 'admission_req', 'admission_req_bi', 'career', 'career_bi'], 'string'],
            [['full_time_year', 'full_max_year', 'part_max_year', 'part_time_year'], 'number'],
            [['pro_name', 'pro_name_bi', 'prof_body', 'coll_inst', 'sesi_start'], 'string', 'max' => 250],
            [['program_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pro_name' => 'Program Name (BM)',
            'pro_name_bi' => 'Program Name (EN)',
            'program_code' => 'Program Name Short Form',
            'pro_level' => 'Level',
            'faculty_id' => 'Faculty',
            'department_id' => 'Department',
            'status' => 'Offered',
            'pro_cat' => 'Program Category',
            'pro_field' => 'Pro Field',
            'grad_credit' => 'Graduation Credit',
            'prof_body' => 'Prof Body',
            'coll_inst' => 'Coll Inst',
            'study_mode' => 'Study Mode',
            'sesi_start' => 'Sesi Start',
            'pro_sustain' => 'Pro Sustain',
            'full_week_long' => 'Full Week Long',
            'full_week_short' => 'Full Week Short',
            'full_sem_long' => 'Full Sem Long',
            'full_sem_short' => 'Full Sem Short',
            'part_week_long' => 'Part Week Long',
            'part_week_short' => 'Part Week Short',
            'part_sem_long' => 'Part Sem Long',
            'part_sem_short' => 'Part Sem Short',
            'full_time_year' => 'Full Time Year',
            'full_max_year' => 'Full Max Year',
            'part_max_year' => 'Part Max Year',
            'part_time_year' => 'Part Time Year',
            'synopsis' => 'Synopsis',
            'synopsis_bi' => 'Synopsis Bi',
            'objective' => 'Objective',
            'just_stat' => 'Just Stat',
            'just_industry' => 'Just Industry',
            'just_employ' => 'Just Employ',
            'just_tech' => 'Just Tech',
            'just_others' => 'Just Others',
            'nec_perjawatan' => 'Nec Perjawatan',
            'nec_fizikal' => 'Nec Fizikal',
            'nec_kewangan' => 'Nec Kewangan',
            'kos_yuran' => 'Kos Yuran',
            'kos_beven' => 'Kos Beven',
            'pro_tindih_pub' => 'Pro Tindih Pub',
            'pro_tindih_pri' => 'Pro Tindih Pri',
            'jumud' => 'Jumud',
            'admission_req' => 'Admission Requirement (BM)',
            'admission_req_bi' => 'Admission Req (EN)',
            'career' => 'Career (BM)',
            'career_bi' => 'Career (EN)',
            'trash' => 'Trash',
        ];
    }
	
	
	
	public function IAmProgramPic(){
		$pics = $this->programPics;
		if($pics){
			foreach($pics as $pic){
				if($pic->staff_id == Yii::$app->user->identity->staff->id){
					return true;
				}
			}
		}
		return false;
	}
	
	public function getProgramNameCode(){
	    return $this->pro_name . ' ('. $this->program_code .')';
	}
	
	public function getProgramPics(){
		return $this->hasMany(ProgramPic::className(), ['program_id' => 'id']);
	}
	
	public function getProgramAccesses(){
		return $this->hasMany(ProgramAccess::className(), ['program_id' => 'id']);
	}
	
	public function getProgramLevel(){
        return $this->hasOne(ProgramLevel::className(), ['id' => 'pro_level']);
    }
    
    public function getDepartment(){
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }
	
	public function getPublishedVersion(){
		return ProgramVersion::findOne(['program_id' => $this->id, 'is_published' => 1]);
	}
	
	public function getDevelopmentVersion(){
		return ProgramVersion::findOne(['program_id' => $this->id, 'is_developed' => 1]);
	}

}
