<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewUsers extends JView
{
    function displayList($tpl = null){        
        JToolBarHelper::title( _JSHOP_USER_LIST, 'generic.png' );
        JToolBarHelper::addNewX(); 
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl = null){
        $title = _JSHOP_USERS." / ";
        if ($this->user->user_id){
            $title.=$this->user->u_name;
        }else{
            $title.=_JSHOP_NEW;
        }
        JToolBarHelper::title($title, 'generic.png'); 
        JToolBarHelper::save();
        JToolBarHelper::apply();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>