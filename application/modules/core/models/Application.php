<?php

namespace Application\Modules\Core\Models;


/**
 * Application
 *
 *
 * @package       Models
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Bootstraps the applications, runs it and handles all incoming requests and returns response.
 */
class Application
{

    /**
     * Autoloads the called class by name
     *
     * @param string $class  Name of class being called
     * @return N/A
     * @throws \Exception
     */
    public function loadClass($class)
    {
        $pieces = explode("\\", $class);
        $className = array_pop($pieces);
        $pieces = array_map("strtolower", $pieces);
        $classFile = BASE_DIR."/".join("/", $pieces).'/'.$className.".php";
        if(file_exists($classFile))
        {
            require_once $classFile;
            if(class_exists($class, false) || interface_exists($class, false))
            {
                return true;
            }
        }
        throw new \Exception("An error occurred while loading class ".$class.". Please make sure the class file exists.");
    }

    /**
     * Initializes session variables
     *
     * @param N/A
     * @return N/A
     */
    private function _initSession()
    {
        session_start();
        // Destroy the current session after making code changes.
        //$this->clearSession();
        if(empty($_SESSION['cart']))
        {
            $_SESSION['cart'] = array();
        }
        if(empty($_SESSION['shipping']))
        {
            $_SESSION['shipping'] = array();
        }
        if(empty($_SESSION['items']))
        {
            $_SESSION['items'] = array();
        }
        if(empty($_SESSION['algorithm']))
        {
        	$_SESSION['algorithm'] = "firstFit";
        }
    }

    /**
     * Registers the class loader with spl autoloader
     *
     * @param N/A
     * @return N/A
     */
    private function _initClassLoader()
    {
        spl_autoload_register(array($this, "loadClass"));
    }

    /**
     * Loads shipping items from shipping.json mock file into session variable
     *
     * @param N/A
     * @return N/A
     */
    private function _initShipping()
    {
        if(empty($_SESSION['shipping']))
        {
            $jsonString = file_get_contents(BASE_DIR.'/application/modules/core/mocks/shipping.json');
            $json = json_decode($jsonString, true);
            foreach ($json as $data)
            {
                $shipping = new Shipping();
                $shipping->setProperties($data);
                $_SESSION['shipping'][] = $shipping;
            }
        }
    }

    /**
     * Loads the items from items.json mock file into session variable
     *
     * @param N/A
     * @return N/A
     */
    private function _initItems()
    {
        if(empty($_SESSION['items']))
        {
            $jsonString = file_get_contents(BASE_DIR.'/application/modules/core/mocks/items.json');
            $json = json_decode($jsonString, true);
            foreach ($json as $data)
            {
                $item = new Item();
                $item->setProperties($data);
                $_SESSION['items'][] = $item;
            }
        }
    }

    /**
     * Bootstraps application
     *
     * @param N/A
     * @return N/A
     */
    public function bootstrap()
    {
        $this->_initClassLoader();
        $this->_initSession();
        $this->_initShipping();
        $this->_initItems();
    }

    /**
     * Clears session variables
     *
     * @param N/A
     * @return N/A
     */
    public function clearSession()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Serves as an entry point for various requests, processes them ane returns response.
     *
     * @param json $post args={"action":"action-name","param1":value, "param2" : value}
     * @return mixed
     * @throws OrionException
     */
    public function handleRequest($post)
    {
        if(!empty($post['args']))
        {
            $post = json_decode($post['args'], true);
            // List the items added to cart
            if(!empty($post['action']) && strtolower($post['action']) === 'list-items-cart')
            {
                $response = new Response();
                $cart = new Cart();
                $response->setCode(200);
                $response->setBody($cart->getCartItems());
                $response->sendResponse();
            }
            // Return a list of all the items that are not added in the cart
            else if(!empty($post['action']) && strtolower($post['action']) === 'list-items')
            {
                $response = new Response();
                $cart = new Cart();
                $response->setCode(200);
                $response->setBody($cart->getItems());
                $response->sendResponse();
            }
            // Add an item to the cart
            else if(!empty($post['action']) && strtolower($post['action']) === 'add-item-to-cart')
            {
                // Check if the id passed actually exists in items array.
                $cart = new Cart();
                $item = $cart->fetchItemFromItemList($_SESSION['items'], $post['id']);
                if(empty($item))
                {
                    throw new OrionException("This item doesn't exists in database and can't be added to cart.");
                }
                $response = new Response();
                $cart->addItem($item);
                $response->setCode(200);
                $response->setBody(true);
                $response->sendResponse();
            }
            // Remove an item from the cart
            else if(!empty($post['action']) && strtolower($post['action']) === 'remove-item-from-cart')
            {
                // Check if the id passed actually exists in items array.
                $cart = new Cart();
                $item = $cart->fetchItemFromItemList($_SESSION['items'], $post['id']);
                if(empty($item))
                {
                    throw new OrionException("This item doesn't exists in database and can't be removed from cart.");
                }
                $response = new Response();
                $cart->removeItem($item);
                $response->setCode(200);
                $response->setBody(true);
                $response->sendResponse();
            }
            // Execute the requested algorithm and generate packages
            else if(!empty($post['action']) && strtolower($post['action']) === 'get-packages')
            {
            	$algorithm = $_SESSION['algorithm'];
                // Check if the id passed actually exists in items array.
                if(empty($post['algorithm']))
                {
                	$_SESSION['algorithm'] = $post['algorithm'];
                	$algorithm = $post['algorithm'];
                }
                $response = new Response();
                $packer = new Packer();
                $cart = new Cart();
                $packer->packItems($cart, $algorithm);
                $response->setCode(200);
                $response->setBody($packer->getPackages());
                $response->sendResponse();
            }
            // Get current algorithm
            else if(!empty($post['action']) && strtolower($post['action']) === 'get-algorithm')
            {
            	$response = new Response();
            	$response->setCode(200);
            	$response->setBody($_SESSION['algorithm']);
            	$response->sendResponse();
            }
            // Set current algorithm
            else if(!empty($post['action']) && strtolower($post['action']) === 'set-algorithm')
            {
            	if(empty($post['algorithm']))
            	{
            		throw new OrionException('An empty algorighm can not be set for packaging items.');
            	}
            	$_SESSION['algorithm'] = $post['algorithm'];
            	$response = new Response();
            	$response->setCode(200);
            	$response->setBody(true);
            	$response->sendResponse();
            }
            // Empty cart
            else if(!empty($post['action']) && strtolower($post['action']) === 'empty-cart')
            {
            	$response = new Response();
            	$cart = new Cart();
            	$cart->emptyCart();
            	$response->setCode(200);
            	$response->setBody(true);
            	$response->sendResponse();
            }
        }
    }
}