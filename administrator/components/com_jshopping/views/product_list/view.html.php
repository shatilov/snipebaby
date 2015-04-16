<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewProduct_list extends JView
{
    function display($tpl = null){
        JToolBarHelper::title( _JSHOP_LIST_PRODUCT, 'generic.png' ); 
        JToolBarHelper::addNewX();
        JToolBarHelper::custom('copy', 'copy', 'copy_f2.png', JText::_('JLIB_HTML_BATCH_COPY'));
        JToolBarHelper::editList('editlist');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();
        parent::display($tpl);
	}
    function displaySelectable($tpl = null){
        parent::display($tpl);
    }
}
?>