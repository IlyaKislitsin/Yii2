<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 08.06.2018
 * Time: 14:31
 */

namespace app\models;


class Product
{
    protected $id;
    protected $title;
    protected $category;
    protected $price;

    /**
     * Product constructor.
     * @param $id
     * @param $title
     * @param $category
     * @param $price
     */
    public function __construct($id, $title, $category, $price)
    {
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
    }
}