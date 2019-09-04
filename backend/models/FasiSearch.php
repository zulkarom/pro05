<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Fasi;

/**
 * FasiSearch represents the model behind the search form of `common\models\Fasi`.
 */
class FasiSearch extends Fasi
{
	public $fullname;
	public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname', 'nric', 'email'], 'string'],

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
        $query = Fasi::find();
		$query->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'address_postal', $this->address_postal])
            ->andFilterWhere(['like', 'path_file', $this->path_file]);
			
		$dataProvider->sort->attributes['fullname'] = [
        'asc' => ['user.fullname' => SORT_ASC],
        'desc' => ['user.fullname' => SORT_DESC],
		]; 
		
		$query->andFilterWhere(['like', 'user.fullname', $this->fullname]);


        return $dataProvider;
    }
}
