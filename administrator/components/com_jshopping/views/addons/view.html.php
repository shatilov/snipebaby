<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewAddons extends JView
{
    function displayList($tpl = null){
        JToolBarHelper::title( _JSHOP_ADDONS, 'generic.png' );
        parent::display($tpl);
	}
    
    function displayEdit($tpl = null){        
        JToolBarHelper::title(_JSHOP_ADDONS." / "._JSHOP_CONFIG.' / '.$this->row->name, 'generic.png' );
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
    
    function displayInfo($tpl = null){        
        JToolBarHelper::title(_JSHOP_ADDONS." / "._JSHOP_DESCRIPTION.' / '.$this->row->name, 'generic.png' );
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
    
    function displayVersion($tpl = null){        
        JToolBarHelper::title(_JSHOP_ADDONS." / "._JSHOP_VERSION.' / '.$this->row->name, 'generic.png' );
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>