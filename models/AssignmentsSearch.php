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
class AssignmentsSearch extends Assignments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['estimates.schedule_date_time'], 'string'],
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


    public function searchPastAssignments($params)
    {
       $assignmentQuery = Assignments::find()->select('*')->joinWith('estimate')->where(["<", 'estimates.schedule_date_time', date("Y-m-d h:i:s")]);
 
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
           // 'estimate.estimate_id' => $this->estimate_id,
           // 'estimate.schedule_date_time' => ,
        ]);
var_dump($this->estimate);
         //$assignmentQuery->andFilterWhere(['like', 'estimates.schedule_date_time', $this->estimate->schedule_date_time]);

        return $dataProvider;
    }

     public function searchRecentAssignments($params)
    {
       $assignmentQuery = Assignments::find()->joinWith('estimates')->where([">", 'estimates.schedule_date_time', date("Y-m-d h:i:s")]);
 
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
            'estimates.estimate_id' => $this->estimate_id,
            'estimates.schedule_date_time' => $this->schedule_date_time,
        ]);

         //$query->andFilterWhere(['like', 'schedule_date_time', $this->username]);

        return $dataProvider;
    }
  
  
}
