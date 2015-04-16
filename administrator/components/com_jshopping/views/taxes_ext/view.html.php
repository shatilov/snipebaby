<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewTaxes_ext extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_TAXES_EXT, 'generic.png' );
        JToolBarHelper::custom( "back", 'back', 'back', _JSHOP_LIST_TAXES, false);
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){
        JToolBarHelper::title( $temp = ($this->tax->id) ? (_JSHOP_EDIT_TAX_EXT) : (_JSHOP_NEW_TAX_EXT), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::apply();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>