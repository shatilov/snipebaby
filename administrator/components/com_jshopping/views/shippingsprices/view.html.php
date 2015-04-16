<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewShippingsPrices extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_SHIPPING_PRICES_LIST, 'generic.png' ); 
        JToolBarHelper::custom( "back", 'back', 'back', _JSHOP_LIST_SHIPPINGS, false);
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){
        JToolBarHelper::title( $temp = ($this->sh_method_price->sh_pr_method_id) ? (_JSHOP_EDIT_SHIPPING_PRICES) : (_JSHOP_NEW_SHIPPING_PRICES), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>