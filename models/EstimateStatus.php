<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estimate_status".
 *
 * @property integer $status_id
 * @property string $status
 * @property string $status_description
 *
 * @property Estimates[] $estimates
 */
class EstimateStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estimate_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status_description'], 'string'],
            [['status'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'status' => 'Status',
            'status_description' => 'Status Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimates()
    {
        return $this->hasMany(Estimates::className(), ['status_id' => 'status_id']);
    }

    /**
     * @inheritdoc
     * @return EstimateStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EstimateStatusQuery(get_called_class());
    }
}
