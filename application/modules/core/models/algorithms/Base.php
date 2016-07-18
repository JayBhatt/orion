<?php

namespace Application\Modules\Core\Models\Algorithms;
use Application\Modules\Core\Models\Interfaces\Algorithm;
use Application\Modules\Core\Models\Item;

/**
 * Base
 *
 *
 * @package       Algorithms
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Holds common functions used by all the algorithm classes for code reuse.
 */
abstract class Base implements Algorithm
{
    /**
     * Sorts cart items by weight in ascending order
     *
     * @param Item $a  An item in the cart item array
     * @param Item $b   An item in the cart item array
     * @return int
     */
    public function sortCartItemsByWeightAsc($a, $b)
    {
        return $a->weight - $b->weight;
    }

    /**
     * Sorts cart items by weight in descending order
     *
     * @param Item $a  An item in the cart item array
     * @param Item $b   An item in the cart item array
     * @return int
     */
    public function sortCartItemsByWeightDesc($a, $b)
    {
        if ($a->weight == $b->weight)
        {
            return 0;
        }
        else if($a->weight < $b->weight)
        {
            return +1;
        }
        else
        {
            return -1;
        }

    }
}