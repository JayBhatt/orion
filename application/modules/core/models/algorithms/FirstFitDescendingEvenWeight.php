<?php

namespace Application\Modules\Core\Models\Algorithms;

/**
 * FirstFitDescendingEvenWeight
 *
 *
 * @package       Algorithms
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Sorts the cart items in descending order and then apply's the first first algorithm for sorting items and then arrange the weight so its distributed evenly.
 */
class FirstFitDescendingEvenWeight extends FirstFitDescending
{
    /**
     * Sorts the items in descending order and apply's first fit algorithm and re-arrange items in packages so the weight is even
     *
     * @param array $items  An array of cart items
     * @param int $cartTotalWeight  Total weight of items in cart
     * @param  int  $cartTotalCost  Total cost of items in cart
     * @return N/A
     */
    public function packItems(array $items, $cartTotalWeight, $cartTotalCost)
    {
        // Sort the cart items in descending order
        uasort($items, array($this, 'sortCartItemsByWeightDesc'));
        // Apply the first fit algorithm
        parent::packItems($items, $cartTotalWeight, $cartTotalCost);
    }
    
    /**
     *
     * Overrides the parent::getPackages() methods and rearranges packages to distrubte them evenly
     *
     * @param N/A
     * @return N/A
     */
    public function getPackages()
    {
    	$packages = parent::getPackages();
    	return $this->rearrangePackages($packages);
    }
    
    /**
     *
     * Rearrange packages in such a way that they are distributed evenly
     *
     * @param array $packages An array of packages
     * @return array $packages An array of packages
     */
    public function rearrangePackages($packages)
    {
    	//TODO: Re-arrange package in such a way that they are balanced evenly
    	return $packages;
    }
    
}