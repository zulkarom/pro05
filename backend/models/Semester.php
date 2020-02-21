<?php

namespace backend\models;

use Yii;
use yii\db\Expression;
use common\models\Common;

/**
 * This is the model class for table "semester".
 *
 * @property int $id
 * @property string $description
 * @property int $is_current
 * @property string $date_start
 * @property string $date_end
 * @property string $open_at
 * @property string $close_at
 */
class Semester extends \yii\db\ActiveRecord
{
	public $year_start;
	public $year_end;
	public $session;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'semester';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id' , 'session', 'year_start', 'is_current', 'date_start', 'date_end', 'open_at', 'close_at', 'created_at', 'created_by', 'result_date'], 'required', 'on' => 'create'],
			
			[['is_current', 'date_start', 'date_end', 'open_at', 'close_at', 'result_date'], 'required', 'on' => 'update'],
			
			
            [['id', 'is_current', 'is_open'], 'integer'],
            [['description'], 'string'],
            [['date_start', 'date_end', 'open_at', 'close_at'], 'safe'],
            [['id'], 'unique'],
			
			/* ['date_start', 'date', 'timestampAttribute' => 'date_start'],
			['date_end', 'date', 'timestampAttribute' => 'date_end'],
			['date_start', 'compare', 'compareAttribute' => 'date_end', 'operator' => '<', 'enableClientValidation' => false] */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
			'month' => 'Sesi',
			'is_open' => 'Is this semester open for application? ***',
            'is_current' => 'Is this current semester? *',
            'date_start' => 'Start Date **',
            'date_end' => 'End Date **',
            'open_at' => 'Open Date ***',
            'close_at' => 'Close Date ***',
        ];
    }
	
	public function convertToId(){
		$year_end = $this->year_start + 1;
		return $this->year_start . $year_end . $this->session;
	}
	
	public function setIsCurrentOpen(){
		if($this->is_current == 1){
			Semester::updateAll(['is_current' => 0]);

		}
		if($this->is_open == 1){
			Semester::updateAll(['is_open' => 0]);

		}
	}
	
	public function session(){
		$session =  substr($this->id, 8, 1);
		if($session == 1){
			$sn = 'September';
		}else if($session == 2){
			$sn = 'Februari';
		}else{
			$sn = '';
		}
		return $sn;
	}
	
	public function sessionShort(){
		$session =  substr($this->id, 8, 1);
		if($session == 1){
			$sn = 'Sep';
		}else if($session == 2){
			$sn = 'Feb';
		}else{
			$sn = '';
		}
		return $sn;
	}
	
	public function sessionLong(){
		$session =  substr($this->id, 8, 1);
		if($session == 1){
			$sn = 'September';
		}else if($session == 2){
			$sn = 'Februari';
		}else{
			$sn = '';
		}
		return $sn;
	}
	
	public function years(){
		$year1 = substr($this->id, 0, 4);
		$year2 = substr($this->id, 4, 4);
		return $year1. '/'. $year2;
	}
	
	public function niceFormat(){
		
		return $this->session() . ' ' . $this->years();
	}
	
	public function shortFormat(){
		
		return $this->sessionShort() . ' ' . $this->years();
	}
	
	public function longFormat(){
		
		return strtoupper('Semester ' . $this->sessionLong() . ' ' . $this->years());
	}
	
	public function fullFormat(){
		
		return strtoupper('Semester ' . $this->sessionLong() . ' Sesi ' . $this->years());
	}
	
	public static function getCurrentSemester(){
		$sem =  self::findOne(['is_current' => 1]);
		if($sem){
			return $sem;
		}else{
			return false;
		}
	}
	
	
	
	public static function getOpenSemester(){
		$sem = self::findOne(['is_open' => 1]);	
		if($sem){
			return $sem;
		}else{
			return false;
		}
	}
	
	public static function getOpenDateSemester(){
		$sem = self::find()
		->where(['is_open' => 1])
		->andWhere(['<=', 'open_at', new Expression('NOW()')])
		->andWhere(['>=', 'close_at', date('Y-m-d')])
		->one();
		
		if($sem){
			return $sem;
		}else{
			return false;
		}
	}
	
	public function getListMonthYearSem(){
		$start = $this->date_start;
		$end = $this->date_end;
		
		$month_start = date('n', strtotime($start));
		$month_end = date('n', strtotime($end));
		
		$year_start = date('Y', strtotime($start));
		$year_end = date('Y', strtotime($end));
		
		$list = array();
		if($year_start == $year_end){
			for($i = $month_start; $i <= $month_end; $i++){
				$list[$i . '-' . $year_start] = self::strMonthYear($i, $year_start);
			}
		}else{
			//year 1
			for($i = $month_start; $i <= 12; $i++){
				$list[$i . '-' . $year_start] = self::strMonthYear($i, $year_start);
			}
			for($i = 1; $i <= $month_end; $i++){
				$list[$i . '-' . $year_end] = self::strMonthYear($i, $year_end);
			}
		}
		
		return $list;
		
	}
	
	public function getListMonthSem(){
		$start = $this->date_start;
		$end = $this->date_end;
		
		$month_start = date('n', strtotime($start));
		$month_end = date('n', strtotime($end));
		
		$year_start = date('Y', strtotime($start));
		$year_end = date('Y', strtotime($end));
		
		$list = array();
		
		if($year_start == $year_end){
			for($i = $month_start; $i <= $month_end; $i++){
				$list[] = $i;
			}
		}else{
			for($i = $month_start; $i <= 12; $i++){
				$list[] = $i;
			}
			for($i = 1; $i <= $month_end; $i++){
				$list[] = $i;
			}
		}
		
		return $list;
		
	}
	
	public function listSemester(){
		return self::find()->orderBy('id DESC')->all();
	}
	
	public static function listSemesterArray(){
		$array = [];
		$list = self::find()->orderBy('id DESC')->all();
		if($list){
			foreach($list as $row){
				$array[$row->id] = $row->longFormat();
			}
			
		}
		
		return $array;
	}
	
	private static function strMonthYear($month, $year){
		$str_month = Common::months();
		return strtoupper($str_month[$month]) . ' ' . $year;
	}
}
