<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_used_per_area".
 *
 * @property integer $products_used_per_area_id
 * @property integer $estimated_area_id
 * @property integer $product_id
 * @property double $Quantity
 * @property double $product_cost_at_time
 *
 * @property Products $product
 * @property EstimatedAreas $estimatedArea
 */
class ProductsUsedPerArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_used_per_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['estimated_area_id', 'product_id'], 'integer'],
            [['quantity', 'product_cost_at_time'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'product_id']],
            [['estimated_area_id'], 'exist', 'skipOnError' => true, 'targetClass' => EstimatedAreas::className(), 'targetAttribute' => ['estimated_area_id' => 'estimated_area_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'products_used_per_area_id' => 'Products Used Per Area ID',
            'estimated_area_id' => 'Estimated Area ID',
            'product_id' => 'Product ID',
            'Quantity' => 'Quantity',
            'product_cost_at_time' => 'Product Cost At Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstimatedArea()
    {
        return $this->hasOne(EstimatedAreas::className(), ['estimated_area_id' => 'estimated_area_id']);
    }

    /**
     * @inheritdoc
     * @return ProductsUsedPerAreaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsUsedPerAreaQuery(get_called_class());
    }
}
