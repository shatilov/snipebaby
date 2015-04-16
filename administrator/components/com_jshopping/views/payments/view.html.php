<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewPayments extends JView{

    function displayList($tpl = null){
        JToolBarHelper::title( _JSHOP_LIST_PAYMENTS, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();
        parent::display($tpl);
	}

    function displayEdit($tpl = null){
        JToolBarHelper::title( $this->payment->payment_id ? (_JSHOP_EDIT_PAYMENT.' / '.$this->payment->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW_PAYMENT), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>