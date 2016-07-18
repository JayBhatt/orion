<?php

namespace Application\Modules\Core\Models;

/**
 * Cart
 *
 *
 * @package       Models
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Holds all the methods for managing a shopping cart
 */
class Cart extends Base
{

    /**
     * Returns current items in cart.
     *
     * @param N/A
     * @return N/A
     */
    public function getCartItems()
    {
        return $_SESSION['cart'];
    }

    /**
     * Returns an array of all the items in session. Ignores the items that are already added in cart.
     *
     * @param N/A
     * @return array
     */
    public function getItems()
    {
        $items = array();
        // If the item already exists in cart then skipp it from the item list (Avoids adding duplicate items to cart).
        foreach ($_SESSION['items'] as $item)
        {
            if($this->inCart($item->id))
            {
                continue;
            }
            $items[] = $item;
        }
        return $items;
    }

    /**
     * Adds an item to cart.
     *
     * @param Item An item object
     * @return N/A
     * @throws OrionException
     */
    public function addItem(Item $item)
    {
        if(empty($item) || empty($item->getId()))
        {
            throw new OrionException("An empty item can not be added to cart.");
        }
        if($item->getWeight() > WEIGHT_LIMIT || $item->getCost() > COST_LIMIT)
        {
            throw new OrionException("The item you are trying to add exceeds the weight limit of ".WEIGHT_LIMIT." KG and or cost limit of $".COST_LIMIT);
        }
        $_SESSION['cart'][] = $item;
    }

    /**
     * Removes an item from the cart.
     *
     * @param Item An item object
     * @return N/A
     */
    public function removeItem(Item $item)
    {
        $items = array();
        foreach ($_SESSION['cart'] as $cartItem)
        {
            if($cartItem->id === $item->id)
            {
                continue;
            }
            $items[] = $cartItem;
        }
        $_SESSION['cart'] = $items;
    }

    /**
     * Adds up the cost of all the items in the cart and returns it.
     *
     * @param N/A
     * @return int
     */
    public function getTotalCost()
    {
        $totalCost = 0;
        if($this->isCartEmpty())
        {
            return $totalCost;
        }
        foreach ($_SESSION['cart'] as $item)
        {
            $totalCost = $totalCost + $item->getCost();
        }
        return $totalCost;
    }

    /**
     * Adds up the weight of all the items in the cart and returns it.
     *
     * @param N/A
     * @return int
     */
    public function getTotalWeight()
    {
        $totalWeight = 0;
        if($this->isCartEmpty())
        {
            return $totalWeight;
        }
        foreach ($_SESSION['cart'] as $item)
        {
            $totalWeight = $totalWeight + $item->getWeight();
        }
        return $totalWeight;
    }

    /**
     * Checks if the there are items in the cart or not.
     *
     * @param N/A
     * @return boolean
     */
    public function isCartEmpty()
    {
        if(empty($_SESSION['cart']))
        {
            true;
        }
        return false;
    }

    /**
     * Returns a single item from the item list based on item id.
     *
     * @param array $items An array of items.
     * @return Item
     */
    public function fetchItemFromItemList($items, $id)
    {
        $fetchedItem = null;
        foreach ($items as $item){
            if($item->id === $id){
                $fetchedItem = $item;
            }
        }
        return $fetchedItem;
    }

    /**
     * Checks if an item exists in cart or not.
     *
     * @param int $id Id of the item.
     * @return boolean
     */
    public function inCart($id)
    {
        if(empty($_SESSION['cart']))
        {
            return false;
        }
        foreach ($_SESSION['cart'] as $item)
        {
            if($item->id === $id)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Removes all the items from cart.
     *
     * @param N/A
     * @return N/A
     */
    public function emptyCart() {
        $_SESSION['cart'] = array();
        $_SESSION['algorithm'] = "firstFit";
    }

}