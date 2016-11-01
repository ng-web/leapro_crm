<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment".
 *
 * @property integer $equipment_id
 * @property string $equipment_name
 * @property string $equipment_barcode
 * @property string $equipment_description
 *
 * @property Deployments[] $deployments
 */
class Equipment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equipment_name', 'service_id'], 'required'],
            [['equipment_description'], 'string'],
            [['equipment_name'], 'string', 'max' => 30],
            [['equipment_barcode'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'equipment_id' => 'Equipment ID',
            'equipment_name' => 'Equipment Name',
            'equipment_barcode' => 'Equipment Barcode',
            'equipment_description' => 'Equipment Description',
            'service_id' =>'Service'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeployments()
    {
        return $this->hasMany(Deployments::className(), ['equipment_id' => 'equipment_id']);
    }
}
