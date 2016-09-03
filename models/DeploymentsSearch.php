<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Deployments;

/**
 * DeploySearch represents the model behind the search form about `backend\models\Deploy`.
 */
class DeploymentsSearch extends Deployments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deploy_id', 'estimated_area_id', 'equipment_id'], 'integer'],
            [['deploy_date', 'deploy_notes'], 'safe'],
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
        $query = Deployments::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        //$query->joinWith('');

        $query->andFilterWhere([
            'deploy_id' => $this->deploy_id,
            'estimated_area_id' => $this->estimated_area_id,
            //'area_id' => $this->area_id,
            'equipment_id' => $this->equipment_id,
            'deploy_date' => $this->deploy_date,
        ]);

       /* $query->andFilterWhere(['like', 'deploy_notes', $this->deploy_notes])
                ->andFilterWhere(['like', 'area.area_name', $this->area_id]);*/

        return $dataProvider;
    }
}
