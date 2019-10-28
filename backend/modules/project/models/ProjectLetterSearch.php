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
class ProjectLetterSearch extends Project
{
	public $fasi;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			 [['pro_name', 'pro_token', 'fasi'], 'string'],
		
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
		$query->joinWith(['application.fasi.user', 'coordinator'=> function($q) {
			$q->joinWith(['fasi fasi2' => function($q) {
			$q->joinWith('user user2');
		}]);
		}]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['status'=>SORT_ASC]],
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
        ]);


			
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
