<?php
/**
* @version      3.12.0 20.12.2011
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

class sm_standart_price extends shippingextRoot{
    
    var $version = 2;
    
    function showShippingPriceForm($params, &$shipping_ext_row, &$template){        
        include(dirname(__FILE__)."/shippingpriceform.php");
    }
    
    function showConfigForm($config, &$shipping_ext, &$template){
        include(dirname(__FILE__)."/configform.php");
    }
    
    function getPrices($cart, $params, $prices, &$shipping_ext_row, &$shipping_method_price){
        $price_sum = $cart->getPriceProducts();
        $sh_price = $shipping_method_price->getPrices("desc");
        foreach($sh_price as $sh_pr){
            if ($price_sum >= $sh_pr->shipping_price_from && ($price_sum <= $sh_pr->shipping_price_to || $sh_pr->shipping_price_to==0)) {
                $prices['shipping'] = $sh_pr->shipping_price;
                $prices['package'] = $sh_pr->shipping_package_price;
                break;
            }
        }
    return $prices;
    }
}

?>