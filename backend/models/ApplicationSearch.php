<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Application;
use backend\models\Todo;

/**
 * ApplicationSearch represents the model behind the search form of `common\models\Application`.
 */
class ApplicationSearch extends Application
{
	public $fasi_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campus_id', 'fasi_type_id'], 'integer'],
			
			[['fasi_name'], 'string'],
			
            [['status', 'submit_at', 'verified_at', 'approved_at', 'reject_note'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = Application::find();
		
		$query->joinWith('fasi');
		$query->leftJoin('user', 'fasi.user_id = user.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 50,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
		
		if($this->status){
			$statuses = $this->status;
		}else{
			$arr = array();
			$pre = 'ApplicationWorkflow/';
			if(Todo::can('verify-application')){
				$arr = [$pre.'b-submit', $pre.'c-verified', $pre.'d-approved', $pre.'e-release', $pre.'f-accept'];
			}else if(Todo::can('approve-application')){
				$arr = [$pre.'c-verified', $pre.'d-approved', $pre.'e-release', $pre.'f-accept'];
			}
			
			$statuses = $arr;
		}
		
		//print_r($arr);
		
		$curr_sem = Semester::getCurrentSemester();
		
        $query->andFilterWhere([
            'semester_id' => $curr_sem->id,
			'campus_id' => $this->campus_id,
			'fasi_type_id' => $this->fasi_type_id,
			'application.status' => $statuses
        ]);

        $query->andFilterWhere(['like', 'user.fullname', $this->fasi_name]);


        return $dataProvider;
    }
}
