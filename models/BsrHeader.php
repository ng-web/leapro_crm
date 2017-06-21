<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bsr_header".
 *
 * @property integer $id
 * @property string $bsr_docnum
 * @property string $bsr_approvedby
 * @property string $bsr_verifiedby
 * @property string $bsr_date
 * @property integer $emp_id
 * @property integer $estimated_area_id
 */
class BsrHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bsr_header';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bsr_docnum', 'bsr_approvedby', 'bsr_verifiedby', 'emp_id', 'estimated_area_id'], 'required'],
            [['bsr_date'], 'safe'],
            [['emp_id', 'estimated_area_id'], 'integer'],
            [['bsr_docnum'], 'string', 'max' => 32],
            [['bsr_approvedby', 'bsr_verifiedby'], 'string', 'max' => 70],
            [['emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['emp_id' => 'emp_no']],
            [['estimated_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstimatedAreas::className(), 'targetAttribute' => ['estimated_area_id' => 'estimated_area_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bsr_docnum' => 'Bsr Docnum',
            'bsr_approvedby' => 'Bsr Approvedby',
            'bsr_verifiedby' => 'Bsr Verifiedby',
            'bsr_date' => 'Bsr Date',
            'emp_id' => 'Emp ID',
            'estimated_area_id' => 'Estimated Area ID',
        ];
    }
}
