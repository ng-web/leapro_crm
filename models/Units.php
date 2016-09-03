<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "units".
 *
 * @property integer $unit_id
 * @property string $unit_name
 * @property string $abreviation
 *
 * @property AreaUnits[] $areaUnits
 */
class Units extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'units';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_name'], 'required'],
            [['unit_name'], 'string', 'max' => 30],
            [['abreviation'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => 'Unit ID',
            'unit_name' => 'Unit Name',
            'abreviation' => 'Abreviation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaUnits()
    {
        return $this->hasMany(AreaUnits::className(), ['unit_id' => 'unit_id']);
    }
}
