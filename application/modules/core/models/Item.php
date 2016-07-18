<?php

namespace Application\Modules\Core\Models;

/**
 * Item
 *
 *
 * @package       Models
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Represents an item.
 */
class Item extends Base
{
    /**
     * Unique id of the item
     *
     * @var int
     * @access public
     */
    public $id;

    /**
     * Name of the item
     *
     * @var string
     * @access public
     */
    public $name;

    /**
     * Cost of the item
     *
     * @var float
     * @access public
     */
    public $cost;

    /**
     * Weight of the item
     *
     * @var float
     * @access public
     */
    public $weight;

    /**
     * Returns the value of item id
     *
     * @param N/A
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of item id
     *
     * @param int $id Item id
     * @return N/A
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the value of item name
     *
     * @param N/A
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of item name
     *
     * @param string $name Item name
     * @return N/A
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the value of item cost
     *
     * @param N/A
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Sets the value of item cost
     *
     * @param float $cost Item cost
     * @return N/A
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * Returns the value of item weight
     *
     * @param N/A
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Sets the value of item weight
     *
     * @param float $weight Item weight
     * @return N/A
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

}