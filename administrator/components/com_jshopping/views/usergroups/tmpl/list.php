<?php
	defined('_JEXEC') or die();
	displaySubmenuOptions();
	$usergroups = $this->rows;
?>
<form action = "index.php?option=com_jshopping&controller=usergroups" method = "post" name = "adminForm">
<?php print $this->tmp_html_start?>
<table class = "adminlist">
<thead>
  	<tr>
    	<th class = "title" width  = "10">
      		#
    	</th>
    	<th width = "20">
	  		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $usergroups );?>);" />
    	</th>
    	<th width = "150" align = "left">
      		<?php echo JHTML::_('grid.sort', _JSHOP_TITLE, 'usergroup_name', $this->filter_order_Dir, $this->filter_order); ?>
    	</th>
    	<th align = "left">
      		<?php echo JHTML::_('grid.sort', _JSHOP_DESCRIPTION, 'usergroup_description', $this->filter_order_Dir, $this->filter_order); ?>
    	</th>
        <th width="80">
            <?php echo JHTML::_('grid.sort', _JSHOP_USERGROUP_DISCOUNT, 'usergroup_discount', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
    	<th width = "100">
			<?php echo _JSHOP_USERGROUP_IS_DEFAULT; ?>
		</th>
	    <th width = "50">
	        <?php echo _JSHOP_EDIT; ?>
	    </th>
        <th width = "40">
            <?php echo JHTML::_('grid.sort', _JSHOP_ID, 'usergroup_id', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
  	</tr>
</thead>
<?php $i = 0; foreach($usergroups as $usergroup){?>
    <tr class = "row<?php echo ($i%2);?>">
		<td>
			<?php echo $i + 1;?>
		</td>
		<td align = "center">
			<input type="checkbox" onclick="isChecked(this.checked)" id="cb<?php echo $i++?>" name = "cid[]" value = "<?php echo $usergroup->usergroup_id?>" />
		</td>
		<td>
			<a href = "index.php?option=com_jshopping&controller=usergroups&task=edit&usergroup_id=<?php echo $usergroup->usergroup_id;?>"><?php echo $usergroup->usergroup_name; ?></a>
		</td>
		<td>
			<?php echo $usergroup->usergroup_description; ?>
		</td>
        <td>
            <?php print $usergroup->usergroup_discount?> %
        </td>
		<td align = "center"><?php $default_image = ($usergroup->usergroup_is_default) ? ('tick.png') : ('publish_x.png');?><img src = "components/com_jshopping/images/<?php echo $default_image;?>" /></td>
		<td align="center">
	        <a href='index.php?option=com_jshopping&controller=usergroups&task=edit&usergroup_id=<?php print $usergroup->usergroup_id?>'><img src='components/com_jshopping/images/icon-16-edit.png'></a>
	   </td>
       <td align="center">
            <?php print $usergroup->usergroup_id?>
       </td>
	</tr>	
<?php } ?>
</table>
    
<input type="hidden" name="filter_order" value="<?php echo $this->filter_order?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter_order_Dir?>" />
<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "hidemainmenu" value = "0" />
<input type = "hidden" name = "boxchecked" value = "0" />
<?php print $this->tmp_html_end?>
</form>