<?php
/**
* @version      2.5.0 15.11.2010
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');
error_reporting(E_ALL & ~E_NOTICE);

if (!file_exists(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'jshopping.php')){
    JError::raiseError(500,"Please install component \"joomshopping\"");
}

require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."factory.php"); 
require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."functions.php");

JSFactory::loadCssFiles();
JSFactory::loadJsFiles();
JSFactory::loadLanguageFile();
       
$adv_search = $params->get('advanced_search');
$add_desc_in_search = $params->get('description_search');
$category_id = intval($params->get('category_id'));
if ($adv_search) $adv_search_link = SEFLink('index.php?option=com_jshopping&controller=search',1);
$search = JRequest::getVar('search','');

require(JModuleHelper::getLayoutPath('mod_jshopping_search'));   
?>