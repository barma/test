<?php

use yii\db\Migration;

/**
 * Class m190114_190034_cars_data
 */
class m190114_190034_cars_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('car', ['title' => 'c180', 'url' => 'c180', 'categoryId' => 1, 'price' => '50']);
        $this->insert('car', ['title' => 's600', 'url' => 's600', 'categoryId' => 1, 'price' => '150']);
        $this->insert('car', ['title' => 'almera', 'url' => 'almera', 'categoryId' => 2, 'price' => '250']);
        $this->insert('car', ['title' => 'note', 'url' => 'note', 'categoryId' => 2, 'price' => '350']);
        $this->insert('car', ['title' => 'c3', 'url' => 'c3', 'categoryId' => 3, 'price' => '450']);
        $this->insert('car', ['title' => 'c4', 'url' => 'c4', 'categoryId' => 3, 'price' => '550']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('car', ['url' => 'c180']);
        $this->delete('car', ['url' => 's600']);
        $this->delete('car', ['url' => 'almera']);
        $this->delete('car', ['url' => 'note']);
        $this->delete('car', ['url' => 'c3']);
        $this->delete('car', ['url' => 'c4']);
    }
}
