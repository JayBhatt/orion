<?php

namespace Application\Modules\Core\Models\Algorithms;

/**
 * FirstFitAscending
 *
 *
 * @package       Algorithms
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Sorts the cart items in ascending order and then apply's the first first algorithm for sorting items.
 */
class FirstFitAscending extends FirstFit
{

    /**
     * Sorts the items in ascending order and apply's first fit algorithm
     *
     * @param array $items  An array of cart items
     * @param int $cartTotalWeight  Total weight of items in cart
     * @param  int  $cartTotalCost  Total cost of items in cart
     * @return N/A
     */
    public function packItems(array $items, $cartTotalWeight, $cartTotalCost)
    {
        // Sort the cart items in ascending order
        usort($items, array($this, 'sortCartItemsByWeightAsc'));
        // Apply the first fit algorithm
        parent::packItems($items, $cartTotalWeight, $cartTotalCost);
    }

}