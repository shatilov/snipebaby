<?php
	defined('_JEXEC') or die();
	displaySubmenuOptions();
	$countries = $this->rows;
	$pageNav = $this->pageNav;
	$i = 0;
	$saveOrder = $this->filter_order_Dir=="asc" && $this->filter_order=="ordering";
?>
<form action = "index.php?option=com_jshopping&controller=countries" method = "post" name = "adminForm">
<?php print $this->tmp_html_start?>
<table class = "adminlist">
	<tr>
		<td align="right">
            <?php print $this->tmp_html_filter?>
			<?php print _JSHOP_SHOW; ?>: <?php print $this->filter;?>
		</td>
	</tr>
</table>

<table class = "adminlist">
<thead>
  <tr>
    <th class = "title" width  = "10">
        #
    </th>
    <th width = "20">
        <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $countries );?>);" />
    </th>
    <th align = "left">
        <?php echo JHTML::_('grid.sort', _JSHOP_COUNTRY, 'name', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
	<th width = "90">
        <?php echo JHTML::_('grid.sort', _JSHOP_CODE, 'country_code', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width = "90">
        <?php echo JHTML::_('grid.sort', _JSHOP_CODE . '2', 'country_code_2', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th colspan = "3" width = "40">
        <?php echo JHTML::_('grid.sort', _JSHOP_ORDERING, 'ordering', $this->filter_order_Dir, $this->filter_order); ?>
        <?php if ($saveOrder){?>
            <a class="saveorder" href="javascript:saveorder(<?php echo count( $countries ) - 1;?>,'saveorder')" title="Save Order"></a>
        <?php }?>
    </th>
    <th width = "50">
        <?php echo _JSHOP_PUBLISH; ?>
    </th>
    <th width="50">
    	<?php print _JSHOP_EDIT; ?>
    </th>
	<th width = "50">
        <?php echo JHTML::_('grid.sort', _JSHOP_ID, 'country_id', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
  </tr>
</thead>
<?php
 $count = count($countries);
 foreach($countries as $country){
  ?>
  <tr class = "row<?php echo $i % 2;?>">
   <td>
        <?php echo $pageNav->getRowOffset($i);?>
   </td>
   <td>
        <input type = "checkbox" onclick = "isChecked(this.checked)" name = "cid[]" id = "cb<?php echo $i;?>" value = "<?php echo $country->country_id?>" />
   </td>
   <td>
        <a href = "index.php?option=com_jshopping&controller=countries&task=edit&country_id=<?php echo $country->country_id; ?>"><?php echo $country->name;?></a>
   </td>
   <td align="center">
        <?php echo $country->country_code;?>
   </td>
   <td align="center">
        <?php echo $country->country_code_2;?>
   </td>
   <td align = "right" width = "20">
        <?php
            if ($i != 0 && $saveOrder) echo '<a href = "index.php?option=com_jshopping&controller=countries&task=order&id=' . $country->country_id . '&order=up&number=' . $country->ordering . '"><img alt="' . _JSHOP_UP . '" src="components/com_jshopping/images/uparrow.png"/></a>';
        ?>
   </td>
   <td align = "left" width = "20">
        <?php
            if ($i != $count - 1 && $saveOrder) echo '<a href = "index.php?option=com_jshopping&controller=countries&task=order&id=' . $country->country_id . '&order=down&number=' . $country->ordering . '"><img alt="' . _JSHOP_DOWN . '" src="components/com_jshopping/images/downarrow.png"/></a>';
        ?>
   </td>
    <td align = "center" width = "10">
        <input type="text" name="order[]" id = "ord<?php echo $country->country_id;?>"  size="5" value="<?php echo $country->ordering; ?>" <?php if (!$saveOrder) echo 'disabled'?> class="text_area" style="text-align: center" />    
    </td>
    <td align="center">
        <?php
            echo $published = ($country->country_publish) ? ('<a href = "javascript:void(0)" onclick = "return listItemTask(\'cb' . $i . '\', \'unpublish\')"><img src="components/com_jshopping/images/tick.png" title = "'._JSHOP_PUBLISH.'" ></a>') : ('<a href = "javascript:void(0)" onclick = "return listItemTask(\'cb' . $i . '\', \'publish\')"><img title = "'._JSHOP_UNPUBLISH.'" src="components/com_jshopping/images/publish_x.png"></a>');
        ?>
    </td>
	<td align="center">
        <a href='index.php?option=com_jshopping&controller=countries&task=edit&country_id=<?php print $country->country_id;?>'><img src='components/com_jshopping/images/icon-16-edit.png'></a>
	</td>
	<td align="center">
        <?php echo $country->country_id;?>
   </td>
  </tr>
<?php
$i++;  
}
?>
<tfoot>
<tr>
    <td colspan="11"><?php echo $pageNav->getListFooter();?></td>
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