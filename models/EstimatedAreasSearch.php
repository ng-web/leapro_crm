<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EstimatedAreas;

/**
 * EstimatedAreasSearch represents the model behind the search form of `app\models\EstimatedAreas`.
 */
class EstimatedAreasSearch extends EstimatedAreas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estimated_area_id', 'estimate_id', 'area_id'], 'integer'],
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
        $query = EstimatedAreas::find();

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
            'estimated_area_id' => $this->estimated_area_id,
            'estimate_id' => $this->estimate_id,
            'area_id' => $this->area_id,
        ]);

        return $dataProvider;
    }

    public function searchEstimatedAreas($params, $estimate_id)
    {
        $query = EstimatedAreas::find()->joinWith('area')->where(['estimate_id'=>$estimate_id]);

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
            'estimated_area_id' => $this->estimated_area_id,
        ]);
        
        //$query->andFilterWhere(['like', 'area.area_name', $thi]);

        return $dataProvider;
    }
}
