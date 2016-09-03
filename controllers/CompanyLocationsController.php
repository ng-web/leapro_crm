<?php

namespace app\controllers;

use Yii;
use app\models\CompanyLocations;
use app\models\Addresses;
use app\models\CompanyLocationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Query;
use yii\filters\VerbFilter;

/**
 * CompanyLocationsController implements the CRUD actions for CompanyLocations model.
 */
class CompanyLocationsController extends Controller
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
     * Lists all CompanyLocations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanyLocationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyLocations model.
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
     * Creates a new CompanyLocations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyLocations();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->company_location_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CompanyLocations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->company_location_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CompanyLocations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	public function actionLocations($id)
    {
		
		$aDB = \Yii::$app->db;
		$query = $aDB->createCommand('Select count(company_id)as total from company_locations inner join addresses on 
		                              company_locations.address_id = addresses.address_id where company_id = :id');
        $query->bindValue(':id', $id);
        $count = $query->queryScalar();
       //$addresses  =Addresses::find()->select(['company_id','company_location_id','address_line1'])->join('inner join', 'company_locations','company_locations.address_id = addresses.address_id')->where(['company_id'=>$id])->all();
		$query = $aDB->createCommand('Select company_id,company_location_id,address_line1,address_line2, address_province from company_locations inner join addresses on 
		                              company_locations.address_id = addresses.address_id where company_id = :id');
        $query->bindValue(':id', $id);
        $addresses  =$query->query();
	    if($count>0){
			 $i=0;
			foreach($addresses as $address){
				if($i==0)
				   echo "<option value=''>-Choose Location-</option>";
			    
				echo "<option value='".$address['company_location_id']."'>".$address['address_line1'].', '.$address['address_line2'].', '.$address['address_province']."</option>";
			}
		}
		else{
			echo "<option>-</option>";
		}
    }
    /**
     * Finds the CompanyLocations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyLocations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompanyLocations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
