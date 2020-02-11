<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_slt".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property double $lecture_jam
 * @property int $lecture_mggu
 * @property double $tutorial_jam
 * @property int $tutorial_mggu
 * @property double $practical_jam
 * @property int $practical_mggu
 * @property double $others_jam
 * @property int $others_mggu
 * @property double $independent
 * @property double $nf2f
 */
class CourseSlt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_slt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
			[['crs_version_id'], 'required', 'on' => 'fresh'],
			
            //[['crs_version_id', 'lecture_jam', 'lecture_mggu', 'tutorial_jam', 'tutorial_mggu', 'practical_jam', 'practical_mggu', 'others_jam', 'others_mggu', 'independent', 'nf2f'], 'required'],
            [['crs_version_id', 'lecture_mggu', 'tutorial_mggu', 'practical_mggu', 'others_mggu', 'is_practical'], 'integer'],
			
            [['lecture_jam', 'tutorial_jam', 'practical_jam', 'others_jam', 'independent', 'nf2f'], 'number'],
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
            'lecture_jam' => 'Lecture Jam',
            'lecture_mggu' => 'Lecture Mggu',
            'tutorial_jam' => 'Tutorial Jam',
            'tutorial_mggu' => 'Tutorial Mggu',
            'practical_jam' => 'Practical Jam',
            'practical_mggu' => 'Practical Mggu',
            'others_jam' => 'Others Jam',
            'others_mggu' => 'Others Mggu',
            'independent' => 'Independent',
            'nf2f' => 'Nf2f',
        ];
    }
	
	public static function checkSlt($version){
		$slt = self::findOne(['crs_version_id' => $version]);
		if(!$slt){
			$slt = new self();
			$slt->scenario = 'fresh';
			$slt->crs_version_id = $version;
			$slt->save();
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
