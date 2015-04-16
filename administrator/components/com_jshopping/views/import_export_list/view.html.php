<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');
class JshoppingViewImport_Export_list extends JView{
    function display($tpl = null){
        JToolBarHelper::title( _JSHOP_PANEL_IMPORT_EXPORT, 'generic.png' );
        JToolBarHelper::help("importexport", true);
        JHtml::_('behavior.framework');
        parent::display($tpl);
	}
}
?>