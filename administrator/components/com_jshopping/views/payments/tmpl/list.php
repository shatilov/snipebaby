<?php
defined('_JEXEC') or die();
displaySubmenuOptions();
$payments = $this->rows;
$count = count($payments);
$i = 0;
$saveOrder = $this->filter_order_Dir=="asc" && $this->filter_order=="payment_ordering";
?>
<form action = "index.php?option=com_jshopping&controller=payments" method = "post" name = "adminForm">
<?php print $this->tmp_html_start?>
<table class = "adminlist" width = "70%">
<thead>
    <tr>
        <th class = "title" width  = "10">
            #
        </th>
        <th width = "20">
            <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo $count;?>);" />
        </th>
        <th align = "left">
            <?php echo JHTML::_('grid.sort', _JSHOP_TITLE, 'name', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
        <th width = "12%" align = "left">
            <?php echo JHTML::_('grid.sort', _JSHOP_CODE, 'payment_code', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
        <th width = "15%" align = "left">
            <?php echo JHTML::_('grid.sort', _JSHOP_ALIAS, 'payment_class', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
        <?php echo $this->tmp_extra_column_headers?>
        <th width = "15%" align = "left">
            <?php echo JHTML::_('grid.sort', _JSHOP_SCRIPT_NAME, 'scriptname', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
        <th width = "40" colspan = "3">
            <?php echo JHTML::_('grid.sort', _JSHOP_ORDERING, 'payment_ordering', $this->filter_order_Dir, $this->filter_order); ?>
            <?php if ($saveOrder){?>
            <a class="saveorder" href="javascript:saveorder(<?php echo ($count-1);?>, 'saveorder')"></a>
            <?php }?>
        </th>
        <th width = "50">
            <?php echo _JSHOP_PUBLISH; ?>
        </th>
        <th width="50">
            <?php print _JSHOP_EDIT; ?>
        </th>
        <th width = "40">
            <?php echo JHTML::_('grid.sort', _JSHOP_ID, 'payment_id', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
    </tr>
</thead>
<?php
 $count = count($payments);
 if ($count)
 foreach($payments as $payment){
  ?>
  <tr class = "row<?php echo $i % 2;?>">
   <td>
     <?php echo $i+1;?>
   </td>
   <td>
     <input type = "checkbox" onclick = "isChecked(this.checked)" name = "cid[]" id = "cb<?php echo $i;?>" value = "<?php echo $payment->payment_id?>" />
   </td>
   <td>
     <a title = "<?php echo _JSHOP_EDIT_PAYMENT;?>" href = "index.php?option=com_jshopping&controller=payments&task=edit&payment_id=<?php echo $payment->payment_id; ?>"><?php echo $payment->name;?></a>
   </td>
   <td>
     <?php echo $payment->payment_code;?>
   </td>
   <td>
     <?php echo $payment->payment_class;?>
   </td>
   <?php echo $payment->tmp_extra_column_cells?>
   <td>
     <?php echo $payment->scriptname;?>
   </td>
   <td align = "right" width = "20">
    <?php
      if ($i != 0 && $saveOrder) echo '<a href = "index.php?option=com_jshopping&controller=payments&task=order&id=' . $payment->payment_id . '&order=up&number=' . $payment->payment_ordering . '"><img alt="' . _JSHOP_UP . '" src="components/com_jshopping/images/uparrow.png"/></a>';
    ?>
   </td>
   <td align = "left" width = "20">
      <?php
        if ($i != $count - 1 && $saveOrder) echo '<a href = "index.php?option=com_jshopping&controller=payments&task=order&id=' . $payment->payment_id . '&order=down&number=' . $payment->payment_ordering . '"><img alt="' . _JSHOP_DOWN . '" src="components/com_jshopping/images/downarrow.png"/></a>';
      ?>
   </td>
   <td align = "center" width = "10">
    <input type="text" name="order[]" id = "ord<?php echo $payment->payment_id;?>" size="5" value="<?php echo $payment->payment_ordering?>" <?php if (!$saveOrder) echo 'disabled'?> class="text_area" style="text-align: center" />
   </td>
   <td align = "center">
     <?php
       echo $published = ($payment->payment_publish) ? ('<a href = "javascript:void(0)" onclick = "return listItemTask(\'cb' . $i . '\', \'unpublish\')"><img src="components/com_jshopping/images/tick.png" title = "'._JSHOP_PUBLISH.'" ></a>') : ('<a href = "javascript:void(0)" onclick = "return listItemTask(\'cb' . $i . '\', \'publish\')"><img title = "'._JSHOP_UNPUBLISH.'" src="components/com_jshopping/images/publish_x.png"></a>');
     ?>
   </td>
   <td align="center">
        <?php print "<a href='index.php?option=com_jshopping&controller=payments&task=edit&payment_id=".$payment->payment_id."'><img src='components/com_jshopping/images/icon-16-edit.png'></a>"?>
   </td>
   <td align="center">
        <?php print $payment->payment_id;?>
   </td>
  </tr>
<?php
$i++;
 }
?>
</table>
    
<?php if ($this->config->advert) include('payment_advert.php');?>

<input type="hidden" name="filter_order" value="<?php echo $this->filter_order?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter_order_Dir?>" />
<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "hidemainmenu" value = "0" />
<input type = "hidden" name = "boxchecked" value = "0" />
<?php print $this->tmp_html_end?>
</form>