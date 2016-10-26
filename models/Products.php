<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_description
 * @property double $product_cost
 * @property double $product_quantity
 * @property string $ingredients
 * @property double $dilution
 * @property string $application
 * @property integer $service_id
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name', 'service_id'], 'required'],
            [['product_description', 'ingredients'], 'string'],
            [['product_cost', 'product_quantity', 'dilution'], 'number'],
            [['service_id'], 'integer'],
            [['product_name'], 'string', 'max' => 128],
            [['application'], 'string', 'max' => 60],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'service_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'product_description' => 'Product Description',
            'product_cost' => 'Product Cost',
            'product_quantity' => 'Product Quantity',
            'ingredients' => 'Ingredients',
            'dilution' => 'Dilution',
            'application' => 'Application',
            'service_id' => 'Service',
        ];
    }
}
