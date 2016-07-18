<?php

namespace Application\Modules\Core\Models;

/**
 * Shipping
 *
 *
 * @package       Models
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Represents a Shipping Method.
 */
class Shipping extends Base
{
    /**
     * Unique id of the shipping method
     *
     * @var int
     * @access public
     */
    public $id;

    /**
     * cost of the shipping method
     *
     * @var float
     * @access public
     */
    public $cost;

    /**
     * minimum weight for this shipping method
     *
     * @var float
     * @access public
     */
    public $minWeight;

    /**
     * maximum weight for this shipping method
     *
     * @var float
     * @access public
     */
    public $maxWeight;

    /**
     * Returns the value of shipping id
     *
     * @param N/A
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of shipping id
     *
     * @param int $id Shipping id
     * @return N/A
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the value of shipping cost
     *
     * @param N/A
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Sets the value of shipping cost
     *
     * @param float $cost Shipping cost
     * @return N/A
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * Returns the value of minimum shipping weight
     *
     * @param N/A
     * @return float
     */
    public function getMinWeight()
    {
        return $this->minWeight;
    }

    /**
     * Sets the value of minimum weight
     *
     * @param float $minWeight Shipping minimum weight
     * @return N/A
     */
    public function setMinWeight($minWeight)
    {
        $this->minWeight = $minWeight;
    }

    /**
     * Returns the value of maximum shipping weight
     *
     * @param N/A
     * @return float
     */
    public function getMaxWeight()
    {
        return $this->maxWeight;
    }

    /**
     * Sets the value of maximum weight
     *
     * @param float $maxWeight Shipping maximum weight
     * @return N/A
     */
    public function setMaxWeight($maxWeight)
    {
        $this->maxWeight = $maxWeight;
    }

}