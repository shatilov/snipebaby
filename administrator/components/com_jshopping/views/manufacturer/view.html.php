<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewManufacturer extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_MANUFACTURERS, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){        
        JToolBarHelper::title( $temp = ($this->edit) ? (_JSHOP_EDIT_MANUFACTURER.' / '.$this->manufacturer->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW_MANUFACTURER), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>