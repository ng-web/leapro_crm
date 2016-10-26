<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jnd".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class Jnd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jnd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estimate_area_id'], 'required'],
            [['estimate_area_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Reason',
        ];
    }
}
