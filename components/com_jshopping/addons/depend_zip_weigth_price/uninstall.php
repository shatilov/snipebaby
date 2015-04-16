<?php
defined('_JEXEC') or die('Restricted access');
$db = JFactory::getDbo();

$name = "Addon shipping Zip Weight Price Depend";
$element = "depend_zip_weigth_price";

// delete shipping
$db->setQuery("DELETE FROM `#__jshopping_shipping_ext_calc` WHERE `alias` = 'sm_".$element."'");
$db->query();

// delete folder
jimport('joomla.filesystem.folder');
foreach(array(
	'/components/com_jshopping/lang/sm_'.$element.'/',
	'/components/com_jshopping/shippings/sm_'.$element.'/',
	'components/com_jshopping/addons/'.$element.'/'
) as $folder){JFolder::delete(JPATH_ROOT.'/'.$folder);}

?>
