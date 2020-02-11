<?php

namespace backend\modules\esiap\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\esiap\models\CourseVersion;

/**
 * CourseVersionSearch represents the model behind the search form of `backend\modules\esiap\models\CourseVersion`.
 */
class CourseVersionSearch extends CourseVersion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'created_by', 'is_developed'], 'integer'],
            [['version_name', 'created_at', 'updated_at'], 'safe'],
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
    public function search($course, $params)
    {
        $query = CourseVersion::find()->where(['course_id' => $course]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
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
            'course_id' => $this->course_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_developed' => $this->is_developed,
        ]);

        $query->andFilterWhere(['like', 'version_name', $this->version_name]);

        return $dataProvider;
    }
}
