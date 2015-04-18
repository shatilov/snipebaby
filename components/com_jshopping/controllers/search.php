<?php
/**
* @version      3.20.2 17.02.2015
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JshoppingControllerSearch extends JController{
    
    function __construct($config = array()){
        parent::__construct($config);
        JPluginHelper::importPlugin('jshoppingproducts');
        JDispatcher::getInstance()->trigger('onConstructJshoppingControllerSearch', array(&$this));
    }
    
    function display($cachable = false, $urlparams = false){
    	$jshopConfig = JSFactory::getConfig();
    	JHTML::_('behavior.calendar');
        $mainframe = JFactory::getApplication();
        $params = $mainframe->getParams();
        $Itemid = JRequest::getInt('Itemid');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeLoadSearchForm', array());
        
        $seo = JSFactory::getTable("seo", "jshop");
        $seodata = $seo->loadData("search");
        if (getThisURLMainPageShop()){
            appendPathWay(_JSHOP_SEARCH);
            if ($seodata->title==""){
                $seodata->title = _JSHOP_SEARCH;
            }
            setMetaData($seodata->title, $seodata->keyword, $seodata->description);
        }else{
            setMetaData($seodata->title, $seodata->keyword, $seodata->description, $params);
        }
        $context = "jshoping.search.front";
        
        if ($jshopConfig->admin_show_product_extra_field){
            $urlsearchcaracters = SEFLink("index.php?option=com_jshopping&controller=search&task=get_html_characteristics&ajax=1",0,1);
            $change_cat_val = "onchange='updateSearchCharacteristic(\"".$urlsearchcaracters."\",this.value);'";
        }else{
            $change_cat_val = "";
        }
		$categories = buildTreeCategory(1);
        $first = JHTML::_('select.option', 0, _JSHOP_SEARCH_ALL_CATEGORIES, 'category_id', 'name' );
		array_unshift($categories, $first);
        $list_categories = JHTML::_('select.genericlist', $categories, 'category_id', 'class = "inputbox" size = "1" '.$change_cat_val, 'category_id', 'name' );
		
        $first = JHTML::_('select.option', 0, _JSHOP_SEARCH_ALL_MANUFACTURERS, 'manufacturer_id', 'name');
        $_manufacturers = JSFactory::getTable('manufacturer', 'jshop');
		$manufacturers = $_manufacturers->getList();
		array_unshift($manufacturers, $first);
        $list_manufacturers = JHTML::_('select.genericlist', $manufacturers, 'manufacturer_id', 'class = "inputbox" size = "1"','manufacturer_id','name' );
        
        if ($jshopConfig->admin_show_product_extra_field){
            $characteristic_fields = JSFactory::getAllProductExtraField();
            $characteristic_fieldvalues = JSFactory::getAllProductExtraFieldValueDetail();
            $characteristic_displayfields = JSFactory::getDisplayFilterExtraFieldForCategory($category_id);
        }
        
        $characteristics = "";
        if ($jshopConfig->admin_show_product_extra_field){ 
            $view_name = "search";
            $view_config = array("template_path"=>$jshopConfig->template_path.$jshopConfig->template."/".$view_name);
            $view = $this->getView($view_name, "html", '', $view_config);
            $view->setLayout("characteristics");
            $view->assign('characteristic_fields', $characteristic_fields);
            $view->assign('characteristic_fieldvalues', $characteristic_fieldvalues);
            $view->assign('characteristic_displayfields', $characteristic_displayfields);
            $characteristics = $view->loadTemplate();
        }

        $view_name = "search";
        $view_config = array("template_path"=>$jshopConfig->template_path.$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("form");
		$view->assign('list_categories', $list_categories);
        $view->assign('list_manufacturers', $list_manufacturers);
		$view->assign('characteristics', $characteristics);
        $view->assign('config', $jshopConfig);
        $view->assign('Itemid', $Itemid);
		$view->assign('action', SEFLink("index.php?option=com_jshopping&controller=search&task=result"));
        $dispatcher->trigger('onBeforeDisplaySearchFormView', array(&$view) );
		$view->display();
    }
    
    function result(){
        $mainframe = JFactory::getApplication();
        $jshopConfig = JSFactory::getConfig();
        $db = JFactory::getDBO();
        $lang = JSFactory::getLang();
        $user = JFactory::getUser();
        $session = JFactory::getSession();
        $session->set("jshop_end_page_buy_product", $_SERVER['REQUEST_URI']);
        $session->set("jshop_end_page_list_product", $_SERVER['REQUEST_URI']);
        $params = $mainframe->getParams();
        
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeLoadProductList', array());
        
        $product = JSFactory::getTable('product', 'jshop');
        $seo = JSFactory::getTable("seo", "jshop");
        $seodata = $seo->loadData("search-result");
        if (getThisURLMainPageShop()){
            appendPathWay(_JSHOP_SEARCH);
            if ($seodata->title==""){
                $seodata->title = _JSHOP_SEARCH;
            }
            setMetaData($seodata->title, $seodata->keyword, $seodata->description);
        }else{
            setMetaData($seodata->title, $seodata->keyword, $seodata->description, $params);
        }
        
        $post = JRequest::get('request');
        if ($post['setsearchdata']==1){
            $session->set("jshop_end_form_data", $post);
        }else{
            $data = $session->get("jshop_end_form_data");
            if (count($data)){
                $post = $data;
            }
        }

        $category_id = intval($post['category_id']);
        $manufacturer_id = intval($post['manufacturer_id']);
        $date_to = $post['date_to'];
        $date_from = $post['date_from'];
        $price_to = saveAsPrice($post['price_to']);
        $price_from = saveAsPrice($post['price_from']);
        $include_subcat = intval($post['include_subcat']);
        $search = trim($post['search']);
        $search_type = $post['search_type'];
        if (!$search_type) $search_type = "any";

        $context = "jshoping.searclist.front.product";
        $orderby = $mainframe->getUserStateFromRequest($context.'orderby', 'orderby', $jshopConfig->product_sorting_direction, 'int');
        $order = $mainframe->getUserStateFromRequest($context.'order', 'order', $jshopConfig->product_sorting, 'int');
        $limit = $mainframe->getUserStateFromRequest($context.'limit', 'limit', $jshopConfig->count_products_to_page, 'int');
        if (!$limit) $limit = $jshopConfig->count_products_to_page;
        $limitstart = JRequest::getInt('limitstart', 0);
		if ($order==4){
            $order = 1;
        }
		
        if ($jshopConfig->admin_show_product_extra_field){
            $extra_fields = $post['extra_fields'];
            $extra_fields = filterAllowValue($extra_fields, "array_int_k_v+");
        }
        
        $categorys = array();
        if ($category_id) {
            if ($include_subcat){
                $_category = JSFactory::getTable('category', 'jshop');
                $all_categories = $_category->getAllCategories();
                $cat_search = array();
                $cat_search[] = $category_id;
                searchChildCategories($category_id, $all_categories, $cat_search);
                foreach($cat_search as $key=>$value){
                    $categorys[] = $value;
                }
            }else{
                $categorys[] = $category_id;
            }
        }
        
        $orderbyq = getQuerySortDirection($order, $orderby);
        $image_sort_dir = getImgSortDirection($order, $orderby);
        
        $filters = array();
        $filters['categorys'] = $categorys;
        if ($manufacturer_id){
            $filters['manufacturers'][] = $manufacturer_id;
        }
        $filters['price_from'] = $price_from;
        $filters['price_to'] = $price_to;
        if ($jshopConfig->admin_show_product_extra_field){
            $filters['extra_fields'] = $extra_fields;
        }

        $adv_query = ""; $adv_from = ""; $adv_result = $product->getBuildQueryListProductDefaultResult();
        $product->getBuildQueryListProduct("search", "list", $filters, $adv_query, $adv_from, $adv_result);        

        if ($date_to && checkMyDate($date_to)) {
            $adv_query .= " AND prod.product_date_added <= '".$db->escape($date_to)."'";
        }
        if ($date_from && checkMyDate($date_from)) {
            $adv_query .= " AND prod.product_date_added >= '".$db->escape($date_from)."'";
        }
        
        $where_search = "";
        if ($search_type=="exact"){
            $word = addcslashes($db->escape($search), "_%");
            $tmp = array();
            foreach($jshopConfig->product_search_fields as $field){
                $tmp[] = "LOWER(".getDBFieldNameFromConfig($field).") LIKE '%".$word."%'";
            }
            $where_search = implode(' OR ', $tmp);
        }else{
            $words = explode(" ", $search);
            $search_word = array();
            foreach($words as $word){
                $word = addcslashes($db->escape($word), "_%");
                $tmp = array();
                foreach($jshopConfig->product_search_fields as $field){
                    $tmp[] = "LOWER(".getDBFieldNameFromConfig($field).") LIKE '%".$word."%'";
                }
                $where_search_block = implode(' OR ', $tmp);
                $search_word[] = "(".$where_search_block.")";
            }
            if ($search_type=="any"){
                $where_search = implode(" OR ", $search_word);
            }else{
                $where_search = implode(" AND ", $search_word);
            }
        }
        if ($where_search) $adv_query .= " AND ($where_search)";

        $orderbyf = $jshopConfig->sorting_products_field_s_select[$order];
        $order_query = $product->getBuildQueryOrderListProduct($orderbyf, $orderbyq, $adv_from);
        
        $dispatcher->trigger('onBeforeQueryGetProductList', array("search", &$adv_result, &$adv_from, &$adv_query, &$order_query, &$filters) );
                
        $query = "SELECT count(distinct prod.product_id) FROM `#__jshopping_products` AS prod
                  LEFT JOIN `#__jshopping_products_to_categories` AS pr_cat ON pr_cat.product_id = prod.product_id
                  LEFT JOIN `#__jshopping_categories` AS cat ON pr_cat.category_id = cat.category_id                  
                  $adv_from
                  WHERE prod.product_publish = '1' AND cat.category_publish='1'
                  $adv_query";
        $db->setQuery($query);
        $total = $db->loadResult();
        
        if (!$total){
            $view_name = "search";
            $view_config = array("template_path"=>$jshopConfig->template_path.$jshopConfig->template."/".$view_name);
            $view = $this->getView($view_name, getDocumentType(), '', $view_config);
            $view->setLayout("noresult");
            $view->assign('search', $search);
            $view->display();
            return 0;
        }
        
        $dispatcher->trigger('onBeforeFixLimitstartDisplayProductList', array(&$limitstart, &$total, 'search'));
        if ($limitstart>=$total) $limitstart = 0;

        $query = "SELECT $adv_result FROM `#__jshopping_products` AS prod
                  LEFT JOIN `#__jshopping_products_to_categories` AS pr_cat ON pr_cat.product_id = prod.product_id
                  LEFT JOIN `#__jshopping_categories` AS cat ON pr_cat.category_id = cat.category_id                  
                  $adv_from
                  WHERE prod.product_publish = '1' AND cat.category_publish='1'
                  $adv_query
                  GROUP BY prod.product_id ".$order_query;
        $db->setQuery($query, $limitstart, $limit);
        $rows = $db->loadObjectList();
        $rows = listProductUpdateData($rows);
        addLinkToProducts($rows, 0, 1);
        
        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);
        $pagenav = $pagination->getPagesLinks();
        
        foreach($jshopConfig->sorting_products_name_s_select as $key=>$value) {
            $sorts[] = JHTML::_('select.option', $key, $value, 'sort_id', 'sort_value' );
        }

        insertValueInArray($jshopConfig->count_products_to_page, $jshopConfig->count_product_select);
        foreach($jshopConfig->count_product_select as $key=>$value){
            $product_count[] = JHTML::_('select.option',$key, $value, 'count_id', 'count_value' );
        }
        $sorting_sel = JHTML::_('select.genericlist', $sorts, 'order', 'class = "inputbox" size = "1" onchange = "submitListProductFilters()"','sort_id', 'sort_value', $order );
        $product_count_sel = JHTML::_('select.genericlist', $product_count, 'limit', 'class = "inputbox" size = "1" onchange = "submitListProductFilters()"','count_id', 'count_value', $limit );
        
        $_review = JSFactory::getTable('review', 'jshop');
        $allow_review = $_review->getAllowReview();
        
        $action = xhtmlUrl($_SERVER['REQUEST_URI']);
        
        $dispatcher->trigger('onBeforeDisplayProductList', array(&$rows));

        $view_name = "search";
        $view_config = array("template_path"=>$jshopConfig->template_path.$jshopConfig->template."/".$view_name);
        $view = $this->getView($view_name, getDocumentType(), '', $view_config);
        $view->setLayout("products");
        $view->assign('search', $search);
        $view->assign('total', $total);
        $view->assign('config', $jshopConfig);
        $view->assign('template_block_list_product', "list_products/list_products.php");
        $view->assign('template_block_form_filter', "list_products/form_filters.php");
        $view->assign('template_block_pagination', "list_products/block_pagination.php");
        $view->assign('path_image_sorting_dir', $jshopConfig->live_path.'images/'.$image_sort_dir);
        $view->assign('filter_show', 0);
        $view->assign('filter_show_category', 0);
        $view->assign('filter_show_manufacturer', 0);
        $view->assign('pagination', $pagenav);
		$view->assign('pagination_obj', $pagination);
        $view->assign('display_pagination', $pagenav!="");
        $view->assign('product_count', $product_count_sel);
        $view->assign('sorting', $sorting_sel);
        $view->assign('action', $action);
        $view->assign('orderby', $orderby);
        $view->assign('count_product_to_row', $jshopConfig->count_products_to_row);
        $view->assign('rows', $rows);
        $view->assign('allow_review', $allow_review);
        $view->assign('shippinginfo', SEFLink($jshopConfig->shippinginfourl,1));
        $dispatcher->trigger('onBeforeDisplayProductListView', array(&$view));
        $view->display();
    }
    
    function get_html_characteristics(){
        $jshopConfig = JSFactory::getConfig();
        $category_id = JRequest::getInt("category_id");
        if ($jshopConfig->admin_show_product_extra_field){
            $dispatcher = JDispatcher::getInstance();
            $characteristic_fields = JSFactory::getAllProductExtraField();
            $characteristic_fieldvalues = JSFactory::getAllProductExtraFieldValueDetail();
            $characteristic_displayfields = JSFactory::getDisplayFilterExtraFieldForCategory($category_id);
            
            $view_name = "search";
            $view_config = array("template_path"=>$jshopConfig->template_path.$jshopConfig->template."/".$view_name);
            $view = $this->getView($view_name, getDocumentType(), '', $view_config);
            $view->setLayout("characteristics");
            $view->assign('characteristic_fields', $characteristic_fields);
            $view->assign('characteristic_fieldvalues', $characteristic_fieldvalues);
            $view->assign('characteristic_displayfields', $characteristic_displayfields);
            $dispatcher->trigger('onBeforeDisplaySearchHtmlCharacteristics', array(&$view));
            $view->display();
        }
    die();
    }

}
?>