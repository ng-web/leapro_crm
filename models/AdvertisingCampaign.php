<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "advertising_campaign".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * @property Estimates[] $estimates
 */
class AdvertisingCampaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertising_campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimates()
    {
        return $this->hasMany(Estimates::className(), ['campaign_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AdvertisingCampaignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdvertisingCampaignQuery(get_called_class());
    }
}
