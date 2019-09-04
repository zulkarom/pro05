<?php

namespace backend\modules\esiap\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\esiap\models\Course;

/**
 * CourseSearch represents the model behind the search form of `backend\modules\esiap\models\Course`.
 */
class CourseSearch extends Course
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'credit_hour'], 'integer'],
            [['course_code', 'course_name', 'course_name_bi'], 'safe'],
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
        $query = Course::find();

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
            'credit_hour' => $this->credit_hour,
        ]);

        $query->andFilterWhere(['like', 'course_code', $this->course_code])
            ->andFilterWhere(['like', 'course_name', $this->course_name])
            ->andFilterWhere(['like', 'course_name_bi', $this->course_name_bi]);

        return $dataProvider;
    }
}
