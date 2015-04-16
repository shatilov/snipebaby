<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewPanel extends JView
{
    function displayHome($tpl = null){
        JToolBarHelper::title( JText::_("JoomShopping"), 'generic.png' );
        parent::display($tpl);
	}
    function displayInfo($tpl = null){
        JToolBarHelper::title( _JSHOP_ABOUT_AS, 'generic.png' );
        parent::display($tpl);
    }
    function displayConfig($tpl = null){
        JToolBarHelper::title( _JSHOP_CONFIG, 'generic.png' );
        if (JFactory::getUser()->authorise('core.admin')){
            JToolBarHelper::preferences('com_jshopping');
        }
        parent::display($tpl);
    }
    function displayOptions($tpl = null){
        JToolBarHelper::title( _JSHOP_OTHER_ELEMENTS, 'generic.png' );
        parent::display($tpl);
    }
}
?>