<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use raoul2000\workflow\validation\WorkflowValidator;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Common;
use backend\models\ClaimSetting;
use backend\models\Api;
use backend\models\ClaimAttend;

/**
 * This is the model class for table "claim".
 *
 * @property int $id
 * @property int $application_id
 * @property int $month
 * @property string $year
 * @property string $draft_at
 * @property string $submit_at
 * @property string $status
 */
class Claim extends \yii\db\ActiveRecord
{
	public $hour_app;
	public $month_year;
	public $sum_all;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'claim';
    }
	
	public function behaviors()
    {
    	return [
			\raoul2000\workflow\base\SimpleWorkflowBehavior::className()
    	];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
			[['status'], WorkflowValidator::className()],
			
			[['month', 'year', 'draft_at', 'month_year'], 'required', 'on' => WorkflowScenario::enterStatus('aa-draft')],
			
			[['draft_at', 'rate_amount', 'total_hour'], 'required', 'on' => 'save-draft'],
			
            [['submit_at', 'rate_amount', 'total_hour'], 'required', 'on' => WorkflowScenario::enterStatus('bb-submit')],
			
			[['returned_at', 'returned_by'], 'required', 'on' => WorkflowScenario::enterStatus('cc-returned')],
			
			

            [['application_id', 'verified_by', 'approved_by'], 'integer'],
			
			[['rate_amount', 'total_hour'], 'number'],
			
			[['verify_note', 'approve_note', 'return_note', 'month_year'], 'string'],
			
            [['status'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application' => 'Application',
            'status' => 'Status',
			'month' => 'Bulan',
			'year' => 'Tahun',
			'total_hour' => 'Jumlah Jam',
			'rate_amount' => 'Kadar Bayaran (sejam)'
        ];
    }
	
	public function getClaimItems()
    {
        return $this->hasMany(ClaimItem::className(), ['claim_id' => 'id']);
    }
	
	public function getClaimFiles()
    {
        return $this->hasMany(ClaimFile::className(), ['claim_id' => 'id']);
    }
	
	public function getClaimAttends()
    {
        return $this->hasMany(ClaimAttend::className(), ['claim_id' => 'id']);
    }
	
	public function getClaimAttendsNotThis()
    {
        return ClaimAttend::find()
		->select('portal_id')
		->joinWith('claim')
		->where(['claim.application_id' => $this->application_id])
		->andWhere(['<>', 'claim_attend.claim_id', $this->id])
		->all();
    }
	
	
	public function getClaimAttendLinks(){
		$model = $this->application;
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
		$response = $api->attendList();
		
		$portal = 
		$html = '';
		$list = $this->claimAttends;
		if($list){
			foreach($list as $row){
				if($response){
					if($response->result){
						$k = 1;
						foreach($response->result as $x){
							if($x->id == $row->portal_id){
								$time = strtotime($x->starttime) + ($x->duration * 60 * 60);
								$timeend = date('H:i', $time);
								$html .= '<a href="'.Url::to(['student/attendance-portal-pdf', 'a' => $model->id , 'id' => $row->portal_id]).'" target="_blank" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-download-alt"></span> ' . '[' . $k . '] ' . $x->date . ' ' . $x->starttime . ' - '.$timeend.'</a> ';
							}
						$k++;
						}
					}
				}
				
			}
		}
		
		return $html;
	}
	
	public function validateClaimFiles(){
		$attend = $this->claimAttends;
		$kira = count($attend) + 0;
		
		if($kira == 0){
			
			$files = $this->claimFiles;
			$kira = count($files);
			
			if($kira > 0){
				foreach($files as $f){
					if($f->claim_file == ''){
						return false;
						exit();
					}
				}
			}else{
				return false;
			}
		}
		return true;
	}
	
	public function getApplication()
    {
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }
	
	public function getAllStatusesArray(){
		$cl = new ClaimWorkflow;
		$status = $cl->getDefinition();
		$array = array();
		foreach($status['status'] as $key=>$s){
			$array['ClaimWorkflow/' . $key] = $s['label'];
		}
		return $array;
	}
	
	public function getAcceptApplication(){
		$result = Application::find()
		->joinWith(['semester','fasi'])
		->where([
			'application.status' => 'ApplicationWorkflow/f-accept' ,
			'fasi.user_id' => Yii::$app->user->identity->id ,
			'semester.is_current' => 1
			])->one();
		//print_r($result);
		//die();
		return $result ? $result : null;
	}
	
	
	
	public function getExistingClaim(){
		
		$apply = $this->getAcceptApplication();
		if($apply){
			$apply = $apply->id;
		}else{
			return false;
		}
		$result = static::findOne(['application_id' => $apply, 'month' => $this->month, 'year' => $this->year]);
		
		
		return $result;
	}
	
	public function monthName(){
		$months = Common::months();
		return $months[$this->month];
	}
	
	public function getWfStatus(){
		$status = $this->getWorkflowStatus()->getId();
		$status = str_replace("ClaimWorkflow/", "", $status);
		$arr = explode("-", $status);
		return $arr[1];
	}

	public function getWfLabel(){
		$label = $this->getWorkflowStatus()->getLabel();
		$color = $this->getWorkflowStatus()->getMetadata('color');
		$format = '<span class="label label-'.$color.'">'.strtoupper($label).'</span>';
		return $format;
	}
	
	public function getHoursClaimedByApp(){
		$hour = self::find()
		->select(['hour_app' => 'sum(claim_item.hour_end - claim_item.hour_start)'])
		->innerJoin('claim_item', 'claim_item.claim_id = claim.id')
		->where(['application_id' => $this->application_id])
		->andWhere(['<>', 'claim.id', $this->id])
		->groupBy('claim.application_id')
		->one();
		
		if($hour){
			return $hour->hour_app;
		}else{
			return 0;
		}
		
	}
	
	public function validateClaimItem($items){
		if($items){
			$total = 0;
			foreach($items as $item){
				$duration = $item->hour_end - $item->hour_start;
				$duration = $duration < 0 ? 0 : $duration;
				$total += $duration;
				
			}
		$max_month = ClaimSetting::findOne(1)->hour_max_month;
		$max_sem = ClaimSetting::findOne(1)->hour_max_sem;
		if($total > $max_month){
			Yii::$app->session->addFlash('error', "Jam tuntutan melebihi jumlah maksimum sebulan (".$max_month.")");
			return false;
		}
		$sem = $this->getHoursClaimedByApp();
		$total_sem = $total + $sem ;
		if($total_sem > $max_sem){
			Yii::$app->session->addFlash('error', "Jam tuntutan melebihi jumlah maksimum satu semester (".$max_sem.")");
			return false;
		}
		
		//update rate & total hour to claim
		$this->total_hour = $total;
		$this->rate_amount = $this->application->rate_amount;
		
		}
		return true;
	}
	
	public function checkDueDate(){
		$month = $this->month;
		$next = $month + 1;
		$year = $this->year;
		if($next == 13){
			$next = 1;
			$year++;
		}
		
		$set = ClaimSetting::findOne(1);
		$due = $set->claim_due_at + 1;
		if($due > 31){
			$due = 1;
			$next++;
		}
		
		$str_due = $year . '-' . $next . '-' . $due ;
		
		$time_due = strtotime($str_due);
		$block = $set->block_due;
		if($block == 1){
			if(time() > $time_due){
				return false;
			}
			
		}
		return true;
	}
	
	public function getListPortalAttendance(){
		$model = $this->application;
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
		$response = $api->attendList();
		$array = [];
		if($response){
			if($response->result){
				foreach($response->result as $row){
					$month = date('m', strtotime($row->date)) + 0;
					if($month == $this->month){
						$array[] = $row;
					}
				}
			}
		}
		
		return $array;
	}
	
	public function getListPortalAttendanceAll(){
		$model = $this->application;
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
		$response = $api->attendList();
		$array = [];
		if($response){
			if($response->result){
				$i=1;
				foreach($response->result as $row){
					$time = strtotime($row->starttime) + ($row->duration * 60 * 60);
					$timeend = date('H:i', $time);
					$array[$row->id] = '[' . $i . '] ' . date('d M Y', strtotime($row->date)) . ' ' . $row->starttime . ' - ' . $timeend;
				$i++;
				}
			}
		}
		
		return $array;
	}
	
	public function getListPortalAttendanceRecorded(){
		
		$model = $this->application;
		
		$already = ArrayHelper::map($this->claimAttendsNotThis, 'portal_id', 'portal_id');
		//print_r($this->claimAttendsNotThis);die();

		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
		$response = $api->attendList();
		$array = [];
		if($response){
			if($response->result){
				$i=1;
				foreach($response->result as $row){
					if(!(in_array($row->id, $already))){
					$open = false;	
					//check future date pulak
					if(strtotime($row->date) <= time()){
						$api->id = $row->id;
						$result_attend = $api->attend(); //API
						if($result_attend){
							if($result_attend->result){
								foreach($result_attend->result as $rr){
									$status = $rr->status;
									if($status == 1){
										$open = true;
										break;
									}
									
								}
							}
						}
					}
					
					
					
					if($open){
						$time = strtotime($row->starttime) + ($row->duration * 60 * 60);
						$timeend = date('H:i', $time);
						$array[$row->id] = '[' . $i . '] ' . date('d M Y', strtotime($row->date)) . ' ' . $row->starttime . ' - ' . $timeend;
					}
					
					
					
					
					}
				$i++;
				}
			}
		}
		
		return $array;
	}
	
}
