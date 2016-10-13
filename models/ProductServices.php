<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_services".
 *
 * @property integer $service_estimate_id
 * @property integer $service_id
 * @property integer $product_id
 * @property double $discount
 *
 * @property Products $product
 * @property Services $service
 */

class ProductServices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'product_id', 'discount'], 'required'],
            [['service_id', 'product_id'], 'integer'],
            [['discount'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'product_id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'service_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_estimate_id' => 'Service Estimate ID',
            'service_id' => 'Service ID',
            'product_id' => 'Product ID',
            'discount' => 'Discount',
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
    public function getService()
    {
        return $this->hasOne(Services::className(), ['service_id' => 'service_id']);
    }


}
