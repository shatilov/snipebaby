<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewAttributes extends JView{
    
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_ATTRIBUTES, 'generic.png' ); 
        JToolBarHelper::addNewX();        
        JToolBarHelper::deleteList();
        JToolBarHelper::spacer();
        JToolBarHelper::customX("addgroup","new-style","new-style",_JSHOP_GROUP, false);        
        parent::display($tpl);	
    }
    
    function displayEdit($tpl = null){
        JToolBarHelper::title( $temp = ($this->attribut->attr_id) ? (_JSHOP_EDIT_ATTRIBUT.' / '.$this->attribut->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW_ATTRIBUT), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}