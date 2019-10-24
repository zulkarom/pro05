<?php

namespace backend\modules\project\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\project\models\Coordinator;
use backend\models\Semester;

/**
 * CoordinatorSearch represents the model behind the search form of `backend\modules\project\models\Coordinator`.
 */
class CoordinatorSearch extends Coordinator
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'semester_id', 'fasi_id', 'course_id', 'group_id'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = Coordinator::find()->where(['semester_id' => $semester->id]);
		$query->joinWith(['fasi', 'course', 'group']);

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'semester_id' => $this->semester_id,
            'fasi_id' => $this->fasi_id,
            'course_id' => $this->course_id,
            'group_id' => $this->group_id,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
