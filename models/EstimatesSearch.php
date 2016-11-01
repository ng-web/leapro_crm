<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Estimates;
use app\models\Assigments;

/**
 * EstimatesSearch represents the model behind the search form about `app\models\Estimates`.
 */
class EstimatesSearch extends Estimates
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estimate_id','campaign_id', 'status_id'], 'integer'],
            [['schedule_date_time'], 'string'],
            [['received_date', 'confirmed_date', 'schedule_date_time'], 'safe'],
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
        $query = Estimates::find();

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
            'estimate_id' => $this->estimate_id,
            'campaign_id' => $this->campaign_id,
            'status_id' => $this->status_id,
            'received_date' => $this->received_date,
            'confirmed_date' => $this->confirmed_date,
            'schedule_date_time' => $this->schedule_date_time,
        ]);

        return $dataProvider;
    }

    public function searchPotentialWork($params)
    {
       $potentialWorkQuery =Estimates::Find()->where(['status_id'=>1]);
 
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
          'query' => $potentialWorkQuery,
          'pagination' => [
              'pageSize' => 10,
          ],
          
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $potentialWorkQuery->andFilterWhere([
            'estimate_id' => $this->estimate_id,
            'campaign_id' => $this->campaign_id,
            'status_id' => $this->status_id,
            'received_date' => $this->received_date,
            'confirmed_date' => $this->confirmed_date,
            'schedule_date_time' => $this->schedule_date_time,
        ]);

        return $dataProvider;
    }

    public function searchPastAssignments($params)
    {
       $assignmentQuery = Assignments::find()->joinWith('estimate')->where(["<", 'estimates.schedule_date_time', date("Y-m-d h:i:s")]);
 
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
          'query' => $assignmentQuery,
          'pagination' => [
              'pageSize' => 10,
          ],
          
        ]);

        //$this->load($params);
        // $this->schedule_date_time = $_GET['schedule_date_time'];
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $assignmentQuery->andFilterWhere([
            'estimate.estimate_id' => $this->estimate_id,
            'estimate.schedule_date_time' => $this->schedule_date_time,
        ]);

         $assignmentQuery->andFilterWhere(['like', 'schedule_date_time', $this->schedule_date_time]);

        return $dataProvider;
    }

     public function searchRecentAssignments($params)
    {
       $assignmentQuery = Assignments::find()->joinWith('estimate')->where([">", 'estimates.schedule_date_time', date("Y-m-d h:i:s")]);
 
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
          'query' => $assignmentQuery,
          'pagination' => [
              'pageSize' => 10,
          ],
          
        ]);

        //$this->load($params);
        // $this->schedule_date_time = $_GET['schedule_date_time'];
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $assignmentQuery->andFilterWhere([
            'estimate.estimate_id' => $this->estimate_id,
            'estimate.schedule_date_time' => $this->schedule_date_time,
        ]);

         //$query->andFilterWhere(['like', 'schedule_date_time', $this->username]);

        return $dataProvider;
    }
    public function searchJobOrders($params)
    {
       $jobOrdersQuery    =Estimates::Find()->where(['status_id'=>3])->orderBy('estimate_id','ASC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
          'query' => $jobOrdersQuery ,
          'pagination' => [
              'pageSize' => 10,
          ],
          
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $jobOrdersQuery ->andFilterWhere([
            'estimate_id' => $this->estimate_id,
            'campaign_id' => $this->campaign_id,
            'status_id' => $this->status_id,
            'received_date' => $this->received_date,
            'confirmed_date' => $this->confirmed_date,
            'schedule_date_time' => $this->schedule_date_time,
        ]);

        return $dataProvider;
    }

    public function searchDeclinedWork($params)
    {
       $declinedWorkQuery  =Estimates::Find()->where(['status_id'=>2]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
          'query' => $declinedWorkQuery ,
          'pagination' => [
              'pageSize' => 10,
          ],
          
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $declinedWorkQuery ->andFilterWhere([
            'estimate_id' => $this->estimate_id,
            'campaign_id' => $this->campaign_id,
            'status_id' => $this->status_id,
            'received_date' => $this->received_date,
            'confirmed_date' => $this->confirmed_date,
            'schedule_date_time' => $this->schedule_date_time,
        ]);

        return $dataProvider;
    }

    public function searchInvoicedWork($params)
    {
        $workInvoiceQuery  =Estimates::Find()->where(['status_id'=>4]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
          'query' => $workInvoiceQuery ,
          'pagination' => [
              'pageSize' => 10,
          ],
          
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $workInvoiceQuery ->andFilterWhere([
            'estimate_id' => $this->estimate_id,
            'campaign_id' => $this->campaign_id,
            'status_id' => $this->status_id,
            'received_date' => $this->received_date,
            'confirmed_date' => $this->confirmed_date,
            'schedule_date_time' => $this->schedule_date_time,
        ]);

        return $dataProvider;
    }

    public function searchClosedWork($params)
    {
        $closedWorkQuery   =Estimates::Find()->where(['status_id'=>5]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
          'query' => $closedWorkQuery ,
          'pagination' => [
              'pageSize' => 10,
          ],
          
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $closedWorkQuery ->andFilterWhere([
            'estimate_id' => $this->estimate_id,
            'campaign_id' => $this->campaign_id,
            'status_id' => $this->status_id,
            'received_date' => $this->received_date,
            'confirmed_date' => $this->confirmed_date,
            'schedule_date_time' => $this->schedule_date_time,
        ]);

        return $dataProvider;
    }
}
