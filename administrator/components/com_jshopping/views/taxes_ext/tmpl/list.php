<?php
	defined('_JEXEC') or die();
	displaySubmenuOptions("taxes");
	$taxes = $this->rows;
	$i = 0;
?>
<form action = "index.php?option=com_jshopping&controller=exttaxes&back_tax_id=<?php print $this->back_tax_id;?>" method = "post" name = "adminForm">
<?php print $this->tmp_html_start?>
<table class = "adminlist">
<thead>
  <tr>
    <th class = "title" width  = "10">
        #
    </th>
    <th width = "20">
        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo $count = count( $taxes );?>);" />
    </th>
    <th align = "left">
        <?php echo _JSHOP_TITLE; ?>
    </th>
    <th>
        <?php echo _JSHOP_COUNTRY; ?>
    </th>
    <th width = "60">
        <?php echo JHTML::_('grid.sort', _JSHOP_TAX, 'ET.tax', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width = "60">
        <?php 
        if ($this->config->ext_tax_rule_for==1) 
            echo JHTML::_('grid.sort', _JSHOP_USER_WITH_TAX_ID_TAX, 'ET.firma_tax', $this->filter_order_Dir, $this->filter_order);
        else
            echo JHTML::_('grid.sort', _JSHOP_FIRMA_TAX, 'ET.firma_tax', $this->filter_order_Dir, $this->filter_order);
        ?>
    </th>
    <th width = "50">
        <?php echo _JSHOP_EDIT; ?>
    </th>
    <th width = "40">
        <?php echo JHTML::_('grid.sort', _JSHOP_ID, 'ET.id', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
  </tr>
</thead>  
<?php
 foreach($taxes as $tax){
  ?>
  <tr class = "row<?php echo $i % 2;?>">
   <td>
     <?php echo $i+1;?>
   </td>
   <td>
     <input type = "checkbox" onclick = "isChecked(this.checked)" name = "cid[]" id = "cb<?php echo $i++;?>" value = "<?php echo $tax->id?>" />
   </td>
   <td>
     <?php echo $tax->tax_name;?>
   </td>
   <td>
    <?php echo $tax->countries;?>
   </td>
   <td>
    <?php echo $tax->tax;?> %
   </td>
   <td>
    <?php echo $tax->firma_tax;?> %
   </td>
   <td align="center">
        <?php print "<a href='index.php?option=com_jshopping&controller=exttaxes&task=edit&id=".$tax->id."&back_tax_id=".$this->back_tax_id."'><img src='components/com_jshopping/images/icon-16-edit.png'></a>"?>
   </td>
   <td align="center">
        <?php print $tax->id;?>
   </td>
  </tr>
  <?php
}
?>
</table>

<input type="hidden" name="filter_order" value="<?php echo $this->filter_order?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter_order_Dir?>" />
<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "hidemainmenu" value = "0" />
<input type = "hidden" name = "boxchecked" value = "0" />
<?php print $this->tmp_html_end?>
</form>