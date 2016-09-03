<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdvertisingCampaign]].
 *
 * @see AdvertisingCampaign
 */
class AdvertisingCampaignQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AdvertisingCampaign[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdvertisingCampaign|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
