<?php

namespace app\models;

use Yii;


class Deployments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deployments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'equipment_id'], 'required'],
            [[ 'equipment_id'], 'integer'],
            [['deploy_date'], 'safe'],
            [['deploy_notes'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'deploy_id' => 'Deploy ID',
            'estimated_area_id' => 'Area',
            'equipment_id' => 'Equipment',
            'deploy_date' => 'Deploy Date',
            'deploy_notes' => 'Notes',
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
    public function getEquipment()
    {
        return $this->hasOne(Equipment::className(), ['equipment_id' => 'equipment_id']);
    }

  
}
