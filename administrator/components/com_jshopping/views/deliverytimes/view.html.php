<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewDeliveryTimes extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_DELIVERY_TIMES, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){        
        JToolBarHelper::title( $temp = ($this->edit) ? (_JSHOP_DELIVERY_TIME_EDIT.' / '.$this->deliveryTimes->{JSFactory::getLang()->get('name')}) : (_JSHOP_DELIVERY_TIME_NEW), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>