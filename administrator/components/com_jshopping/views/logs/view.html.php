<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewLogs extends JView{
    
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LOGS, 'generic.png');
        parent::display($tpl);
	}
    
    function displayEdit($tpl = null){
        JToolBarHelper::title(_JSHOP_LOGS." / ".$this->filename, 'generic.png');
        JToolBarHelper::back();
        parent::display($tpl);
    }
}
?>