<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assignments".
 *
 * @property integer $assignment_id
 * @property integer $emp_id
 * @property integer $estimate_id
 */
class Assignments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'assignments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_id', 'estimate_id'], 'required'],
            [['emp_id', 'estimate_id'], 'integer'],
            [['estimate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estimates::className(), 'targetAttribute' => ['estimate_id' => 'estimate_id']],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['emp_id' => 'emp_no']],
        ];
    }

   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'assignment_id' => 'Assignment ID',
            'emp_id' => 'Emp ID',
            'estimate_id' => 'Estimate ID',
        ];
    }
     public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['emp_no' => 'emp_id']);
    }

     public function getEstimate()
    {
        return $this->hasOne(Estimates::className(), ['estimate_id' => 'estimate_id']);
    }
}
