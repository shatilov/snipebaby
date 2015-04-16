<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewVendors extends JView
{
    function displayList($tpl = null){
        JToolBarHelper::title( _JSHOP_VENDORS, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();
        parent::display($tpl);
	}
    function displayEdit($tpl = null){
        JToolBarHelper::title( $this->vendor->id ? _JSHOP_VENDORS.' / '.$this->vendor->shop_name : _JSHOP_VENDORS, 'generic.png' );
        JToolBarHelper::save();
        JToolBarHelper::apply();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>