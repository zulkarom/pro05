<?php

namespace backend\modules\esiap\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\esiap\models\ProgramVersion;

/**
 * ProgramVersionSearch represents the model behind the search form of `backend\modules\esiap\models\ProgramVersion`.
 */
class ProgramVersionSearch extends ProgramVersion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'program_id', 'status', 'plo_num', 'is_developed', 'is_published', 'trash', 'created_by', 'prepared_by', 'verified_by'], 'integer'],
            [['version_name', 'created_at', 'updated_at', 'prepared_at', 'verified_at', 'faculty_approve_at', 'senate_approve_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($program, $params)
    {
        $query = ProgramVersion::find()->where(['program_id' => $program]);

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
            'program_id' => $this->program_id,
            'status' => $this->status,
            'is_developed' => $this->is_developed,
            'is_published' => $this->is_published,
            'trash' => $this->trash,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'prepared_by' => $this->prepared_by,
            'prepared_at' => $this->prepared_at,
            'verified_by' => $this->verified_by,
            'verified_at' => $this->verified_at,
            'faculty_approve_at' => $this->faculty_approve_at,
            'senate_approve_at' => $this->senate_approve_at,
        ]);

        $query->andFilterWhere(['like', 'version_name', $this->version_name]);

        return $dataProvider;
    }
}
