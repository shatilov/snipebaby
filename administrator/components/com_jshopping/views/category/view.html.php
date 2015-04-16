<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewCategory extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_TREE_CATEGORY, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){
        JToolBarHelper::title( ($this->category->category_id) ? (_JSHOP_EDIT_CATEGORY.' / '.$this->category->{JSFactory::getLang()->get('name')}) : (_JSHOP_NEW_CATEGORY), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>