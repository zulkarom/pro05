<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_syllabus".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property string $clo
 * @property int $week_num
 * @property string $topics
 * @property double $pnp_lecture
 * @property double $pnp_tutorial
 * @property double $pnp_practical
 * @property double $pnp_others
 * @property double $independent
 * @property double $assessment
 * @property double $nf2f
 */
class CourseSyllabus extends \yii\db\ActiveRecord
{
	public $last_order;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_syllabus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crs_version_id', 'week_num', 'topics'], 'required', 'on' => 'saveall'],
			
			[['crs_version_id'], 'required', 'on' => 'addweek'],
			
			[['pnp_lecture', 'pnp_tutorial', 'pnp_practical', 'pnp_others', 'independent',  'nf2f'], 'required', 'on' => 'slt'],
			
            [['crs_version_id', 'syl_order', 'duration'], 'integer'],
			
            [['topics', 'week_num'], 'string'],
			
            [['pnp_lecture', 'pnp_tutorial', 'pnp_practical', 'pnp_others', 'independent', 'assessment', 'nf2f'], 'number'],
			
            [['clo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crs_version_id' => 'Crs Version ID',
            'clo' => 'Clo',
            'week_num' => 'Week Num',
            'topics' => 'Topics',
            'pnp_lecture' => 'Pnp Lecture',
            'pnp_tutorial' => 'Pnp Tutorial',
            'pnp_practical' => 'Pnp Practical',
            'pnp_others' => 'Pnp Others',
            'independent' => 'Independent',
            'assessment' => 'Assessment',
            'nf2f' => 'Nf2f',
        ];
    }
	
	public static function createWeeks($version){
		for($i=1;$i<=14;$i++){
			$week = new self();
			$week->scenario = 'addweek';
			$week->crs_version_id = $version;

			$week->topics = '[{"top_bm":"","top_bi":"","sub_topic":[]}]';
			if(!$week->save()){
				
			}
		}
		
		
	}
	
	public static function checkSyllabus($version){
		$result = self::find()->where(['crs_version_id' => $version])->all();
		if(!$result){
			self::createWeeks($version);
		}
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
