<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EstimateStatus]].
 *
 * @see EstimateStatus
 */
class EstimateStatusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EstimateStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EstimateStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
