<?php
	defined('_JEXEC') or die();
	$params = $this->params;
?>
<div class="jshop_edit">
<form action="index.php?option=com_jshopping&controller=addons" method="post" enctype="multipart/form-data" name="adminForm" id='adminForm'>
<input type="hidden" name="id" value="<?php print $this->row->id?>">
<?php if ($this->file_exist){
    include($this->file_patch);
}?>
<input type="hidden" name="task" value="" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="boxchecked" value="0" />
</form>
</div>