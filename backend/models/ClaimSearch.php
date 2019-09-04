<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Claim;

/**
 * ClaimSearch represents the model behind the search form of `common\models\Claim`.
 */
class ClaimSearch extends Claim
{
	public $fasi_name;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'application_id', 'month', 'updated_at'], 'integer'],
			[['fasi_name'], 'string'],
            [['year', 'draft_at', 'submit_at', 'status'], 'safe'],
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
        $query = Claim::find();
		$query->joinWith('application');
		$query->leftJoin('fasi', 'fasi.id = application.fasi_id');
		$query->leftJoin('user', 'fasi.user_id = user.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 100,
			],
			'sort'=> ['defaultOrder' => ['month'=>SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		if(!$this->status){
			$this->status = 'ClaimWorkflow/bb-submit';
		}

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'application_id' => $this->application_id,
            'month' => $this->month,
            'year' => $this->year,
            'draft_at' => $this->draft_at,
            'submit_at' => $this->submit_at,
            'updated_at' => $this->updated_at,
			'claim.status' => $this->status
        ]);

		$query->andFilterWhere(['like', 'user.fullname', $this->fasi_name]);

        return $dataProvider;
    }
}
