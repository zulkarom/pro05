<?php

namespace backend\modules\project\models;

use Yii;
use common\models\Application;
use common\models\Common;

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
			
			[['pro_name', 'pro_token', 'application_id', 'location',  'purpose', 'background', 'pro_target', 'updated_at'], 'required', 'on' => 'update-main'],
			
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
	
	public function statusList(){
		return [0 => 'DERAFT', 10 => 'SEMAKAN', 20 => 'HANTAR'];
	}
	
	public function getStatusName(){
		$arr = $this->statusList();
		return $arr[$this->status];
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
	
	public function getTotalExpenses(){
		$basic = $this->expenseBasics;
		$total = 0;
		if($basic){
			foreach($basic as $b){
				$total += $b->amount;
			}
		}
		$rent = $this->expenseRents;
		if($rent){
			foreach($rent as $b){
				$total += $b->amount;
			}
		}
		$tools = $this->expenseTools;
		if($tools){
			foreach($tools as $b){
				$total += $b->amount;
			}
		}
		return $total;
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
	
	
	
	public function getCommitteePositions()
    {
        return $this->hasMany(CommitteePosition::className(), ['pro_id' => 'id'])->orderBy('post_order ASC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTentativeDays()
    {
        return $this->hasMany(TentativeDay::className(), ['pro_id' => 'id']);
    }
	
	 public function getProjectStudents()
    {
        return $this->hasMany(ProjectStudent::className(), ['project_id' => 'id']);
    }
	
	public function studentInvolved(){
		$list = $this->projectStudents;
		$array = [];
		if($list){
			foreach($list as $row){
				$array[$row->student_id] = $row->student->student_name;
			}
		}
		return $array;
	}
	
	public function putDefaultCommittee($student){
		$arr = ['Pengarah', 'Timbalan Pengarah', 'Setiausaha', 'Penolong Setiausaha', 'Bendahari'];
		foreach($arr as $i){
			$post = new CommitteeMain;
			$post->pro_id = $this->id;
			$post->position = $i;
			$post->student_id = $student;
			$post->save();
		}
	}
	
	public function putDefaultPosition($student){
		$arr = ['Teknikal', 'Logistik', 'Kesihatan dan Keselamatan', 'Hadiah dan Cenderamata', 'Publisiti dan Media', 'Penajaan', 'Kebersihan', 'Makanan', 'Tugas-tugas Khas'];
		foreach($arr as $i){
			$post = new CommitteePosition;
			$post->pro_id = $this->id;
			$post->position = $i;
			if($post->save()){
				$member = new CommitteeMember;
				$member->position_id = $post->id;
				$member->student_id = $student;
				$member->save();
			}
		}
	}
	
	public function putDefaultIncome(){
		$arr = ['Peruntukan daripada PKPP', 'Kutipan Pelajar', 'Yuran Penyertaan', 'Derma Tunai dan Tajaan Luar'];
		foreach($arr as $i){
			$res = new Resource;
			$res->pro_id = $this->id;
			$res->rs_name = $i;
			$res->rs_quantity = 1;
			
			if($i == 'Peruntukan daripada PKPP'){
				$res->rs_amount = 500;
			}else{
				$res->rs_amount = 0;
			}
			
			if(!$res->save()){
				$res->flashError();
			}
		}
	}
	
	public function putDefaultExpense(){
		$arr = ['Makanan dan minuman', 'Bayaran penceramah/ pengadil', 'Hadiah Pemenang'];
		foreach($arr as $i){
			$res = new ExpBasic;
			$res->pro_id = $this->id;
			$res->exp_name = $i;
			$res->quantity = 1;
			
			if($i == 'Peruntukan daripada PKPP'){
				$res->amount = 500;
			}else{
				$res->amount = 0;
			}
			
			if(!$res->save()){
				$res->flashError();
			}
		}
	}
	
	public function getMainCommittees()
    {
        return $this->hasMany(CommitteeMain::className(), ['pro_id' => 'id'])->orderBy('com_order ASC');
    }
	
	public function getTopPosition(){
		return $this->hasOne(CommitteeMain::className(), ['pro_id' => 'id'])->orderBy('com_order ASC');
	}
	
	public function getProjectStartEndDate(){
		$days = $this->tentativeDays;
		if($days){
			$last =count($days);
			$i = 1;
			$start = false;
			$end = false;
			foreach($days as $d){
				if($i == 1){
					$start = $d->pro_date;
				}
				if($i == $last){
					$end = $d->pro_date;
				}
			$i++;
			}
			return [$start, $end];
		}else{
			return false;
		}
	}
	
	public function getProjectTime(){
		$arr = $this->timeStartEnd;
		if($arr){
			$start = $arr[0];
			$end = $arr[1];
			if($start && $end){
				return $this->convertTime($start) . ' - ' . $this->convertTime($end);
			}
		}
	}
	
	
	public function convertTime($str_time){
		$str_masa = '';
		$search_space = $this->hasChar(" ", $str_time);
		if($search_space){
			$arr = explode(" ", $str_time);
			$num = $arr[0];
			$ampm = $arr[1];
			$str_hour = $this->hasChar(":", $num);
			if($str_hour){
				$hour = $str_hour[0] + 0;
				$minute = $str_hour[1];
				if(strtoupper($ampm) == 'PM'){
					if($hour == 12){
						$str_masa = 'tengahari';
					}else if (in_array($hour, [7,8,9,10,11])){
						$str_masa = 'malam';
					}else{
						$str_masa = 'petang';
					}
				}else{
					$str_masa = 'pagi';
				}
				return str_replace(":", ".", $num) . ' ' . $str_masa;
			}
			
		}
		
		return 'non-formated time';
	}
	
	private function hasChar($searchString, $search){
		if(strpos($search, $searchString) !== false ) {
			 return true;
		}
		return false;
	}
	
	public function getTimeStartEnd(){
		$days = $this->tentativeDays;
		$start = false;
		$end = false;
		$i = 1;
		$last = count($days);
		if($days){
			foreach($days as $day){
				$times = $day->tentativeTimes;
				if($times){
					if($i == 1){
						foreach($times as $time){
							$start = $time->ttf_time;
							break;
						}
					}
					if($i == $last){
						$last_time = count($times);
						$l = 1;
						foreach($times as $time){
							if($l == $last_time){
								$end = $time->ttf_time;
							}
						$l++;
						}
					}
					
				}
				
			$i++;
			}
			
		}
		
		return [$start, $end];
	}
	
	public function getProjectDate(){
		$arr = $this->projectStartEndDate;
		if($arr){
			$start = $arr[0];
			$end = $arr[1];
			//echo $start . $end; die();
			if($start && $end){
				if($start == $end){
					return $this->dateFormat($start);
				}else{
					return $this->dateFormatTwo($start, $end);
				}
			}
		}
		
		
	}
	
	private function dateFormatTwo($date1, $date2){
		$day1 = date('j', strtotime($date1));
		$month_num1 = date('n', strtotime($date1));
		$month_bm = Common::months();
		$month_str1 = $month_bm[$month_num1];
		$year1 = date('Y', strtotime($date1));
		
		$day2 = date('j', strtotime($date2));
		$month_num2 = date('n', strtotime($date2));
		$month_str2 = $month_bm[$month_num2];
		$year2 = date('Y', strtotime($date2));
		
		if($month_num1 == $month_num2){
			if($year1 == $year2){
				return $day1 . ' - '.$day2.' ' . $month_str1 . ' ' . $year1;
			}else{
				return $day1 . ' ' . $month_str1 . ' ' . $year1 . ' - '. $day2 . ' ' . $month_str2 . ' ' . $year2 ;
			}
			
		}else{
			if($year1 == $year2){
				return $day1 . ' ' . $month_str1 . ' - '.$day2.' ' . $month_str2 . ' ' . $year1;
			}else{
				return $day1 . ' ' . $month_str1 . ' ' . $year1 . ' - '. $day2 . ' ' . $month_str2 . ' ' . $year2 ;
			}
		}
	}
	
	private function dateFormat($date){
		$day = date('j', strtotime($date));
		$month_num = date('n', strtotime($date));
		$month_bm = Common::months();
		$month_str = $month_bm[$month_num];
		$year = date('Y', strtotime($date));
		return $day . ' ' . $month_str . ' ' . $year;
	}
	
	
	
}
