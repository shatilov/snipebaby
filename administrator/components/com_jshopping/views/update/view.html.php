<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewUpdate extends JView
{
    function display($tpl = null){
        
        JToolBarHelper::title( _JSHOP_INSTALL_AND_UPDATE, 'generic.png' );         
        
        parent::display($tpl);
	}
}
?>