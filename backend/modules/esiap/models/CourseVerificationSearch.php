<?php

namespace backend\modules\esiap\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\esiap\models\CourseVersion;

/**
 * CourseSearch represents the model behind the search form of `backend\modules\esiap\models\Course`.
 */
class CourseVerificationSearch extends CourseVersion
{
	public $search_course;
	public $search_cat;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search_course'], 'string'],
			
			[['search_cat'], 'integer'],
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
        $query = CourseVersion::find()
		->joinWith(['course'])
		->where([
		'status' => [10, 20]
		])
		->orderBy('status ASC, prepared_at DESC')
		;

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
		
		// grid filtering conditions
        
		
		if(Yii::$app->params['faculty_id']== 21){
			$query->andFilterWhere(['like', 'sp_course.component_id', $this->search_cat]);
		}else{
			$query->andFilterWhere(['=', 'sp_course.program_id', $this->search_cat]);
		}
		
		$query->andFilterWhere(['or', 
            ['like', 'sp_course.course_name', $this->search_course],
            ['like', 'sp_course.course_name_bi', $this->search_course],
			['like', 'sp_course.course_code', $this->search_course]
        ]);


        return $dataProvider;
    }
}
