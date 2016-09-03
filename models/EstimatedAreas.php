<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estimated_areas".
 *
 * @property integer $estimated_area_id
 * @property integer $estimate_id
 * @property integer $area_id
 *
 * @property Areas $area
 * @property Estimates $estimate
 */
class EstimatedAreas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estimated_areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id'], 'required'],
            [['estimate_id', 'area_id'], 'integer'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::className(), 'targetAttribute' => ['area_id' => 'area_id']],
            [['estimate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estimates::className(), 'targetAttribute' => ['estimate_id' => 'estimate_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'estimated_area_id' => 'Estimated Area ID',
            'estimate_id' => 'Estimate ID',
            'area_id' => 'Area ID',
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
    public function getEstimate()
    {
        return $this->hasOne(Estimates::className(), ['estimate_id' => 'estimate_id']);
    }

    /**
     * @inheritdoc
     * @return EstimatedAreasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EstimatedAreasQuery(get_called_class());
    }
}
