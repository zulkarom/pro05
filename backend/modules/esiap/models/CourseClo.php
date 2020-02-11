<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_clo2".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property string $verb
 * @property string $clo_text
 * @property string $clo_text_bi
 * @property string $percentage
 * @property int $PLO1
 * @property int $PLO2
 * @property int $PLO3
 * @property int $PLO4
 * @property int $PLO5
 * @property int $PLO6
 * @property int $PLO7
 * @property int $PLO8
 * @property int $PLO9
 * @property int $PLO10
 * @property int $PLO11
 * @property int $PLO12
 * @property int $C1
 * @property int $C2
 * @property int $C3
 * @property int $C4
 * @property int $C5
 * @property int $C6
 * @property int $A1
 * @property int $A2
 * @property int $A3
 * @property int $A4
 * @property int $A5
 * @property int $P1
 * @property int $P2
 * @property int $P3
 * @property int $P4
 * @property int $P5
 * @property int $P6
 * @property int $P7
 * @property int $CS1
 * @property int $CS2
 * @property int $CS3
 * @property int $CS4
 * @property int $CS5
 * @property int $CS6
 * @property int $CS7
 * @property int $CS8
 * @property int $CT1
 * @property int $CT2
 * @property int $CT3
 * @property int $CT4
 * @property int $CT5
 * @property int $CT6
 * @property int $CT7
 * @property int $TS1
 * @property int $TS2
 * @property int $TS3
 * @property int $TS4
 * @property int $TS5
 * @property int $LL1
 * @property int $LL2
 * @property int $LL3
 * @property int $ES1
 * @property int $ES2
 * @property int $ES3
 * @property int $ES4
 * @property int $EM1
 * @property int $EM2
 * @property int $EM3
 * @property int $LS1
 * @property int $LS2
 * @property int $LS3
 * @property int $LS4
 * @property int $trash
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 */
class CourseClo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_clo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clo_text', 'clo_text_bi'], 'required', 'on' => 'clo'],
			
            [['crs_version_id', 'PLO1', 'PLO2', 'PLO3', 'PLO4', 'PLO5', 'PLO6', 'PLO7', 'PLO8', 'PLO9', 'PLO10', 'PLO11', 'PLO12', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'A1', 'A2', 'A3', 'A4', 'A5', 'P1', 'P2', 'P3', 'P4', 'P5', 'P6', 'P7', 'CS1', 'CS2', 'CS3', 'CS4', 'CS5', 'CS6', 'CS7', 'CS8', 'CT1', 'CT2', 'CT3', 'CT4', 'CT5', 'CT6', 'CT7', 'TS1', 'TS2', 'TS3', 'TS4', 'TS5', 'LL1', 'LL2', 'LL3', 'ES1', 'ES2', 'ES3', 'ES4', 'EM1', 'EM2', 'EM3', 'LS1', 'LS2', 'LS3', 'LS4', 'trash', 'created_by'], 'integer'],
			
            [['clo_text', 'clo_text_bi'], 'string'],
			
            [['percentage'], 'number'],
			
            [['created_at', 'updated_at'], 'safe'],
			
            [['verb'], 'string', 'max' => 100],
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
            'verb' => 'Verb',
            'clo_text' => 'Clo Text',
            'clo_text_bi' => 'Clo Text Bi',
            'percentage' => 'Percentage',
            'PLO1' => 'Plo1',
            'PLO2' => 'Plo2',
            'PLO3' => 'Plo3',
            'PLO4' => 'Plo4',
            'PLO5' => 'Plo5',
            'PLO6' => 'Plo6',
            'PLO7' => 'Plo7',
            'PLO8' => 'Plo8',
            'PLO9' => 'Plo9',
            'PLO10' => 'Plo10',
            'PLO11' => 'Plo11',
            'PLO12' => 'Plo12',
            'C1' => 'C1',
            'C2' => 'C2',
            'C3' => 'C3',
            'C4' => 'C4',
            'C5' => 'C5',
            'C6' => 'C6',
            'A1' => 'A1',
            'A2' => 'A2',
            'A3' => 'A3',
            'A4' => 'A4',
            'A5' => 'A5',
            'P1' => 'P1',
            'P2' => 'P2',
            'P3' => 'P3',
            'P4' => 'P4',
            'P5' => 'P5',
            'P6' => 'P6',
            'P7' => 'P7',
            'CS1' => 'Cs1',
            'CS2' => 'Cs2',
            'CS3' => 'Cs3',
            'CS4' => 'Cs4',
            'CS5' => 'Cs5',
            'CS6' => 'Cs6',
            'CS7' => 'Cs7',
            'CS8' => 'Cs8',
            'CT1' => 'Ct1',
            'CT2' => 'Ct2',
            'CT3' => 'Ct3',
            'CT4' => 'Ct4',
            'CT5' => 'Ct5',
            'CT6' => 'Ct6',
            'CT7' => 'Ct7',
            'TS1' => 'Ts1',
            'TS2' => 'Ts2',
            'TS3' => 'Ts3',
            'TS4' => 'Ts4',
            'TS5' => 'Ts5',
            'LL1' => 'Ll1',
            'LL2' => 'Ll2',
            'LL3' => 'Ll3',
            'ES1' => 'Es1',
            'ES2' => 'Es2',
            'ES3' => 'Es3',
            'ES4' => 'Es4',
            'EM1' => 'Em1',
            'EM2' => 'Em2',
            'EM3' => 'Em3',
            'LS1' => 'Ls1',
            'LS2' => 'Ls2',
            'LS3' => 'Ls3',
            'LS4' => 'Ls4',
            'trash' => 'Trash',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function getCloAssessments()
    {
        return $this->hasMany(CourseCloAssessment::className(), ['clo_id' => 'id'])->orderBy('id ASC');
    }
	
	public function getCloDeliveries()
    {
        return $this->hasMany(CourseCloDelivery::className(), ['clo_id' => 'id']);
    }
	
	public function assessPercent($assessment_id){
		$per = CourseCloAssessment::find()->where(['clo_id' => $this->id, 'assess_id' => $assessment_id])->one();
		if($per){
			return $per->percentage;
		}else{
			return '';
		}
	}
	
	public function getDefaultVersion(){
		return CourseVersion::findOne($this->crs_version_id);
	}
	
	public function getPlo(){
		$html = '';
		$plo_num = $this->defaultVersion->ploNumber;
		$x=1;
		for($c=1;$c<=$plo_num;$c++){
			$prop = 'PLO'.$c;
			if($this->$prop == 1){
				
				$comma = $x == 1 ? '' : ', ';
				$html .= $comma.$prop;
				$x++;
			}
		}
		return $html;
	}
	
	public function getSoftskillStr(){
		$kira = 0;
		$str = '';
		$break = '<br />';
		for($i=1;$i<=8;$i++){
			$prop = 'CS'.$i;
			if($this->{$prop} == 1){
				$comma = $kira == 0 ? '' : $break;
				$str .= $comma.$prop;
				$kira++;
			}

		}
		for($i=1;$i<=7;$i++){
			$prop = 'CT'.$i;
			if($this->{$prop} == 1){
				$comma = $kira == 0 ? '' : $break;
				$str .= $comma.$prop;
				$kira++;
			}

		}
		for($i=1;$i<=5;$i++){
			$prop = 'TS'.$i;
			if($this->{$prop} == 1){
				$comma = $kira == 0 ? '' : $break;
				$str .= $comma.$prop;
				$kira++;
			}

		}

		for($i=1;$i<=3;$i++){
			$prop = 'LL'.$i;
			if($this->{$prop} == 1){
				$comma = $kira == 0 ? '' : $break;
				$str .= $comma.$prop;
				$kira++;
			}
		}


		//Entrepreneurial (ES)
		for($i=1;$i<=4;$i++){
			$prop = 'ES'.$i;
			if($this->{$prop} == 1){
				$comma = $kira == 0 ? '' : $break;
				$str .= $comma.$prop;
				$kira++;
			}

		}

		//Ethic and Moral (EM)
		for($i=1;$i<=3;$i++){
			$prop = 'EM'.$i;
			if($this->{$prop} == 1){
				$comma = $kira == 0 ? '' : $break;
				$str .= $comma.$prop;
				$kira++;
			}

		}
		//Leadership (LS)
		for($i=1;$i<=4;$i++){
			$prop = 'LS'.$i;
			if($this->{$prop} == 1){
				$comma = $kira == 0 ? '' : $break;
				$str .= $comma.$prop;
				$kira++;
			}
			
		}
		
		return $str;
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
