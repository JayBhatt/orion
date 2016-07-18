<?php

namespace Application\Modules\Core\Models;

/**
 * Package
 *
 *
 * @package       Models
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Represents a package.
 */
class Package extends Base
{
    /**
     * An array of items belonging to this package
     *
     * @var array
     * @access public
     */
    public $items = array();

    /**
     * Cost limit for items in this package
     *
     * @var float
     * @access public
     */
    public $costLimit = COST_LIMIT;

    /**
     * Weight limit for items in this package
     *
     * @var float
     * @access public
     */
    public $weightLimit = WEIGHT_LIMIT;

    /**
     * Total cost of items in this package
     *
     * @var float
     * @access public
     */
    public $totalCost = 0;

    /**
     * Total weight of items in this package
     *
     * @var float
     * @access public
     */
    public $totalWeight = 0;

    /**
     * Capacity remaining (measure of how many more items can it fit?) in the current package
     *
     * @var float
     * @access public
     */
    public $capacityRemaining = 0;

    /**
     * Total shipping cost of a package
     *
     * @var float
     * @access public
     */
    public $shippingCost = 0;

    /**
     * Returns total weight of a parcel
     *
     * @param N/A
     * @return array
     */
    public function getTotalWeight()
    {
        return $this->totalWeight;
    }

    /**
     * Sets the value of shipping cost
     *
     * @param float $shippingCost Shipping cost of package
     * @return N/A
     */
    public function setShippingCost($shippingCost)
    {
        $this->shippingCost = $shippingCost;
    }

    /**
     * Returns an array of items in the current package
     *
     * @param N/A
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Returns capacity remaining for the current package
     *
     * @param N/A
     * @return flaat
     */
    public function getCapacityRemaining()
    {
        return $this->capacityRemaining;
    }

    /**
     * Adds an item to package
     *
     * @param Item $item An instance of the Item class
     * @return N/A
     */
    public function addItem(Item $item)
    {
        // Increment the total cost of the package
        $this->totalCost = $this->totalCost + $item->getCost();
        // Increment the total weight of the package
        $this->totalWeight = $this->totalWeight + $item->getWeight();
        // Set the capacity remaining of the package
        $this->capacityRemaining =  (($this->costLimit - $this->totalCost) + ($this->weightLimit - $this->totalWeight));
        // Add the item to package
        $this->items[] = $item;
    }

    /**
     * Checks if the item can fit into the package (If the total weight of package or the total cost of the package goes over the cost limit
     * or the weight limit, the item does not fit else the item fits)
     *
     * @param int $itemWeight weight of current item
     * @param int $itemCost Cost of current item
     * @return boolean
     */
    public function canItemFit($itemWeight, $itemCost)
    {
        if( (($this->totalWeight + $itemWeight) <= $this->weightLimit) && (($this->totalCost + $itemCost) <= $this->costLimit))
        {
            return true;
        }
        return false;
    }

}