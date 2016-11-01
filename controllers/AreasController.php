<?php
namespace app\controllers;

use Yii;
use app\models\Areas;
use app\models\AreaUnits;
use app\models\DynamicForms;
use app\models\CompanyLocations;
use app\models\AreasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\json;


class AreasController extends Controller
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
     * Lists all Areas models.
     * @return mixed
     */
    public function actionIndex($id=1, $type=1)
    {
        $searchModel = new AreasSearch();
       
        
       if(Yii::$app->request->post('hasEditable')){
          

           $area_id = Yii::$app->request->post('editableKey');
           $areas = Areas::FindOne($area_id);
          
           $out = Json::encode(['output'=>'', 'message'=>'']);
           $post = [];
           $posted = current($_POST['Areas']);
           $post['Areas'] = $posted;
           
    
           if($areas->load($post)){
             $areas->save();
           }
           echo $out;
           return;
       }
       if($type == 1){
         $dataProvider = new ActiveDataProvider([
              'query' => Areas::find()->where(['company_location_id'=>$id]),
              'pagination' => [
                  'pageSize' => 10,
              ],
              
          ]);
       }
       else{
         $dataProvider = new ActiveDataProvider([
              'query' => Areas::find()->where(['customer_id'=>$id]),
              'pagination' => [
                  'pageSize' => 10,
              ],
              
          ]);
       }

     
       /*$dataProvider = new ArrayDataProvider([
            'allModels' => Areas::findAll(['company_location_id'=>$id]),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['company_location_id'],
            ],
        ]);*/
        $company_location_id = $id;
        return $this->render('index', [
            'company_location_id' => $company_location_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionSubAreaIndex($id)
    {
        $searchModel = new AreasSearch();
        
         $dataProvider = new ArrayDataProvider([
              'allModels' => Areas::FindSubAreas($id),
              'pagination' => [
                  'pageSize' => 10,
              ],
              'sort' => [
                  'attributes' => ['company_location_id'],
              ],
          ]);
          $area_id = $id;
          return $this->render('sub-area-index', [
              'area_id' => $area_id,
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
              
          ]);
    }

    /**
     * Displays a single Areas model.
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
     * Creates a new Areas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = 1)
    {
        
        $areas = [new Areas()];
 
        if (Yii::$app->request->post()) {
            $areas = DynamicForms::createMultiple(Areas::classname());
            DynamicForms::loadMultiple($areas, Yii::$app->request->post());
            
            $loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];
            
            //$valid = Model::validateMultiple($areas);
               try 
               {
                    $transaction = \Yii::$app->db->beginTransaction();
                        foreach ($areas as $i => $area) {
                            if (!($flag = $area->save())) {
                                
                                break;
                            }
                                
                        }  
                        
                    if ($flag) {
                        $transaction->commit();
                    }
                    else{
                        $transaction->rollBack();
                    }
                }
                catch (Exception $e) {
                    $transaction->rollBack();
                    echo var_dump($e);
                    exit;
                }
                
            return $this->redirect(['index', 'id' => $areas[0]->company_location_id]);
        } else {
            $company_location_id = $id;
            return $this->renderAjax('create', [
                'company_location_id' => $company_location_id,
                'areas' =>  (empty($areas)) ? [new Areas] : $areas,
                'companyLocations'=>(empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
            ]);
        }
    }

    public function actionCreateSubAreas($id = 1)
    {
        
        $areas = [new Areas()];
        if (Yii::$app->request->post()) {
            $areas = DynamicForms::createMultiple(Areas::classname());
            DynamicForms::loadMultiple($areas, Yii::$app->request->post());
            
            $loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];
            
            //$valid = Model::validateMultiple($areas);
               try 
               {
                    $transaction = \Yii::$app->db->beginTransaction();
                        foreach ($areas as $i => $area) {
                            if (!($flag = $area->save())) {
                                
                                break;
                            }
                                
                        }  
                        
                    if ($flag) {
                        $transaction->commit();
                    }
                    else{
                        $transaction->rollBack();
                    }
                }
                catch (Exception $e) {
                    $transaction->rollBack();
                    echo var_dump($e);
                    exit;
                }
                
            return $this->redirect(['index', 'id' => $areas[0]->company_location_id]);
        } else {
            $company_location_id = $id;
            return $this->renderAjax('create', [
                'company_location_id' => $company_location_id,
                'areas' =>  (empty($areas)) ? [new Areas] : $areas,
                'companyLocations'=>(empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
            ]);
        }
    }

    /**
     * Updates an existing Areas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $areas = [new Areas()];

        if (Yii::$app->request->post()) {
            $areas = DynamicForms::createMultiple(Areas::classname());
            DynamicForms::loadMultiple($areas, Yii::$app->request->post());
            
            $loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];
            
            //$valid = Model::validateMultiple($areas);

               try 
               {
                    $transaction = \Yii::$app->db->beginTransaction();
                        foreach ($areas as $i => $area) {
                            if (!($flag = $area->save())) {
                                
                                break;
                            }
                                
                        }  
                        
                    if ($flag) {
                        $transaction->commit();
                    }
                    else{
                        $transaction->rollBack();
                    }
                }
                catch (Exception $e) {
                    $transaction->rollBack();
                    echo var_dump($e);
                    exit;
                }
                
            return $this->redirect(['index', 'id' => $areas[0]->company_location_id]);
        } else {
            $company_location_id = $id;
            return $this->renderAjax('update', [
                'company_location_id' => $company_location_id,
                'areas' =>  (empty($areas)) ? [new Areas] : $areas,
                'companyLocations'=>(empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
            ]);
        }
    }
      
    public function actionEditableDemo() {
       $model = new Areas(); // your model can be loaded here
    
    // Check if there is an Editable ajax request
    if (isset($_POST['hasEditable'])) {
        // use Yii's response format to encode output as JSON
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // read your posted model attributes
        if ($model->load($_POST)) {
            // read or convert your posted information
            $value = $model->name;
            
            // return JSON encoded output in the below format
            return ['output'=>$value, 'message'=>''];
            
            // alternatively you can return a validation error
            // return ['output'=>'', 'message'=>'Validation error'];
        }
        // else if nothing to do always return an empty JSON encoded output
        else {
            return ['output'=>'', 'message'=>''];
        }
    }
  }
    public function actionAreaUnits($id)
    {
        
        $area_units = AreaUnits::find()
                                ->where(['area_id' => $id])
                                ->all();

         if (Yii::$app->request->post()) {
            
            $area_units = DynamicForms::createMultiple(AreaUnits::classname());
            DynamicForms::loadMultiple($area_units, Yii::$app->request->post());
            
            $loadsData['_csrf'] =  Yii::$app->request->post()['_csrf'];

             // validate all models
            // $valid = $model->validate();
            //$valid = Model::validateMultiple($estimatedAreas) &&  Model::validateMultiple($productUsedPerAreas) && $valid;

        
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                     \Yii::$app->db->createCommand()->delete('area_units', ['area_id' => $id])->execute();

                  
                        foreach ($area_units as $i => $area_unit) {
                           $area_unit->area_id = (int)$id;
                          
                            if (!($flag = $area_unit->save())) {
                                $transaction->rollBack();
                                break;
                            }
                                
                        }  
                        
                    if ($flag) {
                        $transaction->commit();
                    }
                }
                catch (Exception $e) {
                    $transaction->rollBack();
                   
                    exit;
                }
                  return $this->redirect(['index', 'id' => $area_units[0]->area_id]);
            
        }
        else{
           
            return $this->render('area-unit-form', [
                   'area_units'=>(empty($area_units)) ? [new AreaUnits] : $area_units,
                
            ]);
       }
    }

    /**
     * Deletes an existing Areas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	public function actionAreas($id)
    {
		$countPosts = Areas::find()
                      ->where(['company_location_id' => $id])->count();
 
        $areas = Areas::find()
				->select(['area_id','area_name'])
				->where(['company_location_id'=>$id])->all();

       if($countPosts>0){
		   $i=0;
            foreach($areas as $area){
				if($i==0)
				   echo "<option value=''>-Choose Area-</option>";
                   echo "<option value='".$area->area_id."'>".$area->area_name."</option>";
				$i++;
            }
        
        }
        else{
            echo "<option>-</option>";
        }
    }
    /**
     * Finds the Areas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Areas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Areas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
