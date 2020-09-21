<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_reference".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property string $ref_year
 * @property int $is_classic
 * @property int $is_main
 */
class CourseReference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_reference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crs_version_id'], 'required', 'on' => 'add'],
			
			 [['crs_version_id', 'ref_full', 'ref_year'], 'required', 'on' => 'saveall'],
			 
            [['crs_version_id', 'is_classic', 'is_main'], 'integer'],
            [['ref_year'], 'number'],
			[['ref_full'], 'string'],
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
			'ref_full' => 'Full Reference',
            'ref_year' => 'Reference Year',
            'is_classic' => 'Is Classic',
            'is_main' => 'Is Main',
        ];
    }
	
	public function getFormatedReference(){
		$str = $this->ref_full;
		$str_arr = explode("*", $str);
		$return = '';
		$i = 0;
		$x = 1;
		foreach($str_arr as $s){
			if($x == 1){
				$tag = '';
			}else{
				$tag = $i == 0 ? '</i>' : '<i>';
			}
			
			$return .= $tag.$s;
			
			$i = $i == 0 ? 1 : 0;
			$x++;
		}
		
		return $return;
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
