<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_reference".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property string $ref_author
 * @property string $ref_year
 * @property string $ref_title
 * @property string $ref_others
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
            [['crs_version_id'], 'required'],
            [['crs_version_id', 'is_classic', 'is_main'], 'integer'],
            [['ref_year'], 'safe'],
			[['ref_full'], 'string'],
            [['ref_author', 'ref_title', 'ref_others'], 'string', 'max' => 200],
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
            'ref_author' => 'Ref Author',
			'ref_full' => 'Full Reference',
            'ref_year' => 'Ref Year',
            'ref_title' => 'Ref Title',
            'ref_others' => 'Ref Others',
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
}
