<?php
	defined('_JEXEC') or die();
	echo $pane->startPanel(_JSHOP_FREE_ATTRIBUTES, 'product_freeattribute');
?>   
   <div class="col100">
   <table class="admintable" width="90%">
   <?php foreach($this->listfreeattributes as $freeattrib){?>
     <tr>
       <td class="key">
         <?php echo $freeattrib->name;?>
       </td>
       <td>
         <input type = "checkbox" name = "freeattribut[<?php print $freeattrib->id?>]" value = "1" <?php if ($freeattrib->pactive) echo 'checked = "checked"'?> />
       </td>
     </tr>
   <?php }?>
   <?php $pkey = 'plugin_template_freeattribute'; if ($this->$pkey){ print $this->$pkey;}?>
   </table>
   </div>
   <div class="clr"></div>
<?php
   echo $pane->endPanel();
?>