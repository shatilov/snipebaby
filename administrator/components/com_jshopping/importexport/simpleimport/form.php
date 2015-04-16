<?php defined('_JEXEC') or die(); ?>
<form action = "index.php?option=com_jshopping&controller=importexport" method = "post" name = "adminForm" enctype = "multipart/form-data">
<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "hidemainmenu" value = "0" />
<input type = "hidden" name = "boxchecked" value = "0" />
<input type = "hidden" name = "ie_id" value = "<?php print $ie_id;?>" />

<?php print _JSHOP_FILE?> (*.csv):
<input type="file" name="file">


</form>