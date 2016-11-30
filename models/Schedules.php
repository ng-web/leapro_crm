<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schedules".
 *
 * @property integer $schedule_id
 * @property integer $estimate_id
 * @property string $schedule_date
 * @property integer $emp_id
 */
class Schedules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estimate_id', 'schedule_date', 'emp_id'], 'required'],
            [['estimate_id', 'emp_id'], 'integer'],
            [['schedule_date'], 'safe'],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['emp_id' => 'emp_no']],
            [['estimate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estimates::className(), 'targetAttribute' => ['estimate_id' => 'estimate_id']],
        ];
    }

    public function getEstimate()
    {
        return $this->hasOne(Estimates::className(), ['estimate_id' => 'estimate_id']);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schedule_id' => 'Schedule ID',
            'estimate_id' => 'Estimate ID',
            'schedule_date' => 'Schedule Date',
            'emp_id' => 'Emp ID',
        ];
    }
}
