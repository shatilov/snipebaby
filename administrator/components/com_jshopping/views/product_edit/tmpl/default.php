<?php
	defined('_JEXEC') or die();
    $row = $this->product;
    $lists = $this->lists;
    $tax_value = $this->tax_value;
    $jshopConfig = JSFactory::getConfig();
    $currency = $this->currency;
    JHTML::_('behavior.tooltip');
    jimport('joomla.html.pane');
    JHTML::_('behavior.modal', 'a.modal');
    
    $dispatcher = JDispatcher::getInstance();
?>
<div class="jshop_edit">
<script type="text/javascript">var lang_delete = "<?php print _JSHOP_DELETE; ?>";</script>
<form action = "index.php?option=com_jshopping&controller=products" method = "post" enctype = "multipart/form-data" name = "adminForm" id="item-form" >
   <?php
   $pane = JPane::getInstance('Tabs');
   echo $pane->startPane('productPane');

   if ($this->product->parent_id==0){
       include(dirname(__FILE__)."/description.php");
       include(dirname(__FILE__)."/info.php");
   }
   if ($this->product->parent_id==0){
       $dispatcher->trigger( 'onDisplayProductEditTabs', array(&$pane, &$row, &$lists, &$tax_value, &$currency) );
   }
   if ($jshopConfig->admin_show_attributes && $this->product->parent_id==0){
    include(dirname(__FILE__)."/attribute.php");
   }
   if ($jshopConfig->admin_show_freeattributes && $this->product->parent_id==0) {
    include(dirname(__FILE__)."/freeattribute.php");
   }
   include(dirname(__FILE__)."/images.php");
   if ($jshopConfig->admin_show_product_video && $this->product->parent_id==0) {
    include(dirname(__FILE__)."/videos.php");
   }
   if ($jshopConfig->admin_show_product_related && $this->product->parent_id==0) {
    include(dirname(__FILE__)."/related.php");
   }
   if ($jshopConfig->admin_show_product_files) {
    include(dirname(__FILE__)."/files.php");
   }
   if ($jshopConfig->admin_show_product_extra_field && $this->product->parent_id==0){
    include(dirname(__FILE__)."/extrafields.php");
   }
   if ($this->product->parent_id==0){
       $dispatcher->trigger('onDisplayProductEditTabsEnd', array(&$pane, &$row, &$lists, &$tax_value, &$currency) );
   }
   echo $pane->endPane();
   ?>
<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "current_cat" value = "<?php echo JRequest::getVar('current_cat', 0)?>" />
<input type = "hidden" name = "product_id" value = "<?php echo $row->product_id?>" />
<input type = "hidden" name = "parent_id" value = "<?php echo $row->parent_id?>" />
<?php print $this->tmp_html_end?>
</form>
</div>

<script type = "text/javascript">
var product_price_precision = <?php print intval($jshopConfig->product_price_precision)?>;
Joomla.submitbutton = function(task){
    if (task=='save' || task=='apply'){
        if (isEmpty($F_('product_width_image')) && isEmpty($F_('product_height_image'))){
           alert('<?php echo _JSHOP_WRITE_SIZE_BAD?>');
           return false;
        }
        <?php if ($this->product->parent_id==0){?>
        if ($_('category_id').selectedIndex == -1){
           alert('<?php echo _JSHOP_WRITE_SELECT_CATEGORY?>');
           return false;
        }
        <?php }?>
    }
    Joomla.submitform(task, document.getElementById('item-form'));
}
 
function showHideAddPrice(){
     $_('tr_add_price').style.display = ($_('product_is_add_price').checked)  ? ('') : ('none');
}
<?php if ($this->product->parent_id==0){?>
showHideAddPrice();
<?php }?>
</script>