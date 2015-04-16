<?php
/**
* @version      2.0.1 31.01.2013
* @author       MAXXmarketing GmbH
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined('_VALID_MOS') or defined('_JEXEC') or die('Direct Access to this location is not allowed.');

/** Adds support for JoomShopping categories/products/manufacturers to Xmap */
class xmap_com_jshopping{
	/** Get the content tree for this kind of content */
	function getTree(&$xmap, &$parent, &$params) {
		$menu = & JSite::getMenu();
		$jsparams = $menu->getParams($parent->id);
		$link_query = parse_url($parent->link);
		parse_str(html_entity_decode($link_query['query']), $link_vars);
		$controller = xmap_com_jshopping::getParam($link_vars, 'controller', 0);
		$catid = intval(xmap_com_jshopping::getParam($link_vars, 'category_id', 0));
		$manid = intval(xmap_com_jshopping::getParam($link_vars, 'manufacturer_id', 0));
		$prodid = intval(xmap_com_jshopping::getParam($link_vars, 'product_id', 0));
		$params['Itemid'] = intval(xmap_com_jshopping::getParam($link_vars, 'Itemid', $parent->id));
		
		if (!$controller) $controller = $jsparams->get('controller', '');
		if (!$catid) $catid = intval($jsparams->get('category_id', 0));
		if (!$manid) $manid = intval($jsparams->get('manufacturer_id', 0));
		if (!$prodid) $prodid = intval($jsparams->get('product_id', 0));
		if ($prodid) return $tree;

		$params['show_category'] = xmap_com_jshopping::getParam($params, 'show_category', 2);
		$params['include_products_cat'] = xmap_com_jshopping::getParam($params, 'include_products_cat', 1);
		$params['show_manufacturer'] = xmap_com_jshopping::getParam($params, 'show_manufacturer', 2);
		$params['include_products_man'] = xmap_com_jshopping::getParam($params, 'include_products_man', 1);
		$priority = xmap_com_jshopping::getParam($params, 'cat_priority', $parent->priority);
		$changefreq = xmap_com_jshopping::getParam($params, 'cat_changefreq', $parent->changefreq);
		if ($priority == '-1') $priority = $parent->priority;
		if ($changefreq == '-1') $changefreq = $parent->changefreq;
		$params['cat_priority'] = $priority;
		$params['cat_changefreq'] = $changefreq;
		$priority = xmap_com_jshopping::getParam($params, 'prod_priority', $parent->priority);
		$changefreq = xmap_com_jshopping::getParam($params, 'prod_changefreq', $parent->changefreq);
		if ($priority == '-1') $priority = $parent->priority;
		if ($changefreq == '-1') $changefreq = $parent->changefreq;
		$params['prod_priority'] = $priority;
		$params['prod_changefreq'] = $changefreq;
		xmap_com_jshopping::getCategoryTree($xmap, $parent, $params, $catid, $manid, $controller);
		return true;
	}

	/** JoomShopping support */
	function &getCategoryTree(&$xmap, &$parent, &$params, $catid=0, $manid=0, $controller) {
		$database = &JFactory::getDBO();
		$lang_ = &JFactory::getLanguage();
		$lang = $lang_->getTag();
		static $urlBase;
		if (!isset($urlBase)) $urlBase = JURI::base();

		if (((($controller == "category") && ($params['show_category'] == 1)) || ($params['show_category'] == 2)) && ($manid == 0)) {
			$query = "SELECT a.category_id, a.`name_".$lang."` as category_name, UNIX_TIMESTAMP(a.category_add_date) as mdate "
				. "\n FROM #__jshopping_categories AS a "
				. "\n WHERE a.category_publish = '1' "
				. "\n AND a.category_parent_id = ".$catid." "
				. "\n ORDER BY a.category_parent_id ASC, a.category_id ASC";
			$database->setQuery($query);
			$rows = $database->loadObjectList();
			$xmap->changeLevel(1);
			foreach ($rows as $row) {
				$node = new stdclass;
				$node->id = $params['Itemid'];
				$node->uid = $parent->uid . 'c' . $row->category_id;
				$node->browserNav = $parent->browserNav;
				$node->name = stripslashes($row->category_name);
				$node->modified = intval($row->mdate);
				$node->priority = $params['cat_priority'];
				$node->changefreq = $params['cat_changefreq'];
				$node->expandible = true;
				$node->link = "index.php?option=com_jshopping&amp;controller=category&amp;task=view&amp;category_id=" . $row->category_id . "&amp;Itemid=" . $params['Itemid'];
				if ($xmap->printNode($node) !== FALSE) xmap_com_jshopping::getCategoryTree($xmap, $parent, $params, $row->category_id, $manid, $controller);
			}
			$xmap->changeLevel(-1);

			if ($params['include_products_cat'] == 1) {
				$query = "SELECT a.product_id, a.`name_".$lang."` AS product_name, UNIX_TIMESTAMP(a.product_date_added) AS mdate, b.category_id "
					. "\n FROM #__jshopping_products AS a, #__jshopping_products_to_categories AS b "
					. "\n WHERE a.product_publish='1'"
					. "\n AND b.category_id= ".$catid." "
					. "\n AND a.product_id=b.product_id "
					. "\n ORDER BY a.product_id";
				$database->setQuery($query);
				$rows = $database->loadObjectList();
				$xmap->changeLevel(1);
				foreach ($rows as $row) {
					$node = new stdclass;
					$node->id = $params['Itemid'];
					$node->uid = $parent->uid . 'c' . $row->category_id . 'p' . $row->product_id;
					$node->browserNav = $parent->browserNav;
					$node->priority = $params['prod_priority'];
					$node->changefreq = $params['prod_changefreq'];
					$node->name = $row->product_name;
					$node->modified = intval($row->mdate);
					$node->expandible = false;
					$node->link = "index.php?option=com_jshopping&amp;controller=product&amp;task=view&amp;category_id=". $row->category_id ."&amp;product_id=". $row->product_id . "&amp;Itemid=" . $params['Itemid'];
					$xmap->printNode($node);
				}
				$xmap->changeLevel(-1);
			}
		}

		if (((($controller == "manufacturer") && ($params['show_manufacturer'] > 0)) || ($params['show_manufacturer'] == 2)) && ($catid == 0)) {
			if ($manid == 0) {
				$query = "SELECT a.manufacturer_id, a.`name_".$lang."` as manufacturer_name "
					. "\n FROM #__jshopping_manufacturers AS a "
					. "\n WHERE a.manufacturer_publish = '1' "
					. "\n ORDER BY a.manufacturer_id ASC";
				$database->setQuery($query);
				$rows = $database->loadObjectList();
				$xmap->changeLevel(1);
				foreach ($rows as $row) {
					$node = new stdclass;
					$node->id = $params['Itemid'];
					$node->uid = $parent->uid . 'm' . $row->manufacturer_id;
					$node->browserNav = $parent->browserNav;
					$node->name = stripslashes($row->manufacturer_name);
					$node->modified = intval(time());
					$node->priority = $params['cat_priority'];
					$node->changefreq = $params['cat_changefreq'];
					$node->expandible = true;
					$node->link = "index.php?option=com_jshopping&amp;controller=manufacturer&amp;task=view&amp;manufacturer_id=" . $row->manufacturer_id . "&amp;Itemid=" . $params['Itemid'];
					$xmap->printNode($node);
					xmap_com_jshopping::getCategoryTree($xmap, $parent, $params, $catid, $row->manufacturer_id, $controller);
				}
				$xmap->changeLevel(-1);
			}

			if ($params['include_products_man'] == 1) {
				$query = "SELECT a.product_id, a.`name_".$lang."` AS product_name, UNIX_TIMESTAMP(a.product_date_added) AS mdate, a.product_manufacturer_id, b.category_id "
					. "\n FROM #__jshopping_products AS a, #__jshopping_products_to_categories AS b "
					. "\n WHERE a.product_publish='1'"
					. "\n AND a.product_manufacturer_id= ".$manid." "
					. "\n AND a.product_id = b.product_id "
					. "\n ORDER BY a.product_id";
				$database->setQuery($query);
				$rows = $database->loadObjectList();
				$xmap->changeLevel(1);
				foreach ($rows as $row) {
					$node = new stdclass;
					$node->id = $params['Itemid'];
					$node->uid = $parent->uid . 'm' . $row->product_manufacturer_id . 'p' . $row->product_id;
					$node->browserNav = $parent->browserNav;
					$node->priority = $params['prod_priority'];
					$node->changefreq = $params['prod_changefreq'];
					$node->name = $row->product_name;
					$node->modified = intval($row->mdate);
					$node->expandible = false;
					$node->link = "index.php?option=com_jshopping&amp;controller=product&amp;task=view&amp;category_id=". $row->category_id ."&amp;product_id=". $row->product_id . "&amp;Itemid=" . $params['Itemid'];
					$xmap->printNode($node);
				}
				$xmap->changeLevel(-1);
			}
		}
	}

	function getParam($arr, $name, $def) {
		return JArrayHelper::getValue($arr, $name, $def, '');
	}
}