<?php

namespace app\controllers;

use Yii;
use app\models\BsrHeader;
use app\models\Customers;
use app\models\EstimatedAreas;
use app\models\EstimatedAreasSearch;
use app\models\BsrActivity;
use app\models\Deployments;
use app\models\Equipment;
use app\models\BsrHeaderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\DynamicForms;
use yii\data\SqlDataProvider;

/**
 * BsrHeaderController implements the CRUD actions for BsrHeader model.
 */
class BsrHeaderController extends Controller
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
     * Lists all BsrHeader models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BsrHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
         $jobOrders= new SqlDataProvider(
            ['sql' => Customers::FindAllJobsSql(),
            'params' => [':s_id' => 3],
           // 'totalCount' => count(Customers::FindAllJobsSql()),
            'pagination' => ['pageSize' =>5],
          ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'jobOrders' => $jobOrders,
        ]);
    }


    public function actionEstAreaIndex($id=0)
    {
        $searchModel = new EstimatedAreasSearch();
        $dataProvider = $searchModel->searchEstimatedAreas(Yii::$app->request->queryParams,$id);
         
        return $this->render('est-area-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BsrHeader model.
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
     * Creates a new BsrHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = 0)
    {
        $model = new BsrHeader();
        $modelsBsrActivity = [new BsrActivity];
        $deployments = Deployments::find()->where(['estimated_area_id'=>$id])->all();
        if ($model->load(Yii::$app->request->post())) {
            
           
            $model->emp_id = 1;//Yii::$app->user->id;
            
            $modelsBsrActivity = DynamicForms::createMultiple(BsrActivity::classname());
            DynamicForms::loadMultiple($modelsBsrActivity, Yii::$app->request->post());
          
            $valid = $model->validate();
            //BSR fields are valid

            $valid = DynamicForms::validateMultiple($modelsBsrActivity) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsBsrActivity as $modelBsrActivity) {
                            $modelBsrActivity->bsr_id = $model->id;
                            if (! ($flag = $modelBsrActivity->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['est-area-index', 'id' => EstimatedAreas::findOne($id)->estimate_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
         //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //return $this->redirect(['view', 'id' => $model->bsr_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsBsrActivity' => (empty($modelsBsrActivity)) ? [new BsrActivity] : $modelsBsrActivity,
                'deployments' => $deployments
            ]);
        }
    }

    /**
     * Creates a new BsrHeader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDeploy($id = 0)
    {
        $models = [new Deployments];

        //get only equipments that have not been deployed
        $equipments = Equipment::find()->join('left join', 'deployments','equipment.equipment_id = 
                                deployments.equipment_id')->where(['deployments.equipment_id'=> null])->all();
        
        if (Yii::$app->request->post()) {
            
           $models = DynamicForms::createMultiple(Deployments::classname());
           DynamicForms::loadMultiple($models, Yii::$app->request->post());


            $valid =DynamicForms::validateMultiple($models);
            $valid = $valid && (isset(Yii::$app->request->post()['check']))?true: false;
            if ($valid) {
               $transaction = \Yii::$app->db->beginTransaction();
               $flag = false;
                foreach ($models as $index => $model) {
                    if(array_search($index,array_keys(Yii::$app->request->post()['check'])) !== false){
                      
                            $model->estimated_area_id = $id;
                            if (! ($flag = $model->save(false))) {
                                $transaction->rollBack();
                                break;
                            
                       }
                   }
                }
            
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['est-area-index', 'id' 
                                           => EstimatedAreas::findOne($id)->estimate_id]);
                }
               
            }
            else {
                $err = 1;
                return $this->render('deploy', [
                    'err' =>$err,
                    'models' =>(empty($models)) ? [new Deployments] : $models,
                    'equipments' => $equipments,
                ]);
            }
            
        } else {
            return $this->render('deploy', [
                'models' =>(empty($models)) ? [new Deployments] : $models,
                'equipments' => $equipments,
            ]);
        }
    }

    /**
     * Updates an existing BsrHeader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id=0, $es_area_id=0)
    {
        $model = $this->findModel($id);
        $modelsBsrActivity = $model->bsr_id;
        $deployments = Deployments::find()->where(['estimated_area_id'=>$es_area_id])->all();

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBsrActivity, 'id', 'id');
            $modelsBsrActivity = DynamicForms::createMultiple(BsrActivity::classname(), $modelsBsrActivity);
            DynamicForms::loadMultiple($modelsBsrActivity, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBsrActivity, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = DynamicForms::validateMultiple($modelsBsrActivity) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                        }
                        foreach ($modelsBsrActivity as $modelBsrActivity) {
                            $modelBsrActivity->bsr_id = $model->id;
                            if (! ($flag = $modelBsrActivity->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['est-area-index', 'id' => EstimatedAreas::findOne($id)->estimate_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }


//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->bsr_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsBsrActivity' => (empty($modelsBsrActivity)) ? [new Address] : $modelsBsrActivity,
                'deployments' => $deployments

            ]);
        }
    }

    /**
     * Deletes an existing BsrHeader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BsrHeader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BsrHeader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BsrHeader::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
