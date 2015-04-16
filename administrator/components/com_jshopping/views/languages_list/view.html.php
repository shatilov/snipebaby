<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewLanguages_list extends JView
{
    function display($tpl = null){
        
        JToolBarHelper::title( _JSHOP_LIST_LANGUAGE, 'generic.png' ); 
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        parent::display($tpl);
	}
}
?>