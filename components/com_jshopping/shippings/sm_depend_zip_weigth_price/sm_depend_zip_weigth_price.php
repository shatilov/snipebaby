<?php

class sm_depend_zip_weigth_price extends shippingextRoot{

    var $version = 2;
    
    function showShippingPriceForm($params, &$shipping_ext_row, &$template){
        JSFactory::loadExtLanguageFile('sm_depend_zip_weigth_price');
        $document = JFactory::getDocument();
        $document->addCustomTag('<script type = "text/javascript" src = "'.JURI::root().'components/com_jshopping/shippings/sm_depend_zip_weigth_price/js/shipping_zip_weight_price_depend.js"></script>');    
        include(dirname(__FILE__)."/shippingpriceform.php");
    }
    
    function showConfigForm($config, &$shipping_ext, &$template){
        JSFactory::loadExtLanguageFile('sm_depend_zip_weigth_price');
        include(dirname(__FILE__)."/configform.php");
    }
    
    function getPrices($cart, $params, $prices, &$shipping_ext_row, &$shipping_method_price){
        $user = JFactory::getUser();
        $jshopConfig = JSFactory::getConfig();  
        $config = unserialize($shipping_ext_row->params);
        if ($user->id){
            $adv_user = JSFactory::getUserShop();
        }else{
            $adv_user = JSFactory::getUserShopGuest();    
        }
         if ($adv_user->delivery_adress){
            $zip = $adv_user->d_zip;
        }else{
            $zip = $adv_user->zip;
        }
        $weight_sum = $cart->getWeightProducts();
        
        $price_sum = $cart->getSum();
        $price_sum = $price_sum / $jshopConfig->currency_value;

        if(count($params['shipping_pricezipweight_zip_from']))
        foreach ($params['shipping_pricezipweight_zip_from'] as $key=>$value){
        
            if ($weight_sum >= $params['shipping_pricezipweight_weight_from'][$key] && ($weight_sum <= $params['shipping_pricezipweight_weight_to'][$key] || $params['shipping_pricezipweight_weight_to'][$key]==0) 
            && $zip >= $params['shipping_pricezipweight_zip_from'][$key] && ($zip <= $params['shipping_pricezipweight_zip_to'][$key] || $params['shipping_pricezipweight_zip_to'][$key]=='') 
            && $price_sum >= $params['shipping_pricezipweight_price_from'][$key] && ($price_sum <= $params['shipping_pricezipweight_price_to'][$key] || $params['shipping_pricezipweight_price_to'][$key]==0) 
            ) {
                $pricemultiply = $weight_sum;
                if ($config['weight_pallet'] != 0)
                { 
                    $pricemultiply = intval($weight_sum / $config['weight_pallet']);
                    if ($weight_sum % $config['weight_pallet'] > 0)
                    {
                        $pricemultiply = $pricemultiply +1;    
                    }
                }
                $prices['shipping'] = ($config['weight_multiply']) ? $params['shipping_pricezipweight_price'][$key]*$pricemultiply : $params['shipping_pricezipweight_price'][$key];
                $prices['package'] = ($config['weight_multiply_packing']) ? $params['shipping_pricezipweight_package_price'][$key]*$pricemultiply : $params['shipping_pricezipweight_package_price'][$key];
                break;
            }
        }
    return $prices;
    }
}
?>