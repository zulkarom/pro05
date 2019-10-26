<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Application;

/**
 * ApplicationSearch represents the model behind the search form of `common\models\Application`.
 */
class OfferLetterSearch extends Application
{
	public $fasi_string;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['fasi_string'], 'string'],
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
		$sem = Semester::getCurrentSemester()->id;
		$query = Application::find();
		$query->joinWith(['fasi.user']);
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
            'semester_id' => $sem,
            'application.status' => ['ApplicationWorkflow/d-approved', 'ApplicationWorkflow/e-release', 'ApplicationWorkflow/f-accept'],
        ]);

        $query->andFilterWhere(['like', 'user.fullname', $this->fasi_string]);


        return $dataProvider;
    }
}
