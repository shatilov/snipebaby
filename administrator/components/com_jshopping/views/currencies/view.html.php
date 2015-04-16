<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewCurrencies extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_CURRENCY, 'generic.png' ); 
        JToolBarHelper::makeDefault("setdefault");
        JToolBarHelper::addNewX();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){        
        JToolBarHelper::title(  $temp = ($this->edit) ? (_JSHOP_EDIT_CURRENCY." / ".$this->currency->currency_name) : (_JSHOP_NEW_CURRENCY), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>