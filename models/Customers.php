<?php

namespace app\models;

use Yii;


class Customers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_firstname', 'customer_lastname', 'address_id', 'gender', 'customer_type', 'customer_telephone', 'customer_cell', 'customer_email', 'status'], 'required'],
            [['customer_details', 'gender', 'customer_type', 'status'], 'string'],
            [['address_id'], 'integer'],
            [['customer_firstname', 'customer_lastname', 'customer_midname'], 'string', 'max' => 60],
            [['customer_telephone', 'customer_cell'], 'string', 'max' => 30],
            [['customer_email'], 'string', 'max' => 255],
            [['customer_email'], 'unique'],
            [['customer_email'], 'email', 'message'=>"This email is not valid"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'customer_firstname' => 'Customer Firstname',
            'customer_lastname' => 'Customer Lastname',
            'customer_midname' => 'Customer Midname',
            'customer_details' => 'Customer Details',
            'date_registered' => 'Date Registered',
            'address_id' => 'Address ID',
            'gender' => 'Gender',
            'customer_type' => 'Customer Type',
            'customer_telephone' => 'Customer Telephone',
            'customer_cell' => 'Customer Cell',
            'customer_email' => 'Customer Email',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Companies::className(), ['customer_id' => 'customer_id']);
    }
	
	public function getFullName(){
		return $this->customer_firstname .' '.$this->customer_lastname;
	}

    public function getAddresses()
    {
        return $this->hasOne(Addresses::className(), ['address_id' => 'address_id']);
    }

    /**
     * @inheritdoc
     * @return EstimatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EstimatesQuery(get_called_class());
    }

   
    public static function FindAllEstimateSql()
    {
        return 'SELECT es.estimate_id, company_name, s.status, es.received_date, sum(p.product_cost)*sum(a.square_foot) as `cost` 
            FROM companies left JOIN company_locations on company_locations.company_id = companies.company_id 
            left JOIN areas a on a.company_location_id = company_locations.company_location_id left JOIN estimated_areas ea on ea.area_id
            = a.area_id left join estimates es on ea.estimate_id = es.estimate_id
            left JOIN products_used_per_area pa on pa.estimated_area_id = ea.estimated_area_id
            left JOIN products p on p.product_id = pa.product_id
            left JOIN estimate_status s on s.status_id = es.status_id
            where companies.customer_id = :id and es.status_id = 1
            group by es.estimate_id order by es.estimate_id desc';
    }

    public static function FindAllJobOrdersSql()
    {
        return 'SELECT es.estimate_id, company_name, s.status, es.confirmed_date,  es.schedule_date_time, sum(p.product_cost)*sum(a.square_foot) as `cost` 
            FROM companies left JOIN company_locations on company_locations.company_id = companies.company_id 
            left JOIN areas a on a.company_location_id = company_locations.company_location_id left JOIN estimated_areas ea on ea.area_id
            = a.area_id left join estimates es on ea.estimate_id = es.estimate_id
            left JOIN products_used_per_area pa on pa.estimated_area_id = ea.estimated_area_id
            left JOIN products p on p.product_id = pa.product_id
            left JOIN estimate_status s on s.status_id = es.status_id
            where companies.customer_id = :id and es.status_id = 3
            group by es.estimate_id order by es.estimate_id desc';
    }

    public static function FindAllCompanySql()
    {
        return 'SELECT  company_name,  a.area_name, ad.address_line1, ad.address_line2, ad.address_province
            FROM companies left JOIN company_locations on company_locations.company_id = companies.company_id 
            left JOIN areas a on a.company_location_id = company_locations.company_location_id left JOIN estimated_areas ea on ea.area_id
            = a.area_id left join addresses ad on ad.address_id = company_locations.address_id where companies.customer_id = :id ';
    }

    

  }