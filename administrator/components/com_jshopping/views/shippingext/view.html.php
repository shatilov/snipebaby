<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewShippingExt extends JView{
    
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_SHIPPING_EXT_PRICE_CALC, 'generic.png' );        
        JToolBarHelper::custom( "back", 'back', 'back', _JSHOP_LIST_SHIPPINGS, false);        
        parent::display($tpl);
    }
    
    function displayEdit($tpl = null){        
        JToolBarHelper::title( _JSHOP_SHIPPING_EXT_PRICE_CALC, 'generic.png' );        
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>