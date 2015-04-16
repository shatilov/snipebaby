<?php
	defined('_JEXEC') or die();
	displaySubmenuOptions();
	$coupons = $this->rows;
	$pageNav = $this->pageNav;
	$i = 0;
?>
<form action="index.php?option=com_jshopping&controller=coupons" method="post" name="adminForm" id="adminForm">
<?php print $this->tmp_html_start?>
<?php
if (isset($this->ext_coupon_html_befor_list)){
    print $this->ext_coupon_html_befor_list;
}
?>
<table class = "adminlist">
<thead>
  <tr>
    <th class = "title" width  = "10">
      #
    </th>
    <th width = "20">
      <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $coupons );?>);" />
    </th>
    <th align = "left">
        <?php echo JHTML::_('grid.sort', _JSHOP_CODE, 'C.coupon_code', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width = "200" align = "left">
        <?php echo JHTML::_('grid.sort', _JSHOP_VALUE, 'C.coupon_value', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width = "80">
        <?php echo JHTML::_('grid.sort', _JSHOP_START_DATE_COUPON, 'C.coupon_start_date', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width = "80">
        <?php echo JHTML::_('grid.sort', _JSHOP_EXPIRE_DATE_COUPON, 'C.coupon_expire_date', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width = "80">
        <?php echo JHTML::_('grid.sort', _JSHOP_FINISHED_AFTER_USED, 'C.finished_after_used', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width = "80">
        <?php echo JHTML::_('grid.sort', _JSHOP_FOR_USER, 'C.for_user_id', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width = "80">
        <?php echo JHTML::_('grid.sort', _JSHOP_COUPON_USED, 'C.used', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <?php echo $this->tmp_extra_column_headers?>
    <th width = "50">
        <?php echo _JSHOP_PUBLISH;?>
    </th>
    <th width = "50">
        <?php echo _JSHOP_EDIT;?>
    </th>
    <th width = "40">
        <?php echo JHTML::_('grid.sort', _JSHOP_ID, 'C.coupon_id', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
  </tr>
</thead>  
<?php
foreach($coupons as $coupon){
    $finished = 0; $date = date('Y-m-d');
    if ($coupon->used) $finished = 1;
    if ($coupon->coupon_expire_date < $date && $coupon->coupon_expire_date!='0000-00-00' ) $finished = 1;
?>
  <tr class = "row<?php echo $i % 2;?>" <?php if ($finished) print "style='font-style:italic; color: #999;'"?>>
   <td>
     <?php echo $pageNav->getRowOffset($i);?>
   </td>
   <td>
    <input type = "checkbox" onclick = "isChecked(this.checked)" name = "cid[]" id = "cb<?php echo $i;?>" value = "<?php echo $coupon->coupon_id?>" />
   </td>
   <td>
     <a href = "index.php?option=com_jshopping&controller=coupons&task=edit&coupon_id=<?php echo $coupon->coupon_id; ?>"><?php echo $coupon->coupon_code;?></a>
   </td>
   <td>
     <?php echo $coupon->coupon_value; ?>
     <?php if ($coupon->coupon_type==0) print "%"; else print $this->currency;?>
   </td>
   <td>
    <?php if ($coupon->coupon_start_date!='0000-00-00') print formatdate($coupon->coupon_start_date);?>
   </td>
   <td>
    <?php if ($coupon->coupon_expire_date!='0000-00-00')  print formatdate($coupon->coupon_expire_date);?>
   </td>
   <td align="center">
    <?php if ($coupon->finished_after_used) print _JSHOP_YES; else print _JSHOP_NO?>
   </td>
   <td align="center">
    <?php if ($coupon->for_user_id) print $coupon->f_name." ".$coupon->l_name; else print _JSHOP_ALL;?>
   </td>
   <td align="center">
    <?php if ($coupon->used) print _JSHOP_YES; else print _JSHOP_NO?>
   </td>
   <?php echo $coupon->tmp_extra_column_cells?>
   <td align="center">
     <?php
       echo $published = ($coupon->coupon_publish) ? ('<a href = "javascript:void(0)" onclick = "return listItemTask(\'cb' . $i . '\', \'unpublish\')"><img src="components/com_jshopping/images/tick.png" title = "'._JSHOP_PUBLISH.'" ></a>') : ('<a href = "javascript:void(0)" onclick = "return listItemTask(\'cb' . $i . '\', \'publish\')"><img title = "'._JSHOP_UNPUBLISH.'" src="components/com_jshopping/images/publish_x.png"></a>');
     ?>
   </td>
   <td align="center">
        <a href='index.php?option=com_jshopping&controller=coupons&task=edit&coupon_id=<?php print $coupon->coupon_id?>'><img src='components/com_jshopping/images/icon-16-edit.png'></a>
   </td>
   <td align="center">
     <?php echo $coupon->coupon_id ?>
   </td>
  </tr>
<?php
$i++;
}
?>
<tfoot>
<tr>
    <td colspan="<?php echo 12+(int)$this->deltaColspan?>"><?php echo $pageNav->getListFooter();?></td>
</tr>
</tfoot>
</table>

<input type="hidden" name="filter_order" value="<?php echo $this->filter_order?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter_order_Dir?>" />
<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "hidemainmenu" value = "0" />
<input type = "hidden" name = "boxchecked" value = "0" />
<?php print $this->tmp_html_end?>
</form>