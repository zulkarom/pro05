<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ApplicationCourse;
use common\models\ApplicationWorkflow;
use backend\models\Todo;

/**
 * ApplicationSearch represents the model behind the search form of `common\models\Application`.
 */
class ApplicationCourseSearch extends ApplicationCourse
{
	public $fasi_name;
	public $selected_sem;
	public $campus_id;
	public $fasi_type_id;
	public $status;
	public $course_id;
	public $phone;
	public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campus_id', 'fasi_type_id', 'selected_sem', 'course_id'], 'integer'],
			
			[['fasi_name', 'phone' , 'email'], 'string'],
			
            [['status'], 'safe'],
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

        $query = ApplicationCourse::find();
		
		$query->joinWith(['application.fasi.user', 'course c'])->orderBy('c.course_name');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'sort'=> ['defaultOrder' => ['c.course_code'=>SORT_ASC]],
			'pagination' => [
				'pageSize' => 150,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


		
        $query->andFilterWhere([
            'semester_id' => $this->selected_sem,
            'course_id' => $this->course_id,
			'campus_id' => $this->campus_id,
			'fasi_type_id' => $this->fasi_type_id,
			'application.status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'user.fullname', $this->fasi_name]);
        $query->andFilterWhere(['like', 'fasi.handphone', $this->phone]);
        $query->andFilterWhere(['like', 'user.email', $this->email]);


        return $dataProvider;
    }
    
    public function getAllStatusesArray(){
        $cl = new ApplicationWorkflow;
        $status = $cl->getDefinition();
        $array = array();
        foreach($status['status'] as $key=>$s){
            $array['ApplicationWorkflow/' . $key] = $s['label'];
        }
        return $array;
    }
}
