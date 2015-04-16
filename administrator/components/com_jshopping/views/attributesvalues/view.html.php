<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewAttributesValues extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_LIST_ATTRIBUT_VALUES, 'generic.png' );
        JToolBarHelper::custom( "back", 'back', 'back', _JSHOP_RETURN_TO_ATTRIBUTES, false);
        JToolBarHelper::addNewX();        
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){
        JToolBarHelper::title( $temp = ($this->attributValue->value_id) ? (_JSHOP_EDIT_ATTRIBUT_VALUE.' / '.$this->attributValue->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW_ATTRIBUT_VALUE), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>