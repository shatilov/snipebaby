<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewOrderStatus extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_ORDER_STATUSS, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){
        JToolBarHelper::title( $temp = ($this->edit) ? (_JSHOP_EDIT_ORDER_STATUS.' / '.$this->order_status->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW_ORDER_STATUS), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>