<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property integer $area_id
 * @property integer $company_location_id
 * @property string $area_name
 * @property string $area_description
 * @property double $square_foot
 * @property double $width
 * @property double $length
 *
 * @property CompanyLocations $companyLocation
 * @property Estimates[] $estimates
 */
class Areas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_location_id'], 'integer'],
            [['area_name'], 'required'],
            [['area_description'], 'string'],
            [['area_name'], 'string', 'max' => 30],
            [['company_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyLocations::className(), 'targetAttribute' => ['company_location_id' => 'company_location_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => 'Area ID',
            'company_location_id' => 'Company Location ID',
            'area_name' => 'Area Name',
            'area_description' => 'Area Description',
            'customer_id' => 'Customer Id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyLocation()
    {
        return $this->hasOne(CompanyLocations::className(), ['company_location_id' => 'company_location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimatedAreas()
    {
        return $this->hasMany(EstimatedAreas::className(), ['area_id' => 'area_id']);
    }

    /**
     * @inheritdoc
     * @return EstimatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EstimatesQuery(get_called_class());
    }

     public static function FindSubAreas($area_id)
    {
        $area = Yii::$app->db->createCommand('SELECT * from areas a inner 
            join sub_areas sa on a.area_id = sa.area_id inner join area_units au on au.area_id 
            = a.area_id where sa.area_id = :area_id')->bindValues([':area_id'=>$area_id])->queryAll();

        return $area;
    }

     public static function FindAreasPerService($est_id, $ser_id)
    {
        $customer_id = Yii::$app->db->createCommand('SELECT distinct a.area_name, s.service_id,es.status_id, es.expiry_date, tax, ea.estimate_id, company_name, es.received_date, u.unit_name, au.value FROM
         companies inner JOIN company_locations on company_locations.company_id = companies.company_id 
            inner JOIN customers on customers.customer_id = companies.customer_id inner JOIN areas a on a.company_location_id = company_locations.company_location_id inner JOIN estimated_areas ea on ea.area_id = a.area_id inner join estimates es on ea.estimate_id = es.estimate_id left join area_units au on a.area_id = au.area_id left join units u on u.unit_id = au.unit_id inner join products_used_per_area pa on pa.estimated_area_id = ea.estimated_area_id inner join products p on p.product_id = pa.product_id inner join product_services ps on p.product_id = ps.product_id inner join services s on s.service_id = ps.service_id 
            where s.service_id = :ser_id and es.estimate_id = :id')->bindValues([':id'=>$est_id, ':ser_id'=> $ser_id ])->queryAll();

        return $customer_id;
    }

   
}


