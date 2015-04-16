<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewProduct_labels extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_PRODUCT_LABELS, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){        
        JToolBarHelper::title( $temp = ($this->edit) ? (_JSHOP_PRODUCT_LABEL_EDIT.' / '.$this->productLabel->{JSFactory::getLang()->get('name')}) : (_JSHOP_PRODUCT_LABEL_NEW), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }    
}
?>