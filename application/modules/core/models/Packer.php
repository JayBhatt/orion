<?php

namespace Application\Modules\Core\Models;

/**
 * Packer
 *
 *
 * @package       Models
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Represents a package.
 */
class Packer extends Base
{
    /**
     * Name of the algorithm the packer will use to pack items
     *
     * @var string
     * @access private
     */
    private $_algorithm;

    /**
     * Create an instance of the requested algorithm and pack items
     *
     * @param Cart $cart An instance of the cart
     * @param string $algorithmName Name of the algorithm that the packer should use to pack items
     * @return N/A
     */
    public function packItems(Cart $cart, $algorithmName)
    {
        $class = $this->getAlgorithmClass($algorithmName);
        $this->_algorithm = new $class();
        $this->_algorithm->packItems($cart->getCartItems(), $cart->getTotalWeight(), $cart->getTotalCost());
    }

    /**
     * Maps algorithm name with the algorithm class
     *
     * @param string $algorithm Name of the algorithm to map with a class
     * @return N/A
     * @throws OrionException
     */
    public function getAlgorithmClass($algorithm)
    {
        switch ($algorithm)
        {
            case (strtolower($algorithm) === 'firstfit'):
                return 'Application\Modules\Core\Models\Algorithms\FirstFit';
                break;
            case strtolower($algorithm) === 'firstfitascending':
                return 'Application\Modules\Core\Models\Algorithms\FirstFitAscending';
                break;
            case strtolower($algorithm) === 'firstfitdescending':
                return 'Application\Modules\Core\Models\Algorithms\FirstFitDescending';
                break;
            default:
                throw new OrionException('No class found for sorting algorithm '.$algorithm.'. Please make sure that the algorithm name is correct.');
        }

    }

    /**
     * Returns all the generated packages
     *
     * @param N/A
     * @return mixed
     */
    public function getPackages()
    {
        return $this->_algorithm->getPackages();
    }

}
