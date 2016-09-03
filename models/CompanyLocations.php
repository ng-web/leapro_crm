<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_locations".
 *
 * @property integer $company_location_id
 * @property integer $company_id
 * @property integer $address_id
 *
 * @property Areas[] $areas
 * @property Addresses $address
 * @property Companies $company
 * @property Contacts[] $contacts
 */
class CompanyLocations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_locations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_id','branch_name'], 'required'],
            [['company_id', 'address_id'], 'integer'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addresses::className(), 'targetAttribute' => ['address_id' => 'address_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['company_id' => 'company_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_location_id' => 'Company Location ID',
            'company_id' => 'Company ID',
            'address_id' => 'Address ID',
            'branch_name' => 'Branch Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Areas::className(), ['company_location_id' => 'company_location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Addresses::className(), ['address_id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contacts::className(), ['company_location_id' => 'company_location_id']);
    }

    /**
     * @inheritdoc
     * @return CompanyLocationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyLocationsQuery(get_called_class());
    }
}
