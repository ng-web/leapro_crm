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
 * @property integer $equipment_id
 * @property integer $bsr_id
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
            [['bs_status', 'bs_condition', 'equipment_id'], 'required'],
            [['bs_status', 'bs_qty', 'weight', 'number_seen', 'employee_id', 'bs_condition', 'equipment_id', 'bsr_id'], 'integer'],
            [['bs_comments'], 'string'],
            [['bsr_id'], 'exist', 'skipOnError' => true, 'targetClass' => BsrHeader::className(), 'targetAttribute' => ['bsr_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'emp_no']],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::className(), 'targetAttribute' => ['equipment_id' => 'equipment_id']],
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
            'equipment_id' => 'Equipment ID',
            'bsr_id' => 'Bsr ID',
        ];
    }
}
