<?php defined('_JEXEC') or die(); ?>
<form action = "index.php?option=com_jshopping&controller=importexport" method = "post" name = "adminForm" enctype = "multipart/form-data">
<input type = "hidden" name = "task" value = "" />
<input type = "hidden" name = "hidemainmenu" value = "0" />
<input type = "hidden" name = "boxchecked" value = "0" />
<input type = "hidden" name = "ie_id" value = "<?php print $ie_id;?>" />

<h3>Заполните поля формы и нажмите на кнопку "Импорт"</h3>
	<p>
		Снять с публикации отсутствующие в прайсе товары:
	<input type = "checkbox" name = "unpublic_products" checked /> 
	</p>
	<p>
		Файл выгрузки (*.csv):
		<input type="file" name="file">
	</p>
</form>
