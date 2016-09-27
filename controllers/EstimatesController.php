<?php

namespace app\controllers;

use Yii;
use app\models\Estimates;
use app\models\EstimatedAreas;
use app\models\ProductServices;
use app\models\Companies;
use app\models\Products;
use app\models\Customers;
use app\models\DynamicForms;
use app\models\EstimatesSearch;
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
class EstimatesController extends Controller
{
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Estimates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstimatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $potentialWork = $searchModel->searchPotentialWork(Yii::$app->request->queryParams);
    
        $jobOrders  =$searchModel->searchJobOrders(Yii::$app->request->queryParams);
        $declinedWork=$searchModel->searchDeclinedWork(Yii::$app->request->queryParams);
        $workInvoice  =$searchModel->searchInvoicedWork(Yii::$app->request->queryParams);
        $closedWork  =$searchModel->searchClosedWork(Yii::$app->request->queryParams);

        /*
           $potentialWork->query->count();
           gets the overall number of potential work for estimates.
           Will be used to generate the badges for the tabs.
        */
 
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'potentialWork' => $potentialWork,
            'declinedWork' => $declinedWork,
            'jobOrders' => $jobOrders,
            'workInvoice'=>$workInvoice,
            'closedWork' => $closedWork
        ]);
    }

     public function actionPdf() {
      $mpdf=new mPDF();
      $mpdf->WriteHTML($this->renderPartial('estimate-pdf'));
      $mpdf->Output('MyPDF.pdf', 'D');
      exit;
     }
    /**
     * Displays a single Estimates model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

     public function actionSchedules()
    {
        $unschedules = \Yii::$app->db->createCommand("SELECT company_name as `name`, es.estimate_id FROM customers cu inner join companies on companies.customer_id = cu.customer_id  inner JOIN company_locations on company_locations.company_id = companies.company_id
                                                      inner JOIN areas a on a.company_location_id = company_locations.company_location_id 
                                                      inner JOIN estimated_areas ea on ea.area_id = a.area_id inner join estimates es on 
                                                      ea.estimate_id = es.estimate_id where es.status_id = 3 and es.schedule_date_time is null union select concat(c.customer_firstname,' ',c.customer_lastname) as `name`, 
                                                      et.estimate_id from customers c inner join areas ar on ar.customer_id = c.customer_id inner join 
                                                      estimated_areas ae on ae.area_id = ar.area_id inner join estimates et on et.estimate_id = ae.estimate_id
                                                      where et.status_id = 3 and et.schedule_date_time is null")->queryAll();
        $results =  \Yii::$app->db->createCommand("SELECT company_name as `name`, es.estimate_id, schedule_date_time, schedule_end_date FROM customers cu inner join companies on companies.customer_id = cu.customer_id  inner JOIN company_locations on company_locations.company_id = companies.company_id
                                                      inner JOIN areas a on a.company_location_id = company_locations.company_location_id 
                                                      inner JOIN estimated_areas ea on ea.area_id = a.area_id inner join estimates es on 
                                                      ea.estimate_id = es.estimate_id where es.status_id = 3 and es.schedule_date_time is not null union select concat(c.customer_firstname,' ',c.customer_lastname) as `name`, 
                                                      et.estimate_id, schedule_date_time, schedule_end_date from customers c inner join areas ar on ar.customer_id = c.customer_id inner join 
                                                      estimated_areas ae on ae.area_id = ar.area_id inner join estimates et on et.estimate_id = ae.estimate_id
                                                      where et.status_id = 3 and et.schedule_date_time is not null")->queryAll();

        
        $schedules = array();

         foreach($results as $i => $e ){
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $e['estimate_id'];
            $Event->title = $e['name'];
            $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($e['schedule_date_time']));
            $Event->end = date('Y-m-d\TH:i:s\Z',strtotime($e['schedule_end_date']));
            $Event->startEditable = true;
            $Event->durationEditable = true;
            $Event->color = 'red';
            $Event->url = 'index.php?r=estimates/preview&id='.$e['estimate_id'];
            $schedules[$i] = $Event;

        } 
       //var_dump($schedules);die();
        return $this->render('schedules', [
            'unschedules'=>$unschedules,
            'schedules'=>$schedules,
        ]);
    }

    public function actionSetSchedule($id, $startDate, $endDate)
    {
         \Yii::$app->db->createCommand("UPDATE estimates SET schedule_date_time=:date_time, schedule_end_date=:endDate WHERE estimate_id=:id")
          ->bindValues([':date_time'=> $startDate, ':endDate'=>$endDate, ':id'=>$id])
          ->execute();
    }
    /**
     * Creates a new Estimates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionPreview($id=1)
    {

       $estimates = Estimates::FindEstimateSql($id);
      // var_dump($estimates); die();
        return  $this->render('preview', [
            'id' => $id,
            'estimates' => $estimates,
        ]);
      
    }

    public function actionCreate($custId)
    {
        $model = new Estimates();
        $productServices = [new ProductServices()];
    		$estimatedAreas[] = [new EstimatedAreas()];
    		$productUsedPerAreas[][] = [new ProductsUsedPerArea()];
        $customer = Customers::findOne($custId);
		
        if ($model->load(Yii::$app->request->post())) {
			
			   $productServices = DynamicForms::createMultiple(ProductServices::classname());
         DynamicForms::loadMultiple($productServices, Yii::$app->request->post());
            
            //$serviceEstimates = DynamicForms::createMultiple(ServiceEstimates::classname());
           //DynamicForms::loadMultiple($serviceEstimates, Yii::$app->request->post());
          
    			$loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];

    			for ($i=0; $i<count($productServices); $i++) {
    				$loadsData['EstimatedAreas'] =  Yii::$app->request->post()['EstimatedAreas'][$i];
    				$estimatedAreas[$i] = DynamicForms::createMultiple(EstimatedAreas::classname(),[] ,$loadsData);
    				DynamicForms::loadMultiple($estimatedAreas[$i], $loadsData);
                    for($x=0; $x < count($estimatedAreas[$i]); $x++){
                        $loadsData['ProductsUsedPerArea'] =  Yii::$app->request->post()['ProductsUsedPerArea'][$i][$x];
                        $productUsedPerAreas[$i][$x] = DynamicForms::createMultiple(ProductsUsedPerArea::classname(),[] ,$loadsData);
                        DynamicForms::loadMultiple($productUsedPerAreas[$i][$x] , $loadsData);
                    }
    			}
               
          $model->status_id = 1;
          // validate all models
          $valid = $model->validate();
          //$valid = Model::validateMultiple($estimatedAreas) &&  Model::validateMultiple($productUsedPerAreas) && $valid;

          if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                      foreach ($productServices as $i => $productService) {    
                                              
                        foreach ($estimatedAreas[$i] as $x => $estimatedArea) {
                            $estimatedArea->estimate_id = $model->estimate_id;
                            if (! ($flag = $estimatedArea->save(false))) {
                                $transaction->rollBack();
                                break;
                        }
          							else{
          								 foreach ($productUsedPerAreas[$i][$x] as $j => $productUsedPerArea) {
                                $product = Products::findOne($productUsedPerArea->product_id);
                                $productUsedPerArea->product_cost_at_time = $product->product_cost;
          									    $productUsedPerArea->estimated_area_id = $estimatedArea->estimated_area_id;
              									if (! ($flag = $productUsedPerArea->save(false))) {
              										$transaction->rollBack();
              										break;
              									}
                            }
          							 }
                      }
                        
                    }
                        
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['preview', 'id'=>$model->estimate_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        
        } else {
            return $this->render('create', [
                
                'customer'=> $customer,
                'model' => $model,
                'productServices' => (empty($productServices)) ? [new productServices] : $productServices,
                'estimatedAreas' => (empty($estimatedAreas)) ? [new EstimatedAreas] : $estimatedAreas,
		            'productUsedPerAreas' => (empty($productUsedPerAreas)) ? [new ProductsUsedPerArea] : $productUsedPerAreas,
            ]);
        }
    }

    /**
     * Updates an existing Estimates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id = 7)
    {
        $model = $this->findModel($id);
        

        $productUsedPerAreas[][] = [new ProductsUsedPerArea()];
        $customer = Customers::findOne($custId);

         $productServices = DynamicForms::createMultiple(ProductServices::classname());
         DynamicForms::loadMultiple($productServices, Yii::$app->request->post());

        
         for ($i=0; $i<count($productServices); $i++) {
              $loadsData['EstimatedAreas'] =  Yii::$app->request->post()['EstimatedAreas'][$i];
              $estimatedAreas[$i] = DynamicForms::createMultiple(EstimatedAreas::classname(),[] ,$loadsData);
              DynamicForms::loadMultiple($estimatedAreas[$i], $loadsData);
              for($x=0; $x < count($estimatedAreas[$i]); $x++){
                  $loadsData['ProductsUsedPerArea'] =  Yii::$app->request->post()['ProductsUsedPerArea'][$i][$x];
                  $productUsedPerAreas[$i][$x] = DynamicForms::createMultiple(ProductsUsedPerArea::classname(),[] ,$loadsData);
                  DynamicForms::loadMultiple($productUsedPerAreas[$i][$x] , $loadsData);
              }
        
         }
            $custId = Estimates::FindCustomerId($id);
            $customer = Customers::findOne($custId);
           
            return $this->render('update', [
                'customer'=> $customer,
                'model' => $model,
                'serviceEstimates' => (empty($serviceEstimates)) ? [new ServiceEstimates] : $serviceEstimates,
                'estimatedAreas' => (empty($estimatedAreas)) ? [new EstimatedAreas] : $estimatedAreas,
                'productUsedPerAreas' => (empty($productUsedPerAreas)) ? [new ProductsUsedPerArea] : $productUsedPerAreas,
            
            ]);
       
    }

    

    /**
     * Deletes an existing Estimates model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionFindProductByService($id){

      return Estimates::FindProductByService($id);
    }
    /**
     * Finds the Estimates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Estimates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Estimates::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
