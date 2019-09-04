<?php

namespace backend\modules\esiap\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\esiap\models\Program;

/**
 * ProgramSearch represents the model behind the search form of `backend\modules\esiap\models\Program`.
 */
class ProgramSearch extends Program
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pro_level', 'faculty', 'department', 'status', 'pro_cat', 'pro_field', 'grad_credit', 'study_mode', 'full_week_long', 'full_week_short', 'full_sem_long', 'full_sem_short', 'part_week_long', 'part_week_short', 'part_sem_long', 'part_sem_short', 'trash'], 'integer'],
            [['pro_name', 'pro_name_bi', 'pro_name_short', 'prof_body', 'coll_inst', 'sesi_start', 'pro_sustain', 'synopsis', 'synopsis_bi', 'objective', 'just_stat', 'just_industry', 'just_employ', 'just_tech', 'just_others', 'nec_perjawatan', 'nec_fizikal', 'nec_kewangan', 'kos_yuran', 'kos_beven', 'pro_tindih_pub', 'pro_tindih_pri', 'jumud', 'admission_req', 'admission_req_bi', 'career', 'career_bi'], 'safe'],
            [['full_time_year', 'full_max_year', 'part_max_year', 'part_time_year'], 'number'],
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
         $query = Program::find()->where(['faculty' => 1, 'trash' => 0])->orderBy('status DESC');

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
            'pro_level' => $this->pro_level,
            'faculty' => $this->faculty,
            'department' => $this->department,
            'status' => $this->status,
            'pro_cat' => $this->pro_cat,
            'pro_field' => $this->pro_field,
            'grad_credit' => $this->grad_credit,
            'study_mode' => $this->study_mode,
            'full_week_long' => $this->full_week_long,
            'full_week_short' => $this->full_week_short,
            'full_sem_long' => $this->full_sem_long,
            'full_sem_short' => $this->full_sem_short,
            'part_week_long' => $this->part_week_long,
            'part_week_short' => $this->part_week_short,
            'part_sem_long' => $this->part_sem_long,
            'part_sem_short' => $this->part_sem_short,
            'full_time_year' => $this->full_time_year,
            'full_max_year' => $this->full_max_year,
            'part_max_year' => $this->part_max_year,
            'part_time_year' => $this->part_time_year,
            'trash' => $this->trash,
        ]);

        $query->andFilterWhere(['like', 'pro_name', $this->pro_name])
            ->andFilterWhere(['like', 'pro_name_bi', $this->pro_name_bi])
            ->andFilterWhere(['like', 'pro_name_short', $this->pro_name_short])
            ->andFilterWhere(['like', 'prof_body', $this->prof_body])
            ->andFilterWhere(['like', 'coll_inst', $this->coll_inst])
            ->andFilterWhere(['like', 'sesi_start', $this->sesi_start])
            ->andFilterWhere(['like', 'pro_sustain', $this->pro_sustain])
            ->andFilterWhere(['like', 'synopsis', $this->synopsis])
            ->andFilterWhere(['like', 'synopsis_bi', $this->synopsis_bi])
            ->andFilterWhere(['like', 'objective', $this->objective])
            ->andFilterWhere(['like', 'just_stat', $this->just_stat])
            ->andFilterWhere(['like', 'just_industry', $this->just_industry])
            ->andFilterWhere(['like', 'just_employ', $this->just_employ])
            ->andFilterWhere(['like', 'just_tech', $this->just_tech])
            ->andFilterWhere(['like', 'just_others', $this->just_others])
            ->andFilterWhere(['like', 'nec_perjawatan', $this->nec_perjawatan])
            ->andFilterWhere(['like', 'nec_fizikal', $this->nec_fizikal])
            ->andFilterWhere(['like', 'nec_kewangan', $this->nec_kewangan])
            ->andFilterWhere(['like', 'kos_yuran', $this->kos_yuran])
            ->andFilterWhere(['like', 'kos_beven', $this->kos_beven])
            ->andFilterWhere(['like', 'pro_tindih_pub', $this->pro_tindih_pub])
            ->andFilterWhere(['like', 'pro_tindih_pri', $this->pro_tindih_pri])
            ->andFilterWhere(['like', 'jumud', $this->jumud])
            ->andFilterWhere(['like', 'admission_req', $this->admission_req])
            ->andFilterWhere(['like', 'admission_req_bi', $this->admission_req_bi])
            ->andFilterWhere(['like', 'career', $this->career])
            ->andFilterWhere(['like', 'career_bi', $this->career_bi]);

        return $dataProvider;
    }
}
