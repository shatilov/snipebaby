<?php
defined('_JEXEC' ) or die('Restricted access');
jimport('joomla.application.component.view');

class JshoppingViewAttributesgroups extends JView{

    function displayList($tpl = null){
        JToolBarHelper::title(_JSHOP_ATTRIBUTES_GROUPS, 'generic.png' );
        JToolBarHelper::custom( "back", 'back', 'back', _JSHOP_BACK_TO_ATTRIBUTES, false);
        JToolBarHelper::addNewX();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    
    function displayEdit($tpl = null){
        JToolBarHelper::title( ($this->row->id) ? (_JSHOP_EDIT.' / '.$this->row->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW), 'generic.png' );
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}