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

    /**
     * Creates a new Estimates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionPreview($id=1)
    {

       $estimates = Estimates::FindEstimateSql($id);
     
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
        
        $serviceEstimates = ServiceEstimates::findAll(['estimate_id' => $id]);
        $serviceEstimates = (empty($serviceEstimates)) ? [new ServiceEstimates] : $serviceEstimates;

        $estimatedAreas =  EstimatedAreas::findAll(['estimate_id' => $id]);
        $estimatedAreas = (empty($estimatedAreas)) ? [new EstimatedAreas] : $estimatedAreas;
        
        foreach ($estimatedAreas as $i => $estimatedArea) {
            $oldLoads = ProductsUsedPerArea::findAll(['estimated_area_id' => $estimatedArea->estimated_area_id]);
            $productUsedPerAreas[$i] = $oldLoads;
            $productUsedPerAreas[$i] = (empty($productUsedPerAreas[$i])) ? [new ProductsUsedPerArea] : $productUsedPerAreas[$i];
        }
        
        if ($model->load(Yii::$app->request->post())) {
            
            $estimatedAreas = DynamicForms::createMultiple(EstimatedAreas::classname());
            DynamicForms::loadMultiple($estimatedAreas, Yii::$app->request->post());
            
            $serviceEstimates = DynamicForms::createMultiple(ServiceEstimates::classname());
            DynamicForms::loadMultiple($serviceEstimates, Yii::$app->request->post());

            $loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];
            for ($i=0; $i<count($estimatedAreas); $i++) {
                $loadsData['ProductsUsedPerArea'] =  Yii::$app->request->post()['ProductsUsedPerArea'][$i];
                $productUsedPerAreas[$i] = DynamicForms::createMultiple(ProductsUsedPerArea::classname(),[] ,$loadsData);
                DynamicForms::loadMultiple($productUsedPerAreas[$i], $loadsData);
            }
               

            // validate all models
            $valid = $model->validate();
            //$valid = Model::validateMultiple($estimatedAreas) &&  Model::validateMultiple($productUsedPerAreas) && $valid;

         if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                     \Yii::$app->db->createCommand()->delete('service_estimates', ['estimate_id' => $id])->execute();
                     \Yii::$app->db->createCommand()->delete('estimated_areas', ['estimate_id' => $id])->execute();
                      
                    if ($flag = $model->save(false)) {
                        foreach ($estimatedAreas as $i => $estimatedArea) {
                            $estimatedArea->estimate_id = $model->estimate_id;
                            if (! ($flag = $estimatedArea->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            else{
                                 foreach ($productUsedPerAreas[$i] as $x => $productUsedPerArea) {
                                    $productUsedPerArea->estimated_area_id = $estimatedArea->estimated_area_id;
                                    if (! ($flag = $productUsedPerArea->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                    
                                }
                            }
                        }
                        foreach ($serviceEstimates as $i => $serviceEstimate) {
                            $serviceEstimate->estimate_id = $model->estimate_id;
                            if (! ($flag = $serviceEstimate->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['preview']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        else{
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
