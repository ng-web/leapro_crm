<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_estimates".
 *
 * @property integer $service_estimate_id
 * @property integer $service_id
 * @property integer $estimate_id
 * @property double $discount
 *
 * @property Estimates $estimate
 */
class ServiceEstimates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_estimates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'estimate_id', 'discount'], 'required'],
            [['service_id', 'estimate_id'], 'integer'],
            [['discount'], 'number'],
            [['estimate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estimates::className(), 'targetAttribute' => ['estimate_id' => 'estimate_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_estimate_id' => 'Service Estimate ID',
            'service_id' => 'Service ID',
            'estimate_id' => 'Estimate ID',
            'discount' => 'Discount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimate()
    {
        return $this->hasOne(Estimates::className(), ['estimate_id' => 'estimate_id']);
    }
}
