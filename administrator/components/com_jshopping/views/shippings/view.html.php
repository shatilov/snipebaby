<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewShippings extends JView{
    
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_SHIPPINGS, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();
        JToolBarHelper::customX("ext_price_calc","options","options",_JSHOP_SHIPPING_EXT_PRICE_CALC, false);        
        parent::display($tpl);
	}
    
    function displayEdit($tpl = null){        
        JToolBarHelper::title( $temp = ($this->edit) ? (_JSHOP_EDIT_SHIPPING.' / '.$this->shipping->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW_SHIPPING), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>