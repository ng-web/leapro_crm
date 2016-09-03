<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area_units".
 *
 * @property integer $area_unit_id
 * @property integer $area_id
 * @property integer $unit_id
 * @property double $value
 *
 * @property Areas $area
 * @property Units $unit
 */
class AreaUnits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area_units';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'unit_id'], 'integer'],
            [['value'], 'number'],
            [['area_id', 'unit_id'], 'required'],
            [['unit_id',], 'unique','targetAttribute' => ['unit_id'],'message' => 'Units must be unique.'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::className(), 'targetAttribute' => ['area_id' => 'area_id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::className(), 'targetAttribute' => ['unit_id' => 'unit_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_unit_id' => 'Area Unit ID',
            'area_id' => 'Area ID',
            'unit_id' => 'Unit ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Areas::className(), ['area_id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Units::className(), ['unit_id' => 'unit_id']);
    }
}
