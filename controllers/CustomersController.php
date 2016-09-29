<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use app\models\Customers;
use app\models\Addresses;
use app\models\Companies;
use app\models\Contacts;
use app\models\Estimates;
use app\models\EstimatesSearch;
use app\models\CompanyLocations;
use app\models\LocationContacts;
use app\models\CustomersSearch;
use yii\web\Controller;
use app\models\DynamicForms;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Query ;
/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class CustomersController extends Controller
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
     * Lists all Customers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customers model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       
        
        $model =Customers::find()->where(['customer_id'=>$id])->one(); 

        $model =Customers::find()->joinWith(['addresses'])->where(['customer_id'=>$id])->one();

        $companies = Companies::find()->with(['companyLocations'])->joinWith(['addresses'])
                                      ->where(['customer_id'=>$id])->all();
     

        /*$jobOrdersProvider = new SqlDataProvider(
            ['sql' => Customers::FindAllJobOrdersSql(),
            'params' => [':id' => $id],
            'totalCount' => count(Customers::FindAllJobOrdersSql()),
            'pagination' => ['pageSize' =>5],
          ]);
        
        $dataProvider = new SqlDataProvider(
            ['sql' => Customers::FindAllEstimateSql(),
            'params' => [':id' => $id],
            'totalCount' => count(Customers::FindAllJobOrdersSql()),
            'pagination' => ['pageSize' =>5],
          ]);

        $companiesDataProvider = new SqlDataProvider(
            ['sql' => Customers::FindAllCompanySql(),
            'params' => [':id' => $id],
            'totalCount' =>  count(Customers::FindAllCompanySql()),
            'pagination' => ['pageSize' =>6],
          ]);*/

       
        return $this->render('customer-profile', [
            'id' => $id,
            'model' => $model,
            'companies'=>$companies,
            /*'dataProvider' => $dataProvider,
            'jobOrdersProvider' => $jobOrdersProvider,
            'companiesDataProvider' => $companiesDataProvider,*/
        ]);
    }

    public function actionEstimateStatus($id, $status)
    {
        Estimates::ChangeStatus($id, $status);

        $searchModel = new EstimatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $potentialWork = $searchModel->searchPotentialWork(Yii::$app->request->queryParams);
    
        $jobOrders  =$searchModel->searchJobOrders(Yii::$app->request->queryParams);
        $declinedWork=$searchModel->searchDeclinedWork(Yii::$app->request->queryParams);
        $workInvoice  =$searchModel->searchInvoicedWork(Yii::$app->request->queryParams);
        $closedWork  =$searchModel->searchClosedWork(Yii::$app->request->queryParams);

 
        return $this->render('..\estimates\index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'potentialWork' => $potentialWork,
            'declinedWork' => $declinedWork,
            'jobOrders' => $jobOrders,
            'workInvoice'=>$workInvoice,
            'closedWork' => $closedWork
        ]);
    }

    /**
     * Creates a new Customers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($custType)
    {
        $model = new Customers();
		$companies = [new Companies()];
		$companyLocations[] = [new CompanyLocations()];
		$model->customer_type = $custType;
        if($model->load(Yii::$app->request->post())) {
           
            $valid = $model->validate();
            if($model->customer_type=='Commercial')
            {
                
                $companies = DynamicForms::createMultiple(Companies::classname());
                DynamicForms::loadMultiple($companies, Yii::$app->request->post());
                   
    			$loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];
                

    			for ($i=0; $i<count($companies); $i++) {
    				$loadsData['CompanyLocations'] =  Yii::$app->request->post()['CompanyLocations'][$i];
    				$companyLocations[$i] = DynamicForms::createMultiple(CompanyLocations::classname(),[] ,$loadsData);
    				DynamicForms::loadMultiple($companyLocations[$i], $loadsData);
    				
    			}

                $model->status = 'active';
                   
                // validate all models
                //$valid = Model::validateMultiple($estimatedAreas) &&  Model::validateMultiple($productUsedPerAreas) && $valid;

     
                if ($valid) {
                        try {
                            $transaction = \Yii::$app->db->beginTransaction();
                            if ($flag = $model->save(false)) {
                                foreach ($companies as $i => $company) {
                                    $company->customer_id = $model->customer_id;
                                    if (! ($flag = $company->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
        							else{
        								 foreach ($companyLocations[$i] as $x => $companyLocation) {
        									   $companyLocation->company_id = $company->company_id;
            									if (! ($flag = $companyLocation->save(false))) {
            										$transaction->rollBack();
                                           
            										break;
            									}
        									
        									}
        									
                                        }
        							}
                                }
                            
                        if ($flag) {
                            $transaction->commit();
                        }
                    }
                    catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
                
            }
            else
            {
                 $flag = $model->save(false);
            }
            if ($flag) {
                return $this->redirect(['view', 'id' => $model->customer_id]);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
				'companies' => (empty($companies)) ? [new Companies] : $companies,
				'companyLocations' => (empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
            
            ]);
        }
    }

    /**
     * Updates an existing Customers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   
    
    public function actionUpdate($id = 7)
    {
        $model = $this->findModel($id);
        
        $companies =  Companies::findAll(['customer_id' => $model->customer_id]);
        $companies = (empty($companies)) ? [new Companies] : $companies;

        foreach ($companies as $i => $company) {
            $oldLoads = CompanyLocations::findAll(['company_id' => $company->company_id]);
            $companyLocations[$i] = $oldLoads;
            $companyLocations[$i] = (empty($companyLocations[$i])) ? [new CompanyLocations] : $companyLocations[$i];
        }
        
       if($model->load(Yii::$app->request->post())) {
           
            $valid = $model->validate();
            if($model->customer_type=='Commercial')
            {
                
                $companies = DynamicForms::createMultiple(Companies::classname());
                DynamicForms::loadMultiple($companies, Yii::$app->request->post());
                   
                $loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];
                

                for ($i=0; $i<count($companies); $i++) {
                    $loadsData['CompanyLocations'] =  Yii::$app->request->post()['CompanyLocations'][$i];
                    $companyLocations[$i] = DynamicForms::createMultiple(CompanyLocations::classname(),[] ,$loadsData);
                    DynamicForms::loadMultiple($companyLocations[$i], $loadsData);
                    
                }

                $model->status = 'active';
                // validate all models
                //$valid = Model::validateMultiple($estimatedAreas) &&  Model::validateMultiple($productUsedPerAreas) && $valid;

                if ($valid) {
                        try {
                            $transaction = \Yii::$app->db->beginTransaction();

                             \Yii::$app->db->createCommand()->delete('companies', ['customer_id' => $model->customer_id])->execute();
                             \Yii::$app->db->createCommand()->delete('company_locations', ['company' => $companyLocations[0]->company_id])->execute();
                      
                            if ($flag = $model->save(false)) {
                                foreach ($companies as $i => $company) {
                                    $company->customer_id = $model->customer_id;
                                    if (! ($flag = $company->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                    else{
                                         foreach ($companyLocations[$i] as $x => $companyLocation) {
                                               $companyLocation->company_id = $company->company_id;
                                                if (! ($flag = $companyLocation->save(false))) {
                                                    $transaction->rollBack();
                                           
                                                    break;
                                                }
                                            
                                            }
                                            
                                        }
                                    }
                                }
                            
                        if ($flag) {
                            $transaction->commit();
                        }
                    }
                    catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
                
            }
            else
            {
                 $flag = $model->save(false);
            }
            if ($flag) {
                return $this->redirect(['view', 'id' => $model->customer_id]);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'companies' => (empty($companies)) ? [new Companies] : $companies,
                'companyLocations' => (empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
            
            ]);
        }
    }
    public function actionCustomerType()
    {
            return $this->renderAjax('customer-type-selection', []);
    }
    /**
     * Deletes an existing Customers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	public function actionNewAddress()
    {
        $model = new Addresses();
        

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                echo 1;
            }
            else{
                echo 0;
            }
        } else {
            return $this->renderAjax('/addresses/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCustomerDashboard()
    {
            return $this->renderAjax('customer-dashboard', [
                'model' => $model,
            ]);
    }

    
    /**
     * Finds the Customers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

   
	
	
}
