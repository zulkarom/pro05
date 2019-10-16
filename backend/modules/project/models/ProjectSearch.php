<?php

namespace backend\modules\project\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\project\models\Project;

/**
 * ProjectSearch represents the model behind the search form of `backend\modules\project\models\Project`.
 */
class ProjectSearch extends Project
{
	public $fasi;
	public $status_num;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_num'], 'integer'],
			
			 [['pro_fund', 'pro_expense'], 'number'],
			
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
        $query = Project::find();
		$query->joinWith(['application.fasi.user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['pro_name'=>SORT_DESC]],
			'pagination' => [
                'pageSize' => 100,
            ],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
	

        // grid filtering conditions
        $query->andFilterWhere([
            'project.status' => $this->status_num,
        ]);

        $query->andFilterWhere(['like', 'pro_name', $this->pro_name])
            ->andFilterWhere(['like', 'pro_token', $this->pro_token])
			->andFilterWhere(['like', 'pro_fund', $this->pro_fund])
			->andFilterWhere(['like', 'pro_expense', $this->pro_expense])
            ->andFilterWhere(['like', 'user.fullname', $this->fasi]);
			
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