<?php

namespace backend\modules\project\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\project\models\Project;
use backend\models\Semester;

/**
 * ProjectSearch represents the model behind the search form of `backend\modules\project\models\Project`.
 */
class ProjectAllocationSearch extends Project
{
	public $fasi;
	public $approve_from;
	public $approve_until;
	public $campus_cari;
	public $batchno;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			 [['campus_cari'], 'integer'],
			 
			 [['approve_from', 'approve_until'], 'safe'],
			 
			 [['batchno'], 'string'],
		
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
		$semester = Semester::getCurrentSemester();
        $query = Project::find()->where(['project.semester_id' => $semester->id]);
		$query->joinWith(['application', 'coordinator']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['approved_at'=>SORT_DESC]],
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
            'project.status' => 30,
			'batch_no' => $this->batchno
        ]);
		
		if($this->campus_cari){
			$query->andFilterWhere(['or', 
            ['application.campus_id' => $this->campus_cari],
            ['pro_coor.campus_id' => $this->campus_cari]
        ]);
		}
		
		
		if($this->approve_from){
			$query->andWhere(['>=', 'project.approved_at', $this->approve_from]);
		}
		
		if($this->approve_until){
			$query->andWhere(['<=', 'project.approved_at', $this->approve_until]);
		}
        
		




			
		$dataProvider->sort->attributes['fasi'] = [
        'asc' => ['user.fullname' => SORT_ASC],
        'desc' => ['user.fullname' => SORT_DESC],
        ]; 
		
		$dataProvider->sort->attributes['status_num'] = [
        'asc' => ['status' => SORT_ASC],
        'desc' => ['status' => SORT_DESC],
        ]; 


        return $dataProvider;
    }
}
