<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewTaxes extends JView
{
    function displayList($tpl = null){
        JToolBarHelper::title( _JSHOP_LIST_TAXES, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){        
        JToolBarHelper::title( $temp = ($this->edit) ? (_JSHOP_EDIT_TAX." / ".$this->tax->tax_name) : (_JSHOP_NEW_TAX), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>