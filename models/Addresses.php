<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property integer $address_id
 * @property string $address_line1
 * @property string $address_line2
 * @property string $address_province
 * @property integer $address_zip
 * @property integer $address_type
 * @property integer $address_status
 * @property string $address_details
 *
 * @property CompanyLocations[] $companyLocations
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_line1', 'address_province'], 'required'],
            [['address_zip', 'address_type', 'address_status'], 'integer'],
            [['address_details'], 'string'],
            [['address_line1', 'address_line2'], 'string', 'max' => 255],
            [['address_province'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address_id' => 'Address ID',
            'address_line1' => 'Address Line1',
            'address_line2' => 'Address Line2',
            'address_province' => 'Address Province',
            'address_zip' => 'Address Zip',
            'address_type' => 'Address Type',
            'address_status' => 'Address Status',
            'address_details' => 'Address Details',
        ];
    }
     public function getFullAddress()
	 {
		 return $this->address_line1.', '.$this->address_line2.', '.$this->address_province;
	 }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyLocations()
    {
        return $this->hasMany(CompanyLocations::className(), ['address_id' => 'address_id']);
    }
    public function getCompanies() {
        return $this->hasMany(Companies::className(), ['company_id' => 'company_id'])
          ->viaTable('addresses', ['address_id' => 'address_id']);
    }
    /**
     * @inheritdoc
     * @return AddressesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AddressesQuery(get_called_class());
    }
}
