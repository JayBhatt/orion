<?php

namespace Application\Modules\Core\Models\Interfaces;

/**
 * Algorithm
 *
 *
 * @package       Algorithms
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Interface for all the Algorithm classes. All Algorithm classes must implement packItems() and getPackages() methods.
 */
interface Algorithm
{
    /**
     *
     * Loops through all the initialized packages and finds the first package that can fit the item and adds item to that package.
     *
     * @param array $items  An array of items in cart
     * @param int $cartTotalWeight  Total weight of cart items
     * @param int $cartTotalCost Total cost of cart items
     * @return N/A
     */
    public function packItems(array $items, $cartTotalWeight, $cartTotalCost);

    /**
     *
     * Retruns an array of packages
     *
     * @param N/A
     * @return N/A
     */
    public function getPackages();

}