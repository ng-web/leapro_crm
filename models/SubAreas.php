<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_areas".
 *
 * @property integer $sub_area_id
 * @property integer $area_id
 * @property integer $sub_area
 */
class SubAreas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'sub_area'], 'required'],
            [['area_id', 'sub_area'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sub_area_id' => 'Sub Area ID',
            'area_id' => 'Area ID',
            'sub_area' => 'Sub Area',
        ];
    }
}
