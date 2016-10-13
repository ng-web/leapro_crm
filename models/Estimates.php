<?php

namespace app\models;

use Yii;

class Estimates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estimates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'status_id', 'expiry_date'], 'required'],
            [['campaign_id', 'status_id'], 'integer'],
            [['received_date', 'confirmed_date', 'schedule_date_time', 'tax', 'discount','factor'], 'safe'],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisingCampaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstimateStatus::className(), 'targetAttribute' => ['status_id' => 'status_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'estimate_id' => 'Estimate ID',
            'campaign_id' => 'Campaign ID',
            'status_id' => 'Status ID',
            'received_date' => 'Received Date',
            'confirmed_date' => 'Confirmed Date',
            'schedule_date_time' => 'Schedule Date Time',
            'expiry_date' => 'Expiry Date',
            'tax' => 'tax',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimatedAreas()
    {
        return $this->hasMany(EstimatedAreas::className(), ['estimate_id' => 'estimate_id']);
    }

    public function getSchedules()
    {
        return $this->hasMany(Schedules::className(), ['estimate_id' => 'estimate_id']);
    }

    public static function CountEstimates($id)
    {
       $count = Yii::$app->db->createCommand(' SELECT count(*)
                FROM companies left JOIN company_locations on company_locations.company_id = companies.company_id 
                left JOIN areas a on a.company_location_id = company_locations.company_location_id left JOIN estimated_areas ea on ea.area_id
                = a.area_id left join estimates es on ea.estimate_id = es.estimate_id
                left JOIN products_used_per_area pa on pa.estimated_area_id = ea.estimated_area_id
                left JOIN products p on p.product_id = pa.product_id where es.estimate_id = :id')
                ->bindValues([':id'=>$id, ])->queryScalar();
        
        return $count;
    }

    public static function FindProductUsedInArea($id, $ser_id, $area_id)
    {
       $products = Yii::$app->db->createCommand(' SELECT Distinct p.product_name, p.product_description, pa.product_cost_at_time, pa.quantity, a.area_name FROM 
         companies inner JOIN company_locations on company_locations.company_id = companies.company_id
         inner JOIN areas a on a.company_location_id = company_locations.company_location_id inner JOIN 
         estimated_areas ea on ea.area_id = a.area_id inner join estimates es on ea.estimate_id = es.estimate_id
         inner JOIN products_used_per_area pa on pa.estimated_area_id = 
         ea.estimated_area_id inner JOIN products p on p.product_id = pa.product_id inner join product_services ps on p.product_id = ps.product_id 
         inner join services s on s.service_id = ps.service_id where es.estimate_id = :id
         and s.service_id = :ser_id and a.area_id = :a_id group by  area_name, product_name
         union
         SELECT Distinct p.product_name, p.product_description, pa.product_cost_at_time, pa.quantity, a.area_name FROM 
         customers inner JOIN areas a on a.customer_id = customers.customer_id inner JOIN 
         estimated_areas ea on ea.area_id = a.area_id inner join estimates es on ea.estimate_id = es.estimate_id
         inner JOIN products_used_per_area pa on pa.estimated_area_id = 
         ea.estimated_area_id inner JOIN products p on p.product_id = pa.product_id inner join product_services ps on p.product_id = ps.product_id 
         inner join services s on s.service_id = ps.service_id where es.estimate_id = :id
         and s.service_id = :ser_id and a.area_id = :a_id group by  area_name, product_name')
         ->bindValues([':id'=>$id, ':ser_id'=>$ser_id,':a_id'=>$area_id])->queryAll();

        return $products;
    }

    public static function FindAreas($id, $ser_id)
    {
       $areas = Yii::$app->db->createCommand('SELECT Distinct a.area_name, a.area_id FROM 
         companies inner JOIN company_locations on company_locations.company_id = companies.company_id
          inner join areas a on a.company_location_id = company_locations.company_location_id inner JOIN 
         estimated_areas ea on ea.area_id = a.area_id inner join estimates es on ea.estimate_id = es.estimate_id
         inner JOIN products_used_per_area pa on pa.estimated_area_id = 
         ea.estimated_area_id inner JOIN products p on p.product_id = pa.product_id
          inner join product_services ps on p.product_id = ps.product_id inner join services s 
          on s.service_id = ps.service_id where es.estimate_id = :id
         and s.service_id = :ser_id
         union
         SELECT Distinct a.area_name, a.area_id FROM 
         estimated_areas ea inner join areas a on ea.area_id = a.area_id inner join estimates es on ea.estimate_id = es.estimate_id
         inner JOIN products_used_per_area pa on pa.estimated_area_id = 
         ea.estimated_area_id inner JOIN products p on p.product_id = pa.product_id
          inner join product_services ps on p.product_id = ps.product_id inner join services s 
          on s.service_id = ps.service_id where es.estimate_id = :id
         and s.service_id = :ser_id
         ')
         ->bindValues([':id'=>$id, ':ser_id'=>$ser_id ])->queryAll();

        return $areas;
    }

    public static function FindEstimateSql($id)
    {
        $FindEstimateSql = Yii::$app->db->createCommand('SELECT customers.customer_id, company_locations.company_location_id as `c_id`,
            company_name as `name`, customers.customer_type,es.status_id, es.expiry_date, tax, a.area_name, ea.estimate_id, 
            es.received_date, address_line1, address_line2, address_province, schedule_date_time FROM companies left JOIN 
            company_locations on company_locations.company_id = companies.company_id left JOIN customers on 
            customers.customer_id = companies.customer_id left JOIN areas a on a.company_location_id = 
            company_locations.company_location_id left JOIN estimated_areas ea on ea.area_id = a.area_id 
            left join estimates es on ea.estimate_id = es.estimate_id left JOIN addresses on 
            company_locations.address_id = addresses.address_id left JOIN estimate_status s on
             s.status_id = es.status_id where es.estimate_id = :id
            union             
            SELECT customers.customer_id, customers.address_id as `c_id`, concat(customers.customer_firstname," ", customers.customer_lastname) as `name`, customers.customer_type,es.status_id, es.expiry_date, tax, a.area_name, ea.estimate_id, 
            es.received_date, address_line1, address_line2, address_province, schedule_date_time  from customers
            left JOIN areas a on a.customer_id = 
            customers.customer_id left JOIN estimated_areas ea on ea.area_id = a.area_id 
            left join estimates es on ea.estimate_id = es.estimate_id left JOIN addresses on 
            customers.address_id = addresses.address_id left JOIN estimate_status s on
             s.status_id = es.status_id where es.estimate_id = :id')->bindValues([':id'=>$id])->queryAll();

        return $FindEstimateSql;
    }    

 
     public static function FindAllEstimateSql($id)
    {
        $FindEstimateSql = Yii::$app->db->createCommand('SELECT customers.customer_firstname, 
            customers.customer_lastname, customers.customer_type, tax, a.area_name, ea.estimate_id, company_name, 
            es.received_date, address_line1, address_line2, address_province FROM companies left JOIN 
            company_locations on company_locations.company_id = companies.company_id left JOIN customers on 
            customers.customer_id = companies.customer_id left JOIN areas a on a.company_location_id = 
            company_locations.company_location_id left JOIN estimated_areas ea on ea.area_id = a.area_id 
            left join estimates es on ea.estimate_id = es.estimate_id left JOIN addresses on 
            company_locations.address_id = addresses.address_id left JOIN estimate_status s on
             s.status_id = es.status_id')->queryAll();

        return $FindEstimateSql;
    }
    public static function FindServicesSql($id)
    {
        $services = Yii::$app->db->createCommand('SELECT Distinct s.service_id,es.estimate_id, s.service_name, 
                    s.service_cost FROM estimates es inner join estimated_areas ea on ea.estimate_id = es.estimate_id 
                    inner join products_used_per_area pa on pa.estimated_area_id = ea.estimated_area_id inner join products p on 
                    p.product_id = pa.product_id inner join product_services ps on p.product_id = ps.product_id inner join services s 
                    on s.service_id = ps.service_id where es.estimate_id = :id')->bindValues([':id'=>$id])->queryAll();

        return $services;
    }


    public static function FindTotalCost($id)
    {
        $totalCost = Yii::$app->db->createCommand('SELECT sum(pa.product_cost_at_time) * sum(pa.quantity) + sum(sv.service_cost) as `Total Cost` 
         FROM companies left JOIN company_locations on company_locations.company_id = companies.company_id
         left JOIN areas a on a.company_location_id = company_locations.company_location_id left JOIN 
         estimated_areas ea on ea.area_id = a.area_id left join estimates es on ea.estimate_id = es.estimate_id  left JOIN products_used_per_area pa on pa.estimated_area_id = ea.estimated_area_id left JOIN products p  on p.product_id = pa.product_id left JOIN estimate_status s on s.status_id = es.status_id  inner join product_services ps 
           on p.product_id = ps.product_id left join services sv on sv.service_id = ps.service_id where es.estimate_id = :id')->bindValues([':id'=>$id, ])->queryScalar();

        return $totalCost;
    }

    public static function FindCustomerId($id)
    {
        $customer_id = Yii::$app->db->createCommand('SELECT companies.customer_id FROM companies left JOIN 
            company_locations on company_locations.company_id = companies.company_id left JOIN customers on 
            customers.customer_id = companies.customer_id left JOIN areas a on a.company_location_id = 
            company_locations.company_location_id left JOIN estimated_areas ea on ea.area_id = a.area_id 
            left join estimates es on ea.estimate_id = es.estimate_id left JOIN addresses on 
            company_locations.address_id = addresses.address_id left JOIN estimate_status s on
             s.status_id = es.status_id where es.estimate_id = :id
            union             
            SELECT customers.customer_id from customers
            left JOIN areas a on a.customer_id = 
            customers.customer_id left JOIN estimated_areas ea on ea.area_id = a.area_id 
            left join estimates es on ea.estimate_id = es.estimate_id left JOIN addresses on 
            customers.address_id = addresses.address_id left JOIN estimate_status s on
             s.status_id = es.status_id where es.estimate_id = :id')->bindValues([':id'=>$id, ])->queryScalar();

        return $customer_id;
    }

    public static function FindProductByService($service_id)
    {
         $products = Yii::$app->db->createCommand('SELECT product_services.product_id, product_name, product_cost FROM `products` 
                                                   inner join product_services on product_services.product_id = products.product_id
                                                    where service_id = :id group by products.product_id')
                                                   ->bindValues([':id'=>$service_id, ])->queryAll();
         if(count($products)>0){
           $i=0;
            foreach($products as $product){
                if($i==0)
                   echo "<option value=''>-Choose Product-</option>";
            
                echo "<option value='".$product['product_id']."'>".$product['product_name']."</option>";
                $i++;
            }
        }
        else{
            echo "<option>-No product</option>";
        }
    }
    public static function getAllDistinctProductsById($id=NULL){
       
       $query = Yii::$app->db->createCommand('SELECT  ps.service_id, pr.product_id from estimates inner join estimated_areas ea on ea.estimate_id = 
                   estimates.estimate_id inner join products_used_per_area p on ea.estimated_area_id =
                    p.estimated_area_id inner join products pr on pr.product_id = p.product_id inner join product_services 
                   ps on ps.product_id = pr.product_id inner join services s on s.service_id = ps.service_id
                   where estimates.estimate_id = :id group by ps.service_id')->bindValues([':id'=>$id])->queryAll();
       
              return $query;
    }

    public static function getAllProductsById($id=NULL){
       
       $query = Yii::$app->db->createCommand('SELECT * from estimates inner join estimated_areas ea on ea.estimate_id = 
                   estimates.estimate_id inner join products_used_per_area p on ea.estimated_area_id =
                    p.estimated_area_id inner join products pr on pr.product_id = p.product_id inner join product_services 
                   ps on ps.product_id = pr.product_id inner join services s on s.service_id = ps.service_id
                   where estimates.estimate_id = :id')->bindValues([':id'=>$id])->queryAll();
       
       return $query;
    }

    public static function getAllEstimatedAreasByServiceId($id=NULL, $est_id=NULL){
       
       $query = Yii::$app->db->createCommand('SELECT * from estimates inner join estimated_areas ea on ea.estimate_id = 
                   estimates.estimate_id inner join products_used_per_area p on ea.estimated_area_id =
                    p.estimated_area_id inner join products pr on pr.product_id = p.product_id inner join product_services 
                   ps on ps.product_id = pr.product_id inner join services s on s.service_id = ps.service_id
                   where ps.service_id = :id and estimates.estimate_id = :es')->bindValues([':id'=>$id, ':es'=>$est_id])->queryAll();
       foreach($query as $i=> $q){
         $results[$i] = EstimatedAreas::find()->where(['estimated_area_id' => $q['estimated_area_id']])->one();
       }
       
       return $results;
    }

    public static function getAllProductsByEstimatedAreaId($id=NULL, $ser_id = NULL, $est_id=NULL){
       
       $query = Yii::$app->db->createCommand('SELECT * from estimates inner join estimated_areas ea on ea.estimate_id = 
                   estimates.estimate_id inner join products_used_per_area p on ea.estimated_area_id =
                    p.estimated_area_id inner join products pr on pr.product_id = p.product_id inner join product_services 
                   ps on ps.product_id = pr.product_id inner join services s on s.service_id = ps.service_id
                   where  ea.estimated_area_id = :id and  ps.service_id = :ser and estimates.estimate_id = :es')
                  ->bindValues([':id'=>$id, ':es'=>$est_id, ':ser'=>$ser_id])->queryAll();
   
       foreach($query as $i=> $q){
         $results[$i] =  productsUsedPerArea::find()->where(['products_used_per_area_id' => $q['products_used_per_area_id']])->one();
       }
       return $results;
    }
    
    public static function ChangeStatus($id, $status)
    {

       if($status < 1 || $status > 4)
         return false;

        $totalCost = Yii::$app->db->createCommand('Update estimates Set status_id = :status
                                                   Where estimate_id = :id')
                        ->bindValues([':status'=>$status, ':id'=>$id, ])
                        ->execute();
        return true;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(AdvertisingCampaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(EstimateStatus::className(), ['status_id' => 'status_id']);
    }
     
     public function getAssignments()
    {
        return $this->hasMany(Assignments::className(), ['estimate_id' => 'estimate_id']);
    }
    /**
     * @inheritdoc
     * @return EstimatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EstimatesQuery(get_called_class());
    }

 

    public static function CalculateCost($service, $product, $area_id)
    {
        //Length * width = area sq ft
        //Length * width * height = cubic ft

        $length = $width = $height = $depth = 0;
        $cost = 0.00;
        $area_units = Areas::FindAreasPerService($service['estimate_id'], $service['service_id']);

        foreach($area_units as $unit){
            switch($unit['unit_name']){
                case "Length":
                    $length = $unit['value'];
                break;
                case "Width":
                    $width = $unit['value'];
                break;
                case "Height":
                    $height = $unit['value'];
                break;
                case "Depth":
                    $depth = $unit['value'];
                break;
                case "Volume":
                   $volume = $unit['value'];
                break;
                case "Area":
                   $volume = $unit['value'];
                break;
            }
        }

        if(isset($area)){
             $square_feet = $area;
        }
        else{
             $square_feet = $length * $width;
        }

        if(isset($volume)){
            $cubic_feet = $volume;
        }
        else{
            $cubic_feet = $length * $width * $height;
        }

         
       
        
        
        switch($service['service_name'])
        {
            case "Misting":
               $basecost = $product['product_cost_at_time'] * (2.5/70000) * 10000;
               $cost = ($cubic_feet /10000) *$basecost;
            break;
            case "Dusting":
               $basecost = $product['product_cost_at_time'] * (1.4/4000) * 1000;
               $cost = ($square_feet/1000) * $basecost;
            break;
            case "Spraying":
               $basecost = $product['product_cost_at_time'] * (2/5000) * 1000;
               $cost = ($square_feet/1000) * $basecost;
            break;
            case "Fogging":
               $basecost = $product['product_cost_at_time'] * (2/5000);
               $cost = ($product['product_cost_at_time'] * $product['quantity']);
            break;
            case "Fumigation":
               $cost = ($product['product_cost_at_time'] * $product['quantity']  /$cubic_feet) * 1000;
            break;
            case "":
            break;
        }

        return $cost;
    }
}
