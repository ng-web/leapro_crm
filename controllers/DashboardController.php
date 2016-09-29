<?php

namespace app\controllers;

use Yii;
use app\models\Estimates;
use app\models\EstimatedAreas;
use app\models\ProductServices;
use app\models\Companies;
use app\models\Products;
use app\models\ServiceEstimates;
use app\models\Customers;
use app\models\DynamicForms;
use app\models\EstimatesSearch;
use app\models\AssignmentsSearch;
use app\models\Employees;
use app\models\Assignments;
use app\models\ProductsUsedPerArea;
use app\models\ProductsPerEstimate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use mPDF;

/**
 * EstimatesController implements the CRUD actions for Estimates model.
 */
class DashboardController extends Controller
{
	
    

    
    public function actionIndex()
    {
        $data = \Yii::$app->db->createCommand("SELECT count(estimate_id) as `Total`, Month(received_date) as `date` 
                                               from estimates where status_id = 3 and  Year(received_date) = Year(NOW())   
                                               group by Month(received_date) order by `date` ASC")->queryAll();
        $declinedData = \Yii::$app->db->createCommand("SELECT count(estimate_id) as `Total`, Month(received_date) as `date` 
                                               from estimates where status_id = 2 and  Year(received_date) = Year(NOW())   
                                               group by Month(received_date) order by `date` ASC")->queryAll();
       $jobOrders = $this->setMonths($data);
       $declined = $this->setMonths($declinedData);
      //var_dump($newData);die();
        return $this->render('index', [
            'jobOrders' => $jobOrders,
            'declined' => $declined
        ]);
    }

    public function setMonths($data){
      $list = [];
       $found = 0;
        for($i=0; $i < 12; $i++){
          for($j=0; $j < count($data); $j++){
           if($i == $data[$j]['date']){
             $list[$i] = (int)$data[$j]['Total'];
             $found=1;
             break;
           }
           
          $found=0;
         }
         if($found == 0) $list[$i] = 0;
       }
       
      return $list;
    }


}
