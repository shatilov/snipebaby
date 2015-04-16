<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewProduct_edit extends JView{

    function display($tpl = null){
        $title = _JSHOP_NEW_PRODUCT;
        if ($this->edit){
            $title = _JSHOP_EDIT_PRODUCT;
            if (!$this->product_attr_id) $title .= ' "'.$this->product->name.'"';
        }
        JToolBarHelper::title($title, 'generic.png' );
        JToolBarHelper::save();
        if (!$this->product_attr_id){
            JToolBarHelper::spacer();
            JToolBarHelper::apply();
            JToolBarHelper::spacer();
            JToolBarHelper::cancel();
        }
        parent::display($tpl);
	}

    function editGroup($tpl = null){
        JToolBarHelper::title(_JSHOP_EDIT_PRODUCT, 'generic.png');
        JToolBarHelper::save("savegroup");
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>