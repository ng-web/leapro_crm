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
 *
 * @property ProductsUsedPerArea[] $productsUsedPerAreas
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
            [['product_name'], 'required'],
            [['product_description'], 'string'],
            [['product_cost', 'product_quantity'], 'number'],
            [['product_name'], 'string', 'max' => 128],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsUsedPerAreas()
    {
        return $this->hasMany(ProductsUsedPerArea::className(), ['product_id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }

    public static function FindProductSql($id)
    {
        $FindEstimateSql = Yii::$app->db->createCommand('SELECT * FROM products inner join `product_services` on products.product_id = product_services.product_id
         inner join services on services.service_id = product_services.service_id where products.product_id = :id')->bindValues([':id'=>$id])->queryAll();

        return $FindEstimateSql;
    }
}