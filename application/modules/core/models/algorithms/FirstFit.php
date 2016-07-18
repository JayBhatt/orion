<?php

namespace Application\Modules\Core\Models\Algorithms;
use Application\Modules\Core\Models\Package;

/**
 * FirstFit
 *
 *
 * @package       Algorithms
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   This class finds the first package that can fit the item without increasing the capacity and adds the item to that package.
 */
class FirstFit extends Base
{

    /**
     * Holds the generated packages
     *
     * @var array
     * @access public
     */
    public $packages = array();

    /**
     * Pointer for the current package in which the item needs to be placed
     *
     * @var int
     * @access private
     */
    private $_currentPackage;

    /**
     * Holds the remaining capacity for a package
     *
     * @var int
     * @access private
     */
    private $_totalCapacityRemaining = 0;

    /**
     *
     * Initializes an empty array of packages.
     *
     * @param int $totalWeight  Total weight of items in cart
     * @param int $totalCost  Total cost of items in cart
     * @return N/A
     */
    public function initEmptyPackages($totalWeight, $totalCost)
    {
        // Find the maximum number of required packages
        $count_by_price = ceil($totalWeight / COST_LIMIT);
        $count_by_weight = ceil($totalCost / WEIGHT_LIMIT);
        $maxPackages = max(array($count_by_price, $count_by_weight));
        // Initialize empty packages
        for($i = 0; $i <= $maxPackages; $i++)
        {
            $this->packages[$i] = new Package();
        }
    }

    /**
     *
     * Loops through all the initialized packages and finds the first package that can fit the item and adds item to that package.
     *
     * @param array $items  An array of items in cart
     * @param int $cartTotalWeight  Total weight of cart items
     * @param int $cartTotalCost Total cost of cart items
     * @return N/A
     */
    public function packItems(array $items, $cartTotalWeight, $cartTotalCost)
    {
        // Initialize empty packages
        $this->initEmptyPackages($cartTotalWeight, $cartTotalCost);
        foreach ($items as $item)
        {
        	// Move to the first package before moving item
            $this->moveToFirstPackage();
            while ($this->_currentPackage !== count($this->packages))
            {
                // Check if the package can fit item
                if($this->packages[$this->_currentPackage]->canItemFit($item->getWeight(), $item->getCost()))
                {
                    // Add the item to package
                    $this->packages[$this->_currentPackage]->addItem($item);
                    break;
                } else
                {
                    // Current package can't fit this item. Move to next package
                    $this->moveToNextPackage();
                }
            }
        }
    }

    /**
     *
     * Returns the sum of capacity remaining in individual packages.
     *
     * @param N/A
     * @return N/A
     */
    public function getTotalCapacityRemaining()
    {
        foreach ($this->packages as $package)
        {
            $this->_totalCapacityRemaining = $this->_totalCapacityRemaining + $package->getCapacityRemaining();
        }
        return $this->_totalCapacityRemaining;
    }

    /**
     *
     * Returns an array of packages
     *
     * @param N/A
     * @return N/A
     */
    public function getPackages()
    {
        // Filter out empty packages
        $packages = array();
        foreach ($this->packages as $package) {
            if(!empty($package->getItems())){
                $shippingCost = $this->findShippingCost($package->getTotalWeight());
                $package->setShippingCost($shippingCost);
                $packages[] = $package;
            }
        }
        return $packages;
    }

    /**
     *
     * Finds the shipping cost depending on weight
     *
     * @param float $weight Total weight of package
     * @return float
     */
    public function findShippingCost($weight)
    {
        foreach ($_SESSION['shipping'] as $shipping)
        {
            if(($weight >= $shipping->getMinWeight()) && ($weight <= $shipping->getMaxWeight()))
            {
                return $shipping->getCost();
            }
        }
    }

    /**
     *
     * Moves the array pointer to next package in the package array
     *
     * @param N/A
     * @return N/A
     */
    public function moveToNextPackage()
    {
        $this->_currentPackage++;
    }

    /**
     *
     * Moves the array pointer to the first package in the package array
     *
     * @param N/A
     * @return N/A
     */
    public function moveToFirstPackage()
    {
        $this->_currentPackage = 0;
    }
}