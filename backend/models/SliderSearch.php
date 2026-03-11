<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Slider;

class SliderSearch extends Slider
{
    public function rules()
    {
        return [
            [['id', 'button_type', 'sort_order', 'is_active'], 'integer'],
            [['heading_line1', 'heading_line2', 'heading_line3', 'image_path'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Slider::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['is_active' => SORT_DESC, 'sort_order' => SORT_ASC, 'id' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'button_type' => $this->button_type,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        $query
            ->andFilterWhere(['like', 'heading_line1', $this->heading_line1])
            ->andFilterWhere(['like', 'heading_line2', $this->heading_line2])
            ->andFilterWhere(['like', 'heading_line3', $this->heading_line3])
            ->andFilterWhere(['like', 'image_path', $this->image_path]);

        return $dataProvider;
    }
}
