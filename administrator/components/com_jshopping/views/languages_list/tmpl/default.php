<?php
	defined('_JEXEC') or die();
	displaySubmenuOptions();
	$languages = $this->rows;
	$i = 0;
?>
<form action = "index.php?option=com_jshopping&controller=languages" method = "post" name = "adminForm">
<?php print $this->tmp_html_start?>
<table class = "adminlist">
<thead>
  <tr>
    <th class = "title" width  = "10">
      #
    </th>
    <th width = "20">
      <input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $languages );?>);" />
    </th>
    <th align = "left">
      <?php echo _JSHOP_LANGUAGE_NAME;?>
    </th>
    <th width = "120">
      <?php echo _JSHOP_DEFAULT_FRONT_LANG;?>
    </th>
    <th width = "120">
      <?php echo _JSHOP_DEFAULT_LANG_FOR_COPY;?>
    </th>
    <th width = "50">
      <?php echo _JSHOP_PUBLISH;?>
    </th>
    <th width = "40">
        <?php echo _JSHOP_ID;?>
    </th>
  </tr>
</thead>  
<?php
 $count = count($languages);
 if ($count)
 foreach($languages as $language){
  ?>
  <tr class = "row<?php echo $i % 2;?>">
   <td align="center">
     <?php echo $i+1;?>
   </td>
   <td align="center">
     <input type = "checkbox" onclick = "isChecked(this.checked)" name = "cid[]" id = "cb<?php echo $i;?>" value = "<?php echo $language->id?>" />
   </td>
   <td>
     <?php echo $language->name; ?>
   </td>
   <td align="center">
     <?php if ($this->default_front == $language->language) {?><img src="components/com_jshopping/images/icon-16-default.png"><?php }?>
   </td>
   <td align="center">
     <?php if ($this->defaultLanguage == $language->language) {?><img src="components/com_jshopping/images/icon-16-default.png"><?php }?>
   </td>
   <td align="center">
     <?php
       echo $published = ($language->publish) ? ('<a href = "javascript:void(0)" onclick = "return listItemTask(\'cb' . $i . '\', \'unpublish\')"><img src="components/com_jshopping/images/tick.png" title = "'._JSHOP_PUBLISH.'" ></a>') : ('<a href = "javascript:void(0)" onclick = "return listItemTask(\'cb' . $i . '\', \'publish\')"><img title = "'._JSHOP_UNPUBLISH.'" src="components/com_jshopping/images/publish_x.png"></a>');
     ?>
   </td>       
   <td align="center">
    <?php print $language->id;?>
   </td>
  </tr>
<?php
$i++;
}
?>
</table>
<br/>
<br/>
<div class="helpbox">
    <div class="head"><?php echo _JSHOP_DEFAULT_FRONT_LANG;?></div>
    <div class="text"><?php print _JSHOP_DEFAULT_FRONT_LANG_INFO;?></div>
    <br/>
    <div class="head"><?php echo _JSHOP_DEFAULT_LANG_FOR_COPY;?></div>
    <div class="text"><?php print _JSHOP_DEFAULT_LANG_FOR_COPY_INFO;?></div>
</div>

<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "hidemainmenu" value = "0" />
<input type = "hidden" name = "boxchecked" value = "0" />
<?php print $this->tmp_html_end?>
</form>