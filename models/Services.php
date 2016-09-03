<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property integer $service_id
 * @property string $service_name
 * @property double $service_cost
 * @property string $service_description
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_name', 'service_cost', 'service_description'], 'required'],
            [['service_cost'], 'number'],
            [['service_description'], 'string'],
            [['service_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Service ID',
            'service_name' => 'Service Name',
            'service_cost' => 'Service Cost',
            'service_description' => 'Service Description',
        ];
    }
}
