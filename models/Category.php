<?php


namespace app\models;

use yii\base\Model;

/**
 * Class Category
 * @package app\models
 */
class Category extends Model
{

    /**
     * list of categories of cars
     */
    public static function getList() {
        return [1 => 'mercedes', 2 => 'nissan', 3 => 'audi'];
    }

}