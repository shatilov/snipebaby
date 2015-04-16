<?php
	defined('_JEXEC') or die();
	$rows = $this->rows;
	$i = 0;
    displaySubmenuConfigs('general');
?>
<form action = "index.php?option=com_jshopping&controller=configdisplayprice" method = "post" name = "adminForm">
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
    <th>
        <?php echo _JSHOP_COUNTRY; ?>
    </th>
    <th width = "100">
        <?php echo _JSHOP_DISPLAY_PRICE; ?>
    </th>
    <th width = "100">
        <?php echo _JSHOP_DISPLAY_PRICE_FOR_FIRMA; ?>
    </th>
    <th width = "50">
        <?php echo _JSHOP_EDIT; ?>
    </th>
    <th width = "40">
        <?php echo _JSHOP_ID; ?>
    </th>
  </tr>
</thead>  
<?php
 foreach($rows as $row){
  ?>
  <tr class = "row<?php echo $i % 2;?>">
   <td>
     <?php echo $i+1;?>
   </td>
   <td>
     <input type = "checkbox" onclick = "isChecked(this.checked)" name = "cid[]" id = "cb<?php echo $i++;?>" value = "<?php echo $row->id?>" />
   </td>
   <td>
    <?php echo $row->countries;?>
   </td>
   <td>
    <?php echo $this->typedisplay[$row->display_price];?>
   </td>
   <td>
    <?php echo $this->typedisplay[$row->display_price_firma];?>
   </td>
   <td align="center">
        <?php print "<a href='index.php?option=com_jshopping&controller=configdisplayprice&task=edit&id=".$row->id."'><img src='components/com_jshopping/images/icon-16-edit.png'></a>";?>
   </td>
   <td align="center">
        <?php print $row->id;?>
   </td>
  </tr>
  <?php
}
?>
</table>

<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "hidemainmenu" value = "0" />
<input type = "hidden" name = "boxchecked" value = "0" />
<?php print $this->tmp_html_end?>
</form>