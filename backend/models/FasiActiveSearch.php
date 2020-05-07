<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Application;
use backend\models\Semester;
use common\models\Fasi;

/**
 * FasiSearch represents the model behind the search form of `common\models\Fasi`.
 */
class FasiActiveSearch extends Fasi
{
	public $fullname;
	public $email;
	public $campus;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['campus'], 'integer'],

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
		$sem = Semester::getCurrentSemester();
        $query = Application::find()
		->where(['semester_id' => $sem->id, 'application.status' => 'ApplicationWorkflow/f-accept']);
		$query->joinWith(['fasi.user']);
		$query->orderBy('user.fullname ASC');
		
		//$query->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
		
		$query->andFilterWhere([
            'campus_id' => $this->campus,
        ]);


/* 
			
		$dataProvider->sort->attributes['fullname'] = [
        'asc' => ['user.fullname' => SORT_ASC],
        'desc' => ['user.fullname' => SORT_DESC],
		]; 
		
		$query->andFilterWhere(['like', 'user.fullname', $this->fullname]);
 */

        return $dataProvider;
    }
}
