<?php

namespace app\models;

use yii\base\Model;

/**
 * Product is the model behind the product table.
 */
class Product extends Model
{
    public $id;
    public $category;
    public $name;
    public $price;
}
