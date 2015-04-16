<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewStatistic extends JView
{
    function display($tpl = null){
        
        JToolBarHelper::title( _JSHOP_LIST_ORDER_STATUSS, 'generic.png' ); 
        //JToolBarHelper::addNewX();
        //JToolBarHelper::deleteList();
        
        parent::display($tpl);
	}
}
?>