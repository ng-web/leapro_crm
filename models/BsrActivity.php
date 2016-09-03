<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bsr_activity".
 *
 * @property integer $bs_id
 * @property integer $bs_status
 * @property integer $bs_qty
 * @property integer $weight
 * @property integer $number_seen
 * @property integer $employee_id
 * @property integer $bs_condition
 * @property string $bs_comments
 * @property string $bs_date
 * @property integer $estimated_area_id
 *
 * @property EstimatedAreas $estimatedArea
 * @property Employees $employee
 */
class BsrActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bsr_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bs_status', 'bs_condition', 'estimated_area_id'], 'required'],
            [['bs_status', 'bs_qty', 'weight', 'number_seen', 'employee_id', 'bs_condition', 'estimated_area_id'], 'integer'],
            [['bs_comments', 'bsr_approvedby', 'bsr_verifiedby'], 'string'],
            [['bs_date'], 'safe'],
            [['estimated_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstimatedAreas::className(), 'targetAttribute' => ['estimated_area_id' => 'estimated_area_id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'emp_no']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bs_id' => 'Bs ID',
            'bs_status' => 'Bs Status',
            'bs_qty' => 'Bs Qty',
            'weight' => 'Weight',
            'number_seen' => 'Number Seen',
            'employee_id' => 'Employee ID',
            'bs_condition' => 'Bs Condition',
            'bs_comments' => 'Bs Comments',
            'bs_date' => 'Bs Date',
            'estimated_area_id' => 'Estimated Area ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimatedArea()
    {
        return $this->hasOne(EstimatedAreas::className(), ['estimated_area_id' => 'estimated_area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['emp_no' => 'employee_id']);
    }
}
