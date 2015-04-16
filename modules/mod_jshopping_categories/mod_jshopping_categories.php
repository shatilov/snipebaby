<?php
/**
* @version      3.0.2 17.12.2012
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

    defined('_JEXEC') or die('Restricted access');
    error_reporting(error_reporting() & ~E_NOTICE);    
    
    if (!file_exists(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'jshopping.php')){
        JError::raiseError(500,"Please install component \"joomshopping\"");
    } 

    require_once (dirname(__FILE__).DS.'helper.php');

    require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."factory.php"); 
    require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."jtableauto.php");
    require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'tables'.DS.'config.php'); 
    require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."functions.php");
    require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."multilangfield.php");
    
    JSFactory::loadCssFiles();
  
    $lang = JFactory::getLanguage();
    if(file_exists(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS . 'lang'. DS . $lang->getTag() . '.php')) 
        require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS . 'lang'. DS . $lang->getTag() . '.php'); 
    else 
        require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS . 'lang'.DS.'en-GB.php'); 
    
    JTable::addIncludePath(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'tables'); 
    
    $field_sort = $params->get('sort', 'id');
    $ordering = $params->get('ordering', 'asc');
    $show_image = $params->get('show_image',0);
        
    $category_id = JRequest::getInt('category_id');
    $category = JTable::getInstance('category', 'jshop');        
    $category->load($category_id);
    $categories_id = $category->getTreeParentCategories();
    $categories_arr = jShopCategoriesHelper::getCatsArray($field_sort, $ordering, $category_id, $categories_id);
    
    $jshopConfig = JSFactory::getConfig();

    require(JModuleHelper::getLayoutPath('mod_jshopping_categories'));
?>