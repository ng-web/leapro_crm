<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Estimates]].
 *
 * @see Estimates
 */
class EstimatesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Estimates[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Estimates|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
