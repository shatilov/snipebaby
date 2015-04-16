<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewUnits extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_UNITS_MEASURE, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){
        JToolBarHelper::title( $temp = ($this->edit) ? (_JSHOP_UNITS_MEASURE_EDIT.' / '.$this->units->{JSFactory::getLang()->get('name')}) : (_JSHOP_UNITS_MEASURE_NEW), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::apply();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>