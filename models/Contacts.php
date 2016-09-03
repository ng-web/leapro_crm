<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property integer $contact_id
 * @property integer $company_location_id
 * @property string $contact_name
 * @property string $contact_number
 * @property string $contact_cell
 * @property string $contact_fax
 * @property string $contact_email
 *
 * @property CompanyLocations $companyLocation
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contact_name', 'contact_number'], 'required'],
            [['company_location_id'], 'integer'],
            [['contact_name', 'contact_email'], 'string', 'max' => 128],
            [['contact_number', 'contact_cell', 'contact_fax'], 'string', 'max' => 32],
            [['company_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyLocations::className(), 'targetAttribute' => ['company_location_id' => 'company_location_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contact_id' => 'Contact ID',
            'company_location_id' => 'Company Location ID',
            'contact_name' => 'Contact Name',
            'contact_number' => 'Contact Number',
            'contact_cell' => 'Contact Cell',
            'contact_fax' => 'Contact Fax',
            'contact_email' => 'Contact Email',
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
     * @inheritdoc
     * @return ContactsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContactsQuery(get_called_class());
    }
}
