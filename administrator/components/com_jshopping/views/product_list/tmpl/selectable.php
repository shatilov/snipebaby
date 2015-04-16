<?php
	defined('_JEXEC') or die();
	$rows = $this->rows;
	$lists = $this->lists;
	$pageNav = $this->pagination;
	$text_search = $this->text_search;
	$category_id = $this->category_id;
	$manufacturer_id = $this->manufacturer_id;
	$count = count($rows);
	$eName = $this->eName;
	$jsfname = $this->jsfname;
	$i = 0;
?>
<form action="index.php?option=com_jshopping&controller=product_list_selectable&tmpl=component" method="post" name="adminForm">
<?php print $this->tmp_html_start?>
<table width="100%" style="padding-bottom:5px;">
  <tr>
	<td width="95%" align="right">
        <?php print $this->tmp_html_filter?>
		<?php echo _JSHOP_CATEGORY.": ".$lists['treecategories'];?>&nbsp;&nbsp;&nbsp;
		<?php echo _JSHOP_NAME_MANUFACTURER.": ".$lists['manufacturers'];?>&nbsp;&nbsp;&nbsp;
		<?php 
		if ($this->config->admin_show_product_labels) {
			echo _JSHOP_LABEL.": ".$lists['labels']."&nbsp;&nbsp;&nbsp;";
		}
		?>
		<?php echo _JSHOP_SHOW.": ".$lists['publish'];?>&nbsp;&nbsp;&nbsp;
	</td>
	<td>
		<input type="text" name = "text_search" value = "<?php echo htmlspecialchars($text_search);?>" />
	</td>
	<td>
		<input type="submit" class = "button" value = "<?php echo _JSHOP_SEARCH;?>" />
	</td>
  </tr>
</table>

<table class = "adminlist" >
<thead> 
  <tr>
	<th class = "title" width  = "10">
	  #
	</th>
	<th width="93">
		<?php print _JSHOP_IMAGE; ?>
	</th>
	<th>
	  <?php echo _JSHOP_TITLE; ?>
	</th>
	<?php print $this->tmp_html_col_after_title?>
	<?php if (!$category_id){?>
	<th width="80">
	  <?php echo _JSHOP_CATEGORY;?>
	</th>
	<?php }?>
	<?php if (!$manufacturer_id){?>
	<th width="80">
	  <?php echo _JSHOP_MANUFACTURER;?>
	</th>
	<?php }?>
	<th width="60">
		<?php echo _JSHOP_PRICE;?>
	</th>
	<th width="60">
		<?php echo _JSHOP_DATE;?>
	</th>
	<th width = "40">
	  <?php echo _JSHOP_PUBLISH;?>
	</th>
	<th width = "30">
	  <?php echo _JSHOP_ID;?>
	</th>
  </tr>
</thead> 
<?php foreach ($rows as $row){?>
  <tr class = "row<?php echo $i % 2;?>">
   <td>
	 <?php echo $pageNav->getRowOffset($i);?>
   </td>
   <td>
	<?php if ($row->image){?>
		<a href="#" onclick="window.parent.<?php print $jsfname?>(<?php echo $row->product_id; ?>, '<?php echo $eName; ?>')">
			<img src="<?php print $this->config->image_product_live_path."/".$row->image?>" width="90" border="0" />
		</a>
	<?php }?>
   </td>
   <td>
	 <b><a href="#" onclick="window.parent.<?php print $jsfname?>(<?php echo $row->product_id; ?>, '<?php echo $eName; ?>')"><?php echo $row->name;?></a></b>
	 <br/><?php echo $row->short_description;?>
   </td>
   <?php print $row->tmp_html_col_after_title?>
   <?php if (!$category_id){?>
   <td>
	  <?php echo $row->namescats;?>
   </td>
   <?php }?>
   <?php if (!$manufacturer_id){?>
   <td>
	  <?php echo $row->man_name;?>
   </td>
   <?php }?>
   <td>		
    <?php echo formatprice($row->product_price, sprintCurrency($row->currency_id));?>
   </td>
   <td>
	<?php echo formatdate($row->product_date_added, 1);?>
   </td>
   <td align="center">
	 <?php echo $published = ($row->product_publish) ? ('<img title = "'._JSHOP_PUBLISH.'" border="0" alt="" src="components/com_jshopping/images/tick.png">') : ('<img title = "'._JSHOP_UNPUBLISH.'" border="0" alt="" src="components/com_jshopping/images/publish_x.png">');?>
   </td>
   <td align="center">
	 <?php echo $row->product_id; ?>
   </td>
  </tr>
 <?php
 $i++;
 }
 ?>
 <tfoot>
 <tr>
	<?php print $this->tmp_html_col_before_td_foot?>
    <td colspan="17"><?php echo $pageNav->getListFooter();?></td>
	<?php print $this->tmp_html_col_after_td_foot?>	
 </tr>
 </tfoot>   
</table>
<input type="hidden" name="task" value="" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="e_name" value="<?php print $eName?>" />
<input type="hidden" name="jsfname" value="<?php print $jsfname?>" />
<?php print $this->tmp_html_end?>
</form>