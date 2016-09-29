<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employees".
 *
 * @property integer $emp_no
 * @property string $birth_date
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $hire_date
 * @property string $emp_pic
 * @property string $emp_license_number
 *
 * @property BsrActivity[] $bsrActivities
 * @property DeptEmp[] $deptEmps
 * @property Departments[] $deptNos
 * @property DeptManager[] $deptManagers
 * @property Departments[] $deptNos0
 * @property PmiActivity[] $pmiActivities
 * @property Salaries[] $salaries
 * @property Titles[] $titles
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_no', 'birth_date', 'emp_type', 'first_name', 'last_name', 'gender', 'hire_date', 'emp_pic'], 'required'],
            [['emp_no'], 'integer'],
            [['birth_date', 'hire_date'], 'safe'],
            [['gender', 'emp_pic'], 'string'],
            [['first_name'], 'string', 'max' => 14],
            [['last_name'], 'string', 'max' => 16],
            [['emp_license_number'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_no' => 'Emp No',
            'birth_date' => 'Birth Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'hire_date' => 'Hire Date',
            'emp_pic' => 'Emp Pic',
            'emp_license_number' => 'Emp License Number',
            'emp_type'=>'Employee Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBsrActivities()
    {
        return $this->hasMany(BsrActivity::className(), ['employee_id' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptEmps()
    {
        return $this->hasMany(DeptEmp::className(), ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptNos()
    {
        return $this->hasMany(Departments::className(), ['dept_no' => 'dept_no'])->viaTable('dept_emp', ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptManagers()
    {
        return $this->hasMany(DeptManager::className(), ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeptNos0()
    {
        return $this->hasMany(Departments::className(), ['dept_no' => 'dept_no'])->viaTable('dept_manager', ['emp_no' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPmiActivities()
    {
        return $this->hasMany(PmiActivity::className(), ['employee_id' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaries()
    {
        return $this->hasMany(Salaries::className(), ['emp_no' => 'emp_no']);
    }

     public function getAssignments()
    {
        return $this->hasMany(Assignments::className(), ['emp_id' => 'emp_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitles()
    {
        return $this->hasMany(Titles::className(), ['emp_no' => 'emp_no']);
    }

    public function getEmployeeName(){
        return $this->first_name.' '.$this->last_name;
    }
}
