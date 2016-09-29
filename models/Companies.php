<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property integer $company_id
 * @property string $company_name
 * @property integer $customer_id
 *
 * @property Customers $customer
 * @property CompanyLocations[] $companyLocations
 * @property JobOrders[] $jobOrders
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'company_name', ], 'required'],
            [['company_id', 'customer_id'], 'integer'],
            [['company_name'], 'string', 'max' => 128],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'company_name' => 'Company Name',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyLocations()
    {
        return $this->hasMany(CompanyLocations::className(), ['company_id' => 'company_id']);
    } 
    
    public function getAddresses() {
        return $this->hasMany(Addresses::className(), ['address_id' => 'address_id'])
          ->viaTable('company_locations', ['company_id' => 'company_id']);
    }
    /**
     * @inheritdoc
     * @return CompaniesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompaniesQuery(get_called_class());
    }
}
