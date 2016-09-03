<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductsUsedPerArea]].
 *
 * @see ProductsUsedPerArea
 */
class ProductsUsedPerAreaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ProductsUsedPerArea[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductsUsedPerArea|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
