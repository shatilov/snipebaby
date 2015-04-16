<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewAddonkey extends JView
{
    function display($tpl = null){
        
        JToolBarHelper::title( _JSHOP_ENTER_LICENSE_KEY, 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();
        
        parent::display($tpl);
	}
}
?>