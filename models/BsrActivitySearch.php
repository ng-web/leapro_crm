<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BsrActivity;

/**
 * BsrActivitySearch represents the model behind the search form about `backend\models\BsrActivity`.
 */
class BsrActivitySearch extends BsrActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bs_id', 'bs_status', 'bs_qty', 'weight', 'number_seen', 'bs_condition'], 'integer'],
            [['bs_comments', 'bs_date', 'equipment_id', 'employee_id',], 'safe'],
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
        $query = BsrActivity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 15
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
       // $query->joinWith('equipment');
        $query->joinWith('employee');

        $query->andFilterWhere([
            'bs_id' => $this->bs_id,
            'bs_status' => $this->bs_status,
            'bs_qty' => $this->bs_qty,
            'weight' => $this->weight,
            'number_seen' => $this->number_seen,
            'bs_condition' => $this->bs_condition,
            'bs_date' => $this->bs_date,
        ]);

        $query->andFilterWhere(['like', 'bs_comments', $this->bs_comments])
                //->andFilterWhere(['like', 'equipment.equipment_name', $this->equipment_id])
                ->andFilterWhere(['like', 'bsr_docnum', $this->bsr_docnum])
                ->andFilterWhere(['like', 'employee.employee_name', $this->employee_id]);

        return $dataProvider;
    }
}
