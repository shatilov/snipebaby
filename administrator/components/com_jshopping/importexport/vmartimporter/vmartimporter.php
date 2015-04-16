<?php
/**
 * @package			"VirtueMart Importer Addon for JoomShopping"
 * @version			1.5 [2011-09-06]
 * @compatibility	PHP 5.2/5.3, Joomla 1.5, JoomShopping 2.9.6, VirtueMart 1.1.9
 * @author			Vova Olar (vovaolar@gmail.com)
 * @copyright		Copyright (C) 2010-2011 Vova Olar - All rights reserved.
 * @license			GNU/GPL (http://www.gnu.org/copyleft/gpl.html) 
 */
 
defined('_JEXEC') or die('Direct access is not allowed.');

//define('IMAGEPATH','/home/users2/m/maesz/domains/snype.maesz.jino.ru/images/stories/virtuemart/');
define('IMAGEPATH','');

class IeVMartImporter extends IeController {
	var $DB;
	var $jsLang;
	var $jsConf;

	var $ieTbl;
	var $vmImgPath;


	# Settings

	# Delete JoomShopping data before import: 1 | 0
	var $deleteJSData;
	
	# Make subproducts(items) in JShop relative to parent: 1 | 0
	var $makeSubproductsRelative;
	# Add VMart subproduct(items) attributes to JShop subproduct title
	var $addAttrsToSubproductTitle;
	# Make all free attributes required
	# (in VMart free attributes are set for each product, so they are all required): 1 | 0
	var $makeFreeAttributesRequired;
	# Which style of attributes to use: jshop | vmart
	var $attrStyle;
	# Add product type title before characteristic label: 1 | 0
	var $characteristicPrefix;
	
	# Which category image to use: thumb | full
	# VMart have full and thumb image for category (but at frontend used only thumb), JShop only one
	var $catImage;
	# Which store logo to use: thumb | full
	# VMart have full and thumb logo for store, JShop only one
	var $storeLogo;
	# Which vendor logo to use: thumb | full
	# VMart have full and thumb logo for vendors, JShop only one
	var $vendorLogo;
	# Resize images or leave original: 1 | 0
	var $resizeImages;
	
	# Autofill META tags (using product title & description ): 1 | 0
	var $autofillMeta;
	# Generate aliases for category, manufacturer & product using product title: 1 | 0
	var $generateAliases;

	# Relations between VMart items ids and inserted to JShop: vmId => jsId
	# I need store them to survive relations from VMart DB to JShop
	var $vmIdXjsId;
	
	# I need complex query to get product price and currency: vmProdId => currCode
	# Last I need in several places, so I store it globally
	var $vmProductsCurrencies;


	# Constructor
	function __construct($ieId) {
		# Set infinite max_execution_time
		@set_time_limit(0);
		
		# Set error reporting
		error_reporting(E_ALL ^ E_NOTICE);
		
		# Set timezone
		if (!ini_get('date.timezone'))
			@date_default_timezone_set(date_default_timezone_get());
	

		$this->DB =& JFactory::getDBO();
		$this->jsLang =& JSFactory::getLang();
		$this->jsConf =& JSFactory::getConfig();

		
		# Thumnail processing class
		include_once ($this->jsConf->path.'lib'.DS.'image.lib.php');
		
		
		# This lib is included from different dirs, so include_once don't work
		# It can happens when automatic execution is on simultaneously for different imports and exports
		# which are using this lib.
		if (!class_exists('MMLib'))
			include (dirname(__FILE__).DS.'mm.lib.php');
	
		
		# IE tbl
		JTable::addIncludePath(JPATH_COMPONENT_SITE.DS.'tables');
		
		$this->ieTbl =& JTable::getInstance('ImportExport', 'jshop');
		$this->ieTbl->load($ieId);

		
		# Getting path to VMart images
		
		# Support for legacy mode
		$mosConfig_absolute_path = $GLOBALS['mosConfig_absolute_path'] = JPATH_SITE;
		
		# IMAGEPATH contains path to images
		@include_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart.cfg.php');

		$this->vmImgPath = '/home/users2/m/maesz/domains/snype.maesz.jino.ru/images/stories/virtuemart/';


		# Init settings
		$this->deleteJSData = 1;
		
		$this->makeSubproductsRelative = 1;
		$this->addAttrsToSubproductTitle = 1;
		$this->makeFreeAttributesRequired = 1;
		$this->attrStyle = 'vmart';
		$this->characteristicPrefix = 0;
		
		$this->catImage = 'thumb';
		$this->storeLogo = 'full';
		$this->vendorLogo = 'full';
		$this->resizeImages = 1;
		
		$this->autofillMeta = 1;
		$this->generateAliases = 1;
		
		
		# Load settings from DB
		$params = parseParamsToArray($this->ieTbl->params);

		MMLib::setIfValNoEmpty($this->deleteJSData, $params['deleteJSData']);
		
		MMLib::setIfValNoEmpty($this->makeSubproductsRelative, $params['makeSubproductsRelative']);
		MMLib::setIfValNoEmpty($this->addAttrsToSubproductTitle, $params['addAttrsToSubproductTitle']);
		MMLib::setIfValNoEmpty($this->makeFreeAttributesRequired, $params['makeFreeAttributesRequired']);
		MMLib::setIfValNoEmpty($this->attrStyle, $params['attrStyle']);
		MMLib::setIfValNoEmpty($this->characteristicPrefix, $params['characteristicPrefix']);
		
		MMLib::setIfValNoEmpty($this->catImage, $params['catImage']);
		MMLib::setIfValNoEmpty($this->storeLogo, $params['storeLogo']);
		MMLib::setIfValNoEmpty($this->vendorLogo, $params['vendorLogo']);
		MMLib::setIfValNoEmpty($this->resizeImages, $params['resizeImages']);
		
		MMLib::setIfValNoEmpty($this->autofillMeta, $params['autofillMeta']);
		MMLib::setIfValNoEmpty($this->generateAliases, $params['generateAliases']);
		
		
		# For what I need to store relations
		$this->vmIdXjsId = array('category',
								 'manufacturer',
								 'product',
								 'tax',
								 'usergroup',
								 'vendor');

		$this->vmProductsCurrencies = array();
   
		parent::__construct();
	}

	# Check for JShop
	function _checkForJS() {
		# Check for the existence of JShop component
		define ('JSHOP_PATH', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jshopping');
		
		if(!is_dir(JSHOP_PATH))
			return FALSE;
		
		# Check for the existence of JShop tables (enough 1 tbl)
		$this->DB->setQuery("SHOW TABLES LIKE '%jshopping_categories%'");
		$this->DB->query();

		if ($this->DB->getNumRows() == 0)
			return FALSE;
		
		return TRUE;
	}
	
	# Check for VMart
	function _checkForVM() {
		# Check for the existence of JShop component
		define ('VMART_PATH', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart');
		
		if(!is_dir(VMART_PATH))
			return FALSE;
		
		# Check for the existence of VMart tables (enough 1 tbl)
		$this->DB->setQuery("SHOW TABLES LIKE '%vm_category%'");
		$this->DB->query();

		if ($this->DB->getNumRows() == 0)
			return FALSE;
		
		return TRUE;
	}

	# Truncate tables
	function _deleteJSData() {
		# ========== Delete files ==========
		
		# Attributes images
		$query = "SELECT image
				  FROM `#__jshopping_attr_values`";
		$this->DB->setQuery($query);
		$this->DB->query();
		
		$res = $this->DB->loadResultArray();
		
		if (!empty($res[0]))
			foreach ($res as $currFile)
				if (!empty($currFile))
					unlink($this->jsConf->image_attributes_path.DS.$currFile);
		
		
		# Categories images
		$query = "SELECT category_image
				  FROM `#__jshopping_categories`";
		$this->DB->setQuery($query);
		$this->DB->query();
		
		$res = $this->DB->loadResultArray();
		
		if (!empty($res[0]))
			foreach ($res as $currFile)
				if (!empty($currFile))
					unlink($this->jsConf->image_category_path.DS.$currFile);
		
		
		# Manufacturers logos
		$query = "SELECT manufacturer_logo
				  FROM `#__jshopping_manufacturers`";
		$this->DB->setQuery($query);
		$this->DB->query();
		
		$res = $this->DB->loadResultArray();
		
		if (!empty($res[0]))
			foreach ($res as $currFile)
				if (!empty($currFile))
					unlink($this->jsConf->image_manufs_path.DS.$currFile);
					
		
		# Vendors logos
		# in DB they are urls and can be stored not in jsConf->image_vendors_path, so I juct clean this path
		MMLib::cleanDir($this->jsConf->image_vendors_path, array('noimage.gif'));

		
		# Products files (both sale- and demo)
		$query = "SELECT file, demo
				  FROM `#__jshopping_products_files`";
		$this->DB->setQuery($query);
		$this->DB->query();
		
		foreach ($this->DB->loadObjectList() as $currObj) {
			if (!empty($currObj->file))
				unlink($this->jsConf->files_product_path.DS.$currObj->file);
			
			if (!empty($currObj->demo))
				unlink($this->jsConf->demo_product_path.DS.$currObj->demo);
		}
		
		
		# Products images
		$query = "SELECT image_thumb AS img_thumb_name,
					  image_name AS img_medium_name,
					  image_full AS img_full_name
				  FROM `#__jshopping_products_images`";
		$this->DB->setQuery($query);
		$this->DB->query();
		
		foreach ($this->DB->loadObjectList() as $currObj)
			if (!empty($currObj->img_full_name)) {
				unlink($this->jsConf->image_product_path.DS.$currObj->img_thumb_name);
				unlink($this->jsConf->image_product_path.DS.$currObj->img_medium_name);
				unlink($this->jsConf->image_product_path.DS.$currObj->img_full_name);
			}
		
		
		# Products videos
		$query = "SELECT video_name
				  FROM `#__jshopping_products_videos`";
		$this->DB->setQuery($query);
		$this->DB->query();
		
		$res = $this->DB->loadResultArray();
		
		if (!empty($res[0]))
			foreach ($res as $currFile)
				if (!empty($currFile))
					unlink($this->jsConf->video_product_path.DS.$currFile);
		
		
		# ========== Clean DB ==========
		
		# JShop adds characteristics ids to products table, delete them
		$this->DB->setQuery("SELECT `id` FROM `#__jshopping_products_extra_fields`");
		$this->DB->query();
		
		$characteristicsIds = $this->DB->loadResultArray();
		
		foreach ($characteristicsIds as $characteristicId) {
			$this->DB->setQuery("ALTER TABLE `#__jshopping_products`
								DROP COLUMN `extra_field_$characteristicId`");
			$this->DB->query();
		}
		
		# JShop adds attributes ids fields to products_attr table, delete them
		# (only attributes that uses JShop style)
		$this->DB->setQuery("SELECT `attr_id` FROM `#__jshopping_attr` WHERE attr_type = 0");
		$this->DB->query();
		
		$attrIds = $this->DB->loadResultArray();

		foreach ($attrIds as $attrId) {
			$this->DB->setQuery("ALTER TABLE `#__jshopping_products_attr` DROP COLUMN `attr_$attrId`");
			$this->DB->query();
		}

		# Truncate tables in which I will import
		$usedTables = array('#__jshopping_attr',
							'#__jshopping_attr_values',
							'#__jshopping_categories',
							'#__jshopping_coupons',
							'#__jshopping_free_attr',
							'#__jshopping_manufacturers',
							'#__jshopping_products',
							'#__jshopping_products_attr',
							'#__jshopping_products_attr2',
							'#__jshopping_products_extra_fields',
							'#__jshopping_products_extra_field_values',
							'#__jshopping_products_files',
							'#__jshopping_products_free_attr',
							'#__jshopping_products_images',
							'#__jshopping_products_prices',
							'#__jshopping_products_relations',
							'#__jshopping_products_reviews',
							'#__jshopping_products_videos',
							'#__jshopping_products_to_categories',
							'#__jshopping_shipping_method',
							'#__jshopping_shipping_method_price',
							'#__jshopping_shipping_method_price_countries',
							'#__jshopping_shipping_method_price_weight',
							'#__jshopping_taxes',
							'#__jshopping_users',
							'#__jshopping_vendors');
		
		foreach ($usedTables as $tblName) {
			$this->DB->setQuery('TRUNCATE TABLE `'.$tblName.'`');
			$this->DB->query();
		}
		
		# User Groups tbl should contain default group, so I can't just truncate it
		$this->DB->setQuery("DELETE FROM `#__jshopping_usergroups` WHERE usergroup_id  <> 1");
		$this->DB->query();

		# Meaningless tables after import of new data
		$meaninglessTables = array('#__jshopping_cart_temp');

		foreach ($meaninglessTables as $tblName) {
			$this->DB->setQuery('TRUNCATE TABLE `'.$tblName.'`');
			$this->DB->query();
		}
	}
	
	# Get JShop country ID by VMart country code
	function _getJSCountryID($vmCountryCode) {
		# In VMart field contains code, in JShop - foreign key to countries table record
		$query = "SELECT country_id
				  FROM #__jshopping_countries
				  WHERE country_code = '$vmCountryCode' OR country_code_2 = '$vmCountryCode'";
	
		$this->DB->setQuery($query);
		$this->DB->query();
		
		return $this->DB->loadResult();
	}

	# Get state by country ID and state code
	function _getVMStateName($vmCountryCode, $vmStateCode) {
		$query = "SELECT state_name
				  FROM #__vm_state AS st
				  LEFT JOIN #__vm_country AS cn USING (country_id)
				  WHERE cn.country_3_code = '$vmCountryCode' AND st.state_2_code = '$vmStateCode'";
	
		$this->DB->setQuery($query);
		$this->DB->query();
		
		return $this->DB->loadResult();
	}
	
	# Convert price using JShop prices configuration
	function _convertPrice($vmPrice, $vmCurrency) {
		$query = "SELECT currency_value
				  FROM #__jshopping_currencies
				  WHERE currency_code_iso = '$vmCurrency'";
	
		$this->DB->setQuery($query);
		$this->DB->query();
		
		return $vmPrice * $this->DB->loadResult();
	}
	
	# Generate alias
	function _generateAlias($forWhat, $title) {
		# Reserved aliases
		static $resAliases;
		
		if (!is_array($resAliases)){
			jimport('joomla.filesystem.folder');
	
			$files = JFolder::files(JPATH_ROOT."/components/com_jshopping/controllers");
			$resAliases = array();
			
			foreach($files as $file)
				$resAliases[] = str_replace(".php", "", $file);
		}
		
		# Field name in DB
		$fieldName = $this->jsLang->get('alias');
		
		# Generate alias
		$alias = $title;
		
		$alias = str_replace(" ", "-", $alias);
		$alias = (string) preg_replace('/[\x00-\x1F\x7F<>"\'$#%&\?\/\.\)\(\{\}\+\=\[\]\\\,:;]/', '', $alias);
		$alias = JString::strtolower($alias);
		
		# Escaped alias
		$escAlias = $this->DB->getEscaped($alias);
		
		
		# Checking for existing alias
		switch ($forWhat) {
			case 'category':
				$query = "SELECT category_id FROM #__jshopping_categories WHERE `$fieldName` = '$escAlias' LIMIT 1";
				
				$this->DB->setQuery($query);
				$this->DB->query($query);
				
				$res = $this->DB->loadResult();
				
				if ($res || in_array($alias, $resAliases))
					return '';

				break;
			case 'manufacturer':
				$query = "SELECT manufacturer_id FROM #__jshopping_manufacturers WHERE `$fieldName` = '$escAlias' LIMIT 1";
				
				$this->DB->setQuery($query);
				$this->DB->query($query);
				
				$res = $this->DB->loadResult();
				
				if ($res || in_array($alias, $resAliases))
					return '';

				break;
			case 'product':
				$query = "SELECT product_id FROM #__jshopping_products WHERE `$fieldName` = '$escAlias' LIMIT 1";
				
				$this->DB->setQuery($query);
				$this->DB->query($query);
				
				if ($this->DB->loadResult())
					return '';
				
				break;
		}
		
		return $alias;
	}
	
	# Get VMart subproduct attributes string
	function _getSubproductAttrsStr($subProdId) {
		$query = "SELECT prod_attr.attribute_name, prod_attr.attribute_value
				  FROM #__vm_product_attribute AS prod_attr
				  LEFT JOIN #__vm_product AS prod
					ON prod.product_id = prod_attr.product_id
				  LEFT JOIN #__vm_product_attribute_sku AS prod_attr_sku
					ON prod_attr_sku.product_id = prod.product_parent_id
				  WHERE prod_attr.product_id = $subProdId AND
						prod_attr.attribute_name = prod_attr_sku.attribute_name
				  ORDER BY prod_attr_sku.attribute_list ASC";
		
		$this->DB->setQuery($query);
		$this->DB->query();
		
		$adjStr = '';
		
		$attrsList = $this->DB->loadObjectList();
		
		if (!empty($attrsList[0])) {
			$adjStr .= '(';
			
			for ($i = 0; $i < count($attrsList); $i++) {
				$adjStr .= $attrsList[$i]->attribute_name.': '.$attrsList[$i]->attribute_value;
				
				if ($i != (count($attrsList) - 1))
					$adjStr .= ', ';
			}
			
			$adjStr .= ')';
		}
		
		return $adjStr;
	}
	
	# Get last ordering from DB
	function _getLastOrdering($forWhat) {
		if ($this->deleteJSData)
			return 0;
		
		switch ($forWhat) {
			case 'attributes':
				$query = "SELECT MAX(attr_ordering) FROM #__jshopping_attr";
				break;
			case 'categories':
				$query = "SELECT MAX(ordering) FROM #__jshopping_categories";
				break;
			case 'characteristics':
				$query = "SELECT MAX(ordering) FROM #__jshopping_products_extra_fields";
				break;
			case 'free_attributes':
				$query = "SELECT MAX(ordering) FROM #__jshopping_free_attr";
				break;
			case 'manufacturers':
				$query = "SELECT MAX(ordering) FROM #__jshopping_manufacturers";
				break;
			case 'shipping_methods':
				$query = "SELECT MAX(shipping_ordering) FROM #__jshopping_shipping_method";
				break;
			default:
				return FALSE;
				
		}
		
		$this->DB->setQuery($query);
		$this->DB->query();
				
		return $this->DB->loadResult();
	}

	# Copy (and resize if set) image for category
	function _processCategoryImage($imgName) {
		# Get first available filename if file with given filename already exists
		$availFilename = MMLib::getAvailableFileName($this->jsConf->image_category_path.DS.$imgName);

		if ($this->resizeImages)
			# Copy resized
			ImageLib::resizeImageMagic($this->vmImgPath.'category'.DS.$imgName,
				$this->jsConf->image_category_width,
				$this->jsConf->image_category_height,
				$this->jsConf->image_cut,
				$this->jsConf->image_fill,
				$this->jsConf->image_category_path.DS.$availFilename,
				$this->jsConf->image_quality,
				$this->jsConf->image_fill_color);
		else 
			# Just copy
			copy($this->vmImgPath.'category'.DS.$imgName, $this->jsConf->image_category_path.DS.$availFilename);
		
		chmod($this->jsConf->image_category_path.DS.$availFilename, 0777);
		
		# Return available filename to set right DB field
		return $availFilename;
	}

	# Copy (and resize if set) full-size, medium- and thumb-images for product
	function _processProductImages($imgsInfo, $prodId, $resizeThumb = FALSE) {
		# Setting for both images the same name but with different prefixes
		# $resizeThumb is used when original image have no thumb (f.e. additional image for product) and
		# I take full image for thumb generation
		
		
		# Full
		
		# Get first available filename if file with given filename already exists
		$availFilenameFull = MMLib::getAvailableFileName($this->jsConf->image_product_path.DS.
														 'full_'.$imgsInfo->dstImgBasename);
													 
		copy($imgsInfo->srcFullImgPath.DS.$imgsInfo->srcFullImgBasename,
			 $this->jsConf->image_product_path.DS.$availFilenameFull);
		chmod($this->jsConf->image_product_path.DS.$availFilenameFull, 0777);


		# Medium
		
		# Get first available filename if file with given filename already exists
		$availFilenameMedium = MMLib::getAvailableFileName($this->jsConf->image_product_path.DS.
														   $imgsInfo->dstImgBasename);
													 
		if ($this->resizeImages)
			# Copy resized
			ImageLib::resizeImageMagic($imgsInfo->srcFullImgPath.DS.$imgsInfo->srcFullImgBasename,
				$this->jsConf->image_product_full_width,
				$this->jsConf->image_product_full_height,
				$this->jsConf->image_cut,
				$this->jsConf->image_fill,
				$this->jsConf->image_product_path.DS.$availFilenameMedium,
				$this->jsConf->image_quality,
				$this->jsConf->image_fill_color);
		else 
			# Just copy
			copy($imgsInfo->srcFullImgPath.DS.$imgsInfo->srcFullImgBasename,
				 $this->jsConf->image_product_path.DS.$availFilenameMedium);

		chmod($this->jsConf->image_product_path.DS.$availFilenameMedium, 0777);

		
		# Thumb
		
		# Get first available filename if file with given filename already exists
		$availFilenameThumb = MMLib::getAvailableFileName($this->jsConf->image_product_path.DS.
														  'thumb_'.$imgsInfo->dstImgBasename);
		
		if ($this->resizeImages || $resizeThumb)
			# Copy resized
			ImageLib::resizeImageMagic($imgsInfo->srcThumbImgPath.DS.$imgsInfo->srcThumbImgBasename,
				$this->jsConf->image_product_width,
				$this->jsConf->image_product_height,
				$this->jsConf->image_cut,
				$this->jsConf->image_fill,
				$this->jsConf->image_product_path.DS.$availFilenameThumb,
				$this->jsConf->image_quality,
				$this->jsConf->image_fill_color);
		else 
			# Just copy
			copy($imgsInfo->srcThumbImgPath.DS.$imgsInfo->srcThumbImgBasename,
				 $this->jsConf->image_product_path.DS.$availFilenameThumb);

		chmod($this->jsConf->image_product_path.DS.$availFilenameThumb, 0777);
		
		
		# DB import
		
		# Update product tbl
		$jsProdTbl =& JTable::getInstance('Product', 'jshop');
		$jsProdTbl->load($prodId);
		
		$jsProdTbl->set('product_full_image', $availFilenameFull);
		$jsProdTbl->set('product_name_image', $availFilenameMedium);
		$jsProdTbl->set('product_thumb_image', $availFilenameThumb);
		
		$jsProdTbl->store();
		
			
		# Insert to product images tbl
		$jsImgTbl =& JTable::getInstance('Image', 'jshop');

		$jsImgTbl->set('product_id', $prodId);
		$jsImgTbl->set('image_full', $availFilenameFull);
		$jsImgTbl->set('image_name', $availFilenameMedium);
		$jsImgTbl->set('image_thumb', $availFilenameThumb);

		$jsImgTbl->store();
	}
	
	# Parse VMart attributes
	function _parseVMartAttributes($attributes) {
		# VMart attributes format:
		# Color,Green[=10],Red[-5],Yellow[+5];Smell,Light[+5],Strong[+3],Medium[=20]
		
		# VMart code start
		$attributes_array = array();

		// Get each of the attributes into an array
		$product_attribute_keys = explode(";", $attributes);

		foreach ($product_attribute_keys as $attribute) {
			$attribute_name = substr($attribute, 0, strpos($attribute, ","));
			$attribute_values = substr($attribute, strpos($attribute, ",") + 1);
			$attributes_array[$attribute_name]['name'] = $attribute_name;
			// Read the different attribute values into an array
			$attribute_values = explode(',', $attribute_values);
			$operand = '';
			$my_mod = 0;

			foreach ($attribute_values as $value) {
				// Get the price modification for this attribute value
				$start = strpos($value, "[");
				$finish = strpos($value, "]", $start);

				$o = substr_count($value, "[");
				$c = substr_count($value, "]");

				// check to see if we have a bracket (means: a price modifier)
				if (TRUE == is_int($finish)) {
					$length = $finish - $start;

					// We found a pair of brackets (price modifier?)
					if ($length > 1) {
						$my_mod = substr($value, $start + 1, $length - 1);

						if ($o != $c) { // skip the tests if we don't have to process the string
							if ($o < $c) {
								$char = "]";
								$offset = $start;
							} else {
								$char = "[";
								$offset = $finish;
							}

							$s = substr_count($my_mod, $char);

							for ($r = 1; $r < $s; $r++) {
								$pos = strrpos($my_mod, $char);
								$my_mod = substr($my_mod, $pos + 1);
							}
						}

						$operand = substr($my_mod, 0, 1);
						$my_mod = substr($my_mod, 1);
					}
				}

				if ($start > 0)
					$value = substr($value, 0, $start);

				$attributes_array[$attribute_name]['values'][$value]['name'] = $value;
				$attributes_array[$attribute_name]['values'][$value]['operand'] = $operand;

				if ($base_price_only)
					$attributes_array[$attribute_name]['values'][$value]['adjustment'] = $my_mod;
				else
					$attributes_array[$attribute_name]['values'][$value]['adjustment'] =
						$my_mod * (1 - ($auth["shopper_group_discount"] / 100));

				$operand = '';
				$my_mod = 0;
			}
		}
		# VMart code end
		
		return $attributes_array;
	}
	
	# Build JShop attributes values variants matrix
	function _buildJShopAttributesValuesVariantsMatrix($mass) {
		# JShop code start
		$n = count($mass) - 1;
		$c = 0;
		$maxnum = array();
		$curnum = array();

		for($i = 0; $i <= $n; $i++) {
			$maxnum[$i] = count($mass[$i]);

			if ($i == 0)
				$c = $maxnum[$i];    
			else
				$c = $c * $maxnum[$i];

			$curnum[$i] = 0; 
		}

		$keys = array();
		$values = array();

		for ($j = 0; $j < $c; $j++) {
			$keys[$j] = array();
			$values[$j] = array();
			
			for($i = 0; $i <= $n; $i++) {
				$keys[$j][$i] = $curnum[$i];
				$values[$j][$i] = $mass[$i][$curnum[$i]];
			}
			
			$index = 0;
			
			for($i = 0; $i <= $n; $i++)
				if ($i == $index) {
					$curnum[$index]++;
					
					if ($curnum[$index] >= $maxnum[$index]) {
						$curnum[$index] = 0;
						$index++;
					}
				}
		}
		# JShop code end
		
		return $values;
	}

	# Print what processing and flush
	function _printImportingHeader($subj) {
		echo _JSHOP_IE_VMIMPORT_IMPORTING.' <b>'.$subj.'</b>... ';
		flush();
		@ob_flush();
	}

	# Print processed footer
	function _printImportingFooter() {
		echo '<font color="green">'._JSHOP_IE_VMIMPORT_SUCCEEDED.'</font></b><br>';
		flush();
		@ob_flush();
	}

	# Attributes
	function _importAttributes() {
		# Get last ordering
		$ordCnt = $this->_getLastOrdering('attributes');	
		
		$jsAttrs = array();			// Name => Id
		$jsVals = array();			// Name => Id
		$jsValXAttr = array();		// Val Id => Attr Id

		$query = "SELECT product_id, attribute
				  FROM `#__vm_product`";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmProd) {
			# Parse VMart attributes
			$vmAttrsArr = $this->_parseVMartAttributes($vmProd->attribute);

			# Product can have no attributes ('0' index means this)
			if (is_array($vmAttrsArr[0])) continue;
			
			$jsProdAttrs = array();		// attrId => vals ids
			$jsValDetailsArr = array();	// arrtValId => vals details array

			foreach ($vmAttrsArr as $vmAttrName => $vmAttrValsArr) {
				# Maybe earlier was attribute with the same name?
				if (!array_key_exists($vmAttrName, $jsAttrs)) {
					# Create new attr DB entry
					$jsAttrTbl =& JTable::getInstance('Attribut', 'jshop');
					$jsAttrTbl->set('attr_ordering', ++$ordCnt);
					
					$jsAttrTbl->set('attr_type', 1); // Default
					$jsAttrTbl->set($this->jsLang->get('name'), $vmAttrName);
					$jsAttrTbl->set('independent', ($this->attrStyle == 'jshop') ? 0 : 1); // 0 - JShop style, 1- VMart style
					$jsAttrTbl->store();

					$jsAttrs[$vmAttrName] = $jsAttrTbl->attr_id;
				}

				# Store this attribute ID as array index, i will fill values to it later
				$jsProdAttrs[$jsAttrs[$vmAttrName]] = array();


				# Processing sttribute values
				$vmVals = $vmAttrValsArr['values'];
				
				foreach ($vmVals as $vmValName => $vmValDetails) {
					# Maybe earlier was same value for same attribute?
					if ($jsValXAttr[$jsVals[$vmValName]] != $jsAttrs[$vmAttrName]) {
						# Create new attr val DB entry
						$jsAttrValTbl =& JTable::getInstance('AttributValue', 'jshop');
						$jsAttrValTbl->set('attr_id', $jsAttrs[$vmAttrName]);

						$valCnt = array_count_values($jsValXAttr);
						$jsAttrValTbl->set('value_ordering', $valCnt[$jsAttrs[$vmAttrName]] + 1);

						$jsAttrValTbl->set($this->jsLang->get('name'), $vmValName);
						$jsAttrValTbl->store();

						$jsVals[$vmValName] = $jsAttrValTbl->value_id;

						$jsValXAttr[$jsAttrValTbl->value_id] = $jsAttrs[$vmAttrName];
					}

					# Store this attribute value ID, i will assing it to product later
					$jsProdAttrs[$jsAttrs[$vmAttrName]][] = $jsVals[$vmValName];
					# Store val details
					$jsValDetailsArr[$jsVals[$vmValName]] = $vmValDetails;
				}
			}


			# ========== Import products attributes ==========

			switch ($this->attrStyle) {
				case 'jshop':
					# Build attributes values variants matrix
					$attrValsIdsArr = array();
					
					foreach ($jsProdAttrs as $attrValsIds)
						$attrValsIdsArr[] = $attrValsIds;
					
					$rowsArr = $this->_buildJShopAttributesValuesVariantsMatrix($attrValsIdsArr);

					
					# DB import
					
					# Insert new attributes fields to jshopping_products_attr table
					foreach ($jsProdAttrs as $attrId => $attrValsIds) {
						$query = "ALTER TABLE `#__jshopping_products_attr`
								  ADD `attr_$attrId` INT( 11 ) NOT NULL";
						$this->DB->setQuery($query);
						$this->DB->query();
					}
					
					# Fill jshopping_products_attr tbl
					foreach ($rowsArr as $attrValsIds) {
						$jsProdTbl = JTable::getInstance('Product', 'jshop');
						$jsProdTbl->load($this->vmIdXjsId['product'][$vmProd->product_id]);
			
						$jsProdAttrTbl = JTable::getInstance('ProductAttribut', 'jshop');
						
						$jsProdAttrTbl->set('product_id', $this->vmIdXjsId['product'][$vmProd->product_id]);
						
						# Count price
						$prodPrice = $jsProdTbl->product_price;
						$priceSet = FALSE;
						
						foreach ($attrValsIds as $valId) {
							if ($priceSet) break;

							$valDetails = $jsValDetailsArr[$valId];
							
							# Recalculate adjustment value considering currency
							$adjVal = $this->_convertPrice($valDetails['adjustment'],
														   $this->vmProductsCurrencies[$vmProd->product_id]);
							
							switch ($valDetails['operand']) {
								case '+':
									$prodPrice += $adjVal;
						
									break;
								case '-':
									$prodPrice -= $adjVal;
									
									break;
								case '=':
									$prodPrice = $adjVal;
									$priceSet = TRUE;
									
									break;
							}
						}
						
						$jsProdAttrTbl->set('price', $prodPrice);
						
						$jsProdAttrTbl->set('count', $jsProdTbl->product_quantity);
						$jsProdAttrTbl->set('ean', $jsProdTbl->product_ean);
						$jsProdAttrTbl->set('weight_volume_units', $jsProdTbl->weight_volume_units);
						 
						# Set selected values for each attribute
						foreach ($attrValsIds as $currValId)
							$jsProdAttrTbl->set('attr_'.$jsValXAttr[$valId], $valId);
						
						$jsProdAttrTbl->store();
					}
					
					break;
				case 'vmart':
					foreach ($jsValDetailsArr as $jsValId => $jsValDetails) {
						$jsProdAttr2Tbl = JTable::getInstance('ProductAttribut2', 'jshop');
						
						$jsProdAttr2Tbl->set('product_id', $this->vmIdXjsId['product'][$vmProd->product_id]);
						$jsProdAttr2Tbl->set('attr_id', $jsValXAttr[$jsValId]);
						$jsProdAttr2Tbl->set('attr_value_id', $jsValId);
						$jsProdAttr2Tbl->set('price_mod', $jsValDetails['operand']);
						$jsProdAttr2Tbl->set('addprice', $jsValDetails['adjustment']);

						$jsProdAttr2Tbl->store();
					}
					
					break;
			}
		}
	}
	
	# Categories
	function _importCategories() {
		# Get last ordering
		$ordCnt = $this->_getLastOrdering('categories') + 1; // In VMart ordering can be 0

		$jsCatIdXvmSubcatId = array();

		$query = "SELECT vm_cat.*, vm_cat_xref.category_parent_id
				  FROM `#__vm_category` AS vm_cat
				  LEFT JOIN `#__vm_category_xref` AS vm_cat_xref
				  ON vm_cat.`category_id` = vm_cat_xref.`category_child_id`";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmCat) {
			# DB import
			$jsCatTbl =& JTable::getInstance('Category', 'jshop');
			
			
			# Image
			switch ($this->catImage) {
				case 'full':
					if (!empty($vmCat->category_full_image)) {
						$createdFilename = $this->_processCategoryImage($vmCat->category_full_image);
						
						$jsCatTbl->set('category_image', $createdFilename);
					}
					
					break;
				case 'thumb':
					if (!empty($vmCat->category_thumb_image)) {
						$createdFilename = $this->_processCategoryImage($vmCat->category_thumb_image);
						
						$jsCatTbl->set('category_image', $createdFilename);
					}
					
					break;
			}
			
			
			# Subcat i will assign later, i need first all JShop cats real IDs, because i don't now yet if
			# $vmCat->category_parent_id is already in $this->vmIdXjsId['category'] array
			
			$jsCatTbl->set('category_publish', ($vmCat->category_publish == 'Y') ? 1 : 0);
			$jsCatTbl->set('category_ordertype', 1); // Default
			$jsCatTbl->set('category_template', 'default'); // Default
			
			# If this isn't child category I should leave existing cats at the start of list and save VMart cats ordering,
			# if this is child category ordering duplicate with main categories no matters
			if (!$vmCat->category_parent_id)
				$jsCatTbl->set('ordering', $ordCnt + $vmCat->list_order);
			else
				$jsCatTbl->set('ordering', $vmCat->list_order);

			$jsCatTbl->set('category_add_date', date('Y-m-d H:i:s', $vmCat->cdate));
			$jsCatTbl->set('products_page', $this->jsConf->count_products_to_page); // Config
			$jsCatTbl->set('products_row', $vmCat->products_per_row);
			$jsCatTbl->set($this->jsLang->get('name'), $vmCat->category_name);
			
			# Generate alias if such option is checked
			if ($this->generateAliases)
				$jsCatTbl->set($this->jsLang->get('alias'),
							   $this->_generateAlias('category', $vmCat->category_name));

			$jsCatTbl->set($this->jsLang->get('description'), $vmCat->category_description);
			
			# Automatically fill META-tags if such option is checked
			if ($this->autofillMeta) {
				$jsCatTbl->set($this->jsLang->get('meta_title'), strip_tags($vmCat->category_name));
				$jsCatTbl->set($this->jsLang->get('meta_description'),
							   strip_tags($vmCat->category_description));
			}
			
			$jsCatTbl->store();
			
			# Save relations between ids
			$this->vmIdXjsId['category'][$vmCat->category_id] = $jsCatTbl->category_id;
			
			# Save subcat ID, so later I can save real JShop subcat ID to category
			$jsCatIdXvmSubcatId[$jsCatTbl->category_id] = $vmCat->category_parent_id;
		}


		# Now I have all real cats IDs, so I can...
		# Assign subcats to categories
		
		$query = "SELECT category_id
				  FROM `#__jshopping_categories`";

		$this->DB->setQuery($query);
		$this->DB->query();
		
		$jsCatIds = $this->DB->loadResultArray();
		
		# Can be no categories, hmm... not real situation :)
		if (!empty($jsCatIds[0]))
			foreach ($jsCatIds as $jsCatId) {
				if ($jsCatIdXvmSubcatId[$jsCatId]) {
					# Category have parent, we can resume
					$jsCatTbl =& JTable::getInstance('Category', 'jshop');
					
					$jsCatTbl->load($jsCatId);
					$jsCatTbl->set('category_parent_id', $this->vmIdXjsId['category'][$jsCatIdXvmSubcatId[$jsCatId]]);

					$jsCatTbl->store();
				}
			}
	}
	
	# Characteristics
	function _importCharacteristics() {
		# Get last ordering
		$ordCnt = $this->_getLastOrdering('characteristics');
		
		$query = "SELECT product_type_id, product_type_name
				  FROM `#__vm_product_type`
				  ORDER BY product_type_list_order ASC";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmProdType) {
			$query = "SELECT * FROM `#__vm_product_type_parameter`
					  WHERE product_type_id = $vmProdType->product_type_id
					  ORDER BY product_type_id, parameter_list_order";

			$this->DB->setQuery($query);
			$this->DB->query();
			
			foreach ($this->DB->loadObjectList() as $vmProdTypeParameter) {
				# Create characteristic record
				$jsCharacteristicTbl =& JTable::getInstance('ProductField', 'jshop');

				$jsCharacteristicTbl->set('allcats', 1); // Default
				$jsCharacteristicTbl->set('cats', 'a:0:{}'); // JShop makes so
				$jsCharacteristicTbl->set('ordering', ++$ordCnt);
				
				if ($this->characteristicPrefix)
					$characteristicLabel = $vmProdType->product_type_name.' / '.
										   $vmProdTypeParameter->parameter_label;
				else
					$characteristicLabel = $vmProdTypeParameter->parameter_label;
					
				$jsCharacteristicTbl->set($this->jsLang->get('name'), $characteristicLabel);
				
				$jsCharacteristicTbl->store();
				
				
				# Create characteristic values records
				
				# Here I store inserted values ids
				$vmProdTypeParameterValuesIds = array(); // value => its id
				
				$vmProdTypeParameterValues = explode(';', $vmProdTypeParameter->parameter_values);
				
				if (!empty($vmProdTypeParameterValues[0])) {
					$ord2Cnt = 0;
					
					foreach ($vmProdTypeParameterValues as $vmProdTypeParameterValue) {
						$jsCharacteristicValueTbl =& JTable::getInstance('ProductFieldValue', 'jshop');

						$jsCharacteristicValueTbl->set('field_id', $jsCharacteristicTbl->id);
						$jsCharacteristicValueTbl->set('ordering', ++$ord2Cnt);
							
						$jsCharacteristicValueTbl->set($this->jsLang->get('name'), $vmProdTypeParameterValue);
						
						$jsCharacteristicValueTbl->store();
						
						$vmProdTypeParameterValuesIds[$vmProdTypeParameterValue] = $jsCharacteristicValueTbl->id;
					}
				}
				
				
				# Add characteristic field to jshopping_products tbl
				$query = "ALTER TABLE `#__jshopping_products` ADD COLUMN `extra_field_$jsCharacteristicTbl->id` INT(11) NOT NULL";

				$this->DB->setQuery($query);
				$this->DB->query();
				
				
				# Assign characteristic value to product
				$query = "SELECT product_id, $vmProdTypeParameter->parameter_name
						  FROM `#__vm_product_type_$vmProdType->product_type_id`";
				
				$this->DB->setQuery($query);
				$this->DB->query();
				
				foreach ($this->DB->loadObjectList() as $vmProdTypeParameterValueObj) {
					$jsProdTbl =& JTable::getInstance('Product', 'jshop');
					
					$jsProdTbl->load($this->vmIdXjsId['product'][$vmProdTypeParameterValueObj->product_id]);
					
					$jsProdTbl->set('extra_field_'.$jsCharacteristicTbl->id,
									$vmProdTypeParameterValuesIds[$vmProdTypeParameterValueObj->{$vmProdTypeParameter->parameter_name}]);
					
					$jsProdTbl->store();
				}
			}
		}
	}

	# Coupons
	function _importCoupons() {
		$query = "SELECT *
				  FROM `#__vm_coupons`";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmCoupon) {
			# DB import
			$jsCouponTbl =& JTable::getInstance('Coupon', 'jshop');

			$jsCouponTbl->set('coupon_type', ($vmCoupon->percent_or_total == 'percent') ? 1 : 0);
			$jsCouponTbl->set('coupon_code', $vmCoupon->coupon_code);
			$jsCouponTbl->set('coupon_value', $vmCoupon->coupon_value);
			$jsCouponTbl->set('tax_id', 0); // None
			$jsCouponTbl->set('used', 0); // Default
			$jsCouponTbl->set('for_user_id', 0); // None
			$jsCouponTbl->set('finished_after_used', ($vmCoupon->coupon_type == 'permanent') ? 1 : 0);
			$jsCouponTbl->set('coupon_publish', 1); // Default
			
			$jsCouponTbl->store();
		}
	}
	
	# Free attributes
	function _importFreeAttributes() {
		# Get last ordering
		$ordCnt = $this->_getLastOrdering('free_attributes');

		# Here I save all free attributes names, I will store them in jshopping_free_attr table
		$jsFreeAttrs = array(); // Name => Id
		
		$query = "SELECT product_id, custom_attribute
				  FROM `#__vm_product`";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmProd) {
			$vmFreeAttrs = explode('; ', $vmProd->custom_attribute);
			
			if (!empty($vmFreeAttrs[0]))
				foreach ($vmFreeAttrs as $vmFreeAttr) {
					# I do not add duplicate free attributes to DB, so I need to store unique names in array
					if (!array_key_exists($vmFreeAttr, $jsFreeAttrs)) {
						# Create new free attr DB entry
						$jsFreeAttrTbl =& JTable::getInstance('FreeAttribut', 'jshop');
						$jsFreeAttrTbl->set('ordering', ++$ordCnt);
						$jsFreeAttrTbl->set('required', $this->makeFreeAttributesRequired);
						$jsFreeAttrTbl->set($this->jsLang->get('name'), $vmFreeAttr);
						$jsFreeAttrTbl->store();

						$jsFreeAttrs[$vmFreeAttr] = $jsFreeAttrTbl->id;
					}
					
					# Create new product free attr DB entry
					# JShop have no JTable for ShippingMethodPriceCountries, so I add manually
					$jsProdId = $this->vmIdXjsId['product'][$vmProd->product_id];
					$jsFreeAttrId = $jsFreeAttrs[$vmFreeAttr];
					
					$query = "INSERT INTO `#__jshopping_products_free_attr`
							  (product_id, attr_id)
							  VALUES ($jsProdId, $jsFreeAttrId)";
					$this->DB->setQuery($query);
					$this->DB->query();
				}
		}
	}

	# Manufacturers
	function _importManufacturers() {
		# Get last ordering
		$ordCnt = $this->_getLastOrdering('manufacturers');

		$query = "SELECT *
				  FROM `#__vm_manufacturer`";

		$this->DB->setQuery($query);
		$this->DB->query();
		
		foreach ($this->DB->loadObjectList() as $vmManufacturer) {
			# DB import
			$jsManufacturerTbl =& JTable::getInstance('Manufacturer', 'jshop');

			$jsManufacturerTbl->set('manufacturer_url', $vmManufacturer->mf_url);
			$jsManufacturerTbl->set('manufacturer_publish', 1); // Default
			$jsManufacturerTbl->set('products_page', $this->jsConf->count_products_to_page); // Config
			$jsManufacturerTbl->set('products_row', $this->jsConf->count_products_to_row); // Config
			$jsManufacturerTbl->set('ordering', ++$ordCnt);
			$jsManufacturerTbl->set($this->jsLang->get('name'), $vmManufacturer->mf_name);
			
			# Generate alias if such option is checked
			if ($this->generateAliases)
				$jsManufacturerTbl->set($this->jsLang->get('alias'),
										$this->_generateAlias('manufacturer', $vmManufacturer->mf_name));
					
			$jsManufacturerTbl->set($this->jsLang->get('description'), $vmManufacturer->mf_desc);
			
			# Automatically fill META-tags if such option is checked
			if ($this->autofillMeta) {
				$jsManufacturerTbl->set($this->jsLang->get('meta_title'),
										strip_tags($vmManufacturer->mf_name));
				$jsManufacturerTbl->set($this->jsLang->get('meta_description'),
										strip_tags($vmManufacturer->mf_desc));
			}
			
			$jsManufacturerTbl->store();
			
			# Save relations between ids
			$this->vmIdXjsId['manufacturer'][$vmManufacturer->manufacturer_id] = $jsManufacturerTbl->manufacturer_id;
		}
	}
	
	# Products
	function _importProducts() {
		$defaultShopperSubQuery = "SELECT shopper_group_id
								   FROM `#__vm_shopper_group`
								   WHERE vendor_id = 0 AND `default` = 1";
					  
		$subQuery1 = "SELECT product_price
					  FROM `#__vm_product_price`
					  WHERE product_id = vm_prod.product_id AND
							(price_quantity_start = 0 AND price_quantity_end = 0)
							AND shopper_group_id = COALESCE(vm_shopper_group.shopper_group_id, ($defaultShopperSubQuery))";
		
		$subQuery2 = "SELECT product_currency
					  FROM `#__vm_product_price`
					  WHERE product_id = vm_prod.product_id AND
							(price_quantity_start = 0 AND price_quantity_end = 0)
							AND shopper_group_id = COALESCE(vm_shopper_group.shopper_group_id, ($defaultShopperSubQuery))";

		$subQuery3 = "SELECT COUNT(product_price_id)
					  FROM `#__vm_product_price`
					  WHERE product_id = vm_prod.product_id AND
							(price_quantity_start <> 0 OR price_quantity_end <> 0)";

		$subQuery4 = "SELECT AVG(user_rating)
					  FROM `#__vm_product_reviews`
					  WHERE product_id = vm_prod.product_id";

		$subQuery5 = "SELECT COUNT(review_id)
					  FROM `#__vm_product_reviews`
					  WHERE product_id = vm_prod.product_id";
		

		$query = "SELECT vm_prod.*,
						 ($subQuery1) AS product_price,
						 ($subQuery2) AS product_currency,
						 ($subQuery3) AS product_add_price_quantity,
						 ($subQuery4) AS product_average_rating,
						 ($subQuery5) AS product_reviews_quantity,
						 
						 vm_prod_discount.amount AS product_discount_amount,
						 vm_prod_discount.is_percent AS product_discount_type,
						 vm_prod_discount.start_date AS product_discount_startdate,
						 vm_prod_discount.end_date AS product_discount_enddate,

						 vm_prod_manufacturer.manufacturer_id

				  FROM `#__vm_product` AS vm_prod

				  LEFT JOIN `#__vm_shopper_group` AS vm_shopper_group USING (vendor_id)
				  LEFT JOIN `#__vm_product_discount` AS vm_prod_discount
					ON vm_prod.`product_discount_id` = vm_prod_discount.`discount_id`
				  LEFT JOIN `#__vm_product_mf_xref` AS vm_prod_manufacturer USING (product_id)
				  
				  WHERE vm_shopper_group.`default` = 1";

		$this->DB->setQuery($query);
		$this->DB->query();

		
		$total = count($this->DB->loadObjectList());
		$cnt = 0;
		
		foreach ($this->DB->loadObjectList() as $vmProd) {
			# Print start message	 
			echo "&nbsp;&nbsp;&nbsp;<b>(".($cnt + 1)."/$total)</b>... ";
			
			$cnt++;
			
			flush();
			@ob_flush();


			# DB import
			$jsProdTbl =& JTable::getInstance('Product', 'jshop');

			$jsProdTbl->set('product_ean', $vmProd->product_sku);
			$jsProdTbl->set('product_quantity', $vmProd->product_in_stock);
			
			# Is available date in the past?
			$jsProdTbl->set('product_availability',
							(time() < $vmProd->product_available_date) ? 1 : 0);

			$jsProdTbl->set('product_date_added', date('Y-m-d H:i:s', $vmProd->cdate));
			$jsProdTbl->set('date_modify', date('Y-m-d H:i:s', $vmProd->mdate));
			$jsProdTbl->set('product_publish', ($vmProd->product_publish == 'Y') ? 1 : 0);
			$jsProdTbl->set('product_tax_id', $this->vmIdXjsId['tax'][$vmProd->product_tax_id]);
			$jsProdTbl->set('product_template', 'default'); // Default
			$jsProdTbl->set('product_url', $vmProd->product_url);
			$jsProdTbl->set('product_old_price', '0.00'); // Default
			$jsProdTbl->set('product_buy_price', '0.00'); // Default
			
			
			# Price
			
			# JShop does not support discounts for products, so I should recalculate price if discount present
			$prodDiscount = 0;
			
			$discountActual = true;
				
			if (!empty($vmProd->product_discount_startdate) && time() < $vmProd->product_discount_startdate)
				$discountActual = false;
			
			if (!empty($vmProd->product_discount_enddate) && time() > $vmProd->product_discount_enddate)
				$discountActual = false;
			
			if (!empty($vmProd->product_discount_amount) && $discountActual)
				switch ($vmProd->is_percent) {
					case 0:
						$prodDiscount = $vmProd->product_discount_amount;

						break;
					case 1:
						$prodDiscount = $vmProd->product_price * $vmProd->product_discount_amount / 100;
						
						break;
				}
			
			# Then I should convert price
			$jsProdTbl->set('product_price',
							$this->_convertPrice($vmProd->product_price - $prodDiscount, $vmProd->product_currency));
			
			
			$jsProdTbl->set('product_weight', $vmProd->product_weight);

			# Images are importing below
			
			# VMart can have many manufacturers for one product, I set first meeted
			$jsProdTbl->set('product_manufacturer_id',
							$this->vmIdXjsId['manufacturer'][$vmProd->manufacturer_id]);

			$jsProdTbl->set('product_is_add_price',
							($vmProd->product_add_price_quantity != 0) ? 1 : 0);

			# Transpose VMart max mark system (5) to JShop
			$jsProdTbl->set('average_rating',
							($vmProd->product_average_rating * $this->jsConf->max_mark) / 5);

			$jsProdTbl->set('reviews_count', $vmProd->product_reviews_quantity);
			$jsProdTbl->set('vendor_id', $this->vmIdXjsId['vendor'][$vmProd->vendor_id]);
			
			
			# Product name
			$prodName = $vmProd->product_name;
			
			# Add subproduct attributes to product title if such option is enabled
			if (!empty($vmProd->product_parent_id) && $this->addAttrsToSubproductTitle)
				$prodName .= ' '.$this->_getSubproductAttrsStr($vmProd->product_id);
				
			$jsProdTbl->set($this->jsLang->get('name'), $prodName);
			
			
			# Generate alias if such option is checked
			if ($this->generateAliases)
				$jsProdTbl->set($this->jsLang->get('alias'), $this->_generateAlias('product', $prodName));
			
			$jsProdTbl->set($this->jsLang->get('short_description'), $vmProd->product_s_desc);
			$jsProdTbl->set($this->jsLang->get('description'), $vmProd->product_desc);
			
			# Automatically fill META-tags if such option is checked
			if ($this->autofillMeta) {
				$jsProdTbl->set($this->jsLang->get('meta_title'), strip_tags($vmProd->product_name));
				$jsProdTbl->set($this->jsLang->get('meta_description'), strip_tags($vmProd->product_s_desc));
			}
			
			$jsProdTbl->store();
			
			# Save relations between ids
			$this->vmIdXjsId['product'][$vmProd->product_id] = $jsProdTbl->product_id;
			
			# Save product currency for later use
			$this->vmProductsCurrencies[$vmProd->product_id] = $vmProd->product_currency;


			# Product images
			if (!empty($vmProd->product_full_image) && !empty($vmProd->product_thumb_image)) {	
				# Process files
				$imgsInfo = new stdClass();
				$imgsInfo->srcFullImgPath = $this->vmImgPath.'product';
				$imgsInfo->srcFullImgBasename = $vmProd->product_full_image;
				$imgsInfo->srcThumbImgPath = $this->vmImgPath.'product';
				$imgsInfo->srcThumbImgBasename = $vmProd->product_thumb_image;
				$imgsInfo->dstImgBasename = $vmProd->product_full_image;
				
				$this->_processProductImages($imgsInfo, $jsProdTbl->product_id);
			}
			
			# Print finished message
			$this->_printImportingFooter();
		}
	}

	# Products files
	function _importProductsFiles() {
		# Ordering for files
		$ordCnt = 0;
					
		$query = "SELECT *
				  FROM `#__vm_product_files`";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmProdFile) {
			$parsedFileName = MMLib::parseFileName(JPATH_SITE.$vmProdFile->file_name);
			
			# I don't think its good idea to give to file such name, but this is JShop behaviour for file name
			$filteredBasename = MMLib::ASCIIFilename($parsedFileName->name).'.'.$parsedFileName->extension;
			
			switch (strtolower($vmProdFile->file_extension)) {
				# Image file types I import as additional images for product
				case 'bmp':
				case 'jpg':
				case 'jpeg':
				case 'gif':
				case 'png':
					# Process files
					$imgsInfo = new stdClass();
					$imgsInfo->srcFullImgPath = $parsedFileName->path;
					$imgsInfo->srcFullImgBasename = $parsedFileName->basename;
					
					# Img file can be without generated thumb
					if (!empty($vmProdFile->file_image_thumb_height) &&
						!empty($vmProdFile->file_image_thumb_width)) {
							
						$imgsInfo->srcThumbImgPath = $parsedFileName->path.DS.'resized';
						$imgsInfo->srcThumbImgBasename = $parsedFileName->name.'_'.
														 $vmProdFile->file_image_thumb_height.
														 'x'.
														 $vmProdFile->file_image_thumb_width.
														 '.'.
														 $parsedFileName->extension;
					}
					else {
						# Taking original img for thumb
						$imgsInfo->srcThumbImgPath = $parsedFileName->path;
						$imgsInfo->srcThumbImgBasename = $parsedFileName->basename;
					}
					
					
					$imgsInfo->dstImgBasename = $filteredBasename;

					$this->_processProductImages($imgsInfo,
												 $this->vmIdXjsId['product'][$vmProdFile->file_product_id],
												 TRUE);
				
					break;
					
				# Video file types that JShop jQuery Media Plugin can play I import as video
				case 'flv':
				case 'swf':
				case 'mov':
				case 'mpg':
				case 'mpeg':
				case 'mp4':
				case 'qt':
				case '3g2':
				case '3gp':
				case 'rm':
				case 'rv':
				case 'smi':
				case 'smil':
				case 'asf':
				case 'avi':
				case 'wmv':
					# Get first available filename if file with given filename already exists
					$availFilename = MMLib::getAvailableFileName($this->jsConf->video_product_path.DS.
																 $filteredBasename);
						
					# File copy
					copy(JPATH_SITE.$vmProdFile->file_name,
						 $this->jsConf->video_product_path.DS.$availFilename);
					chmod($this->jsConf->video_product_path.DS.$availFilename, 0777);
					
					# DB import
					$jsProdVideoTbl = JTable::getInstance('ProductVideo', 'jshop');
					
					$jsProdVideoTbl->set('product_id', $this->vmIdXjsId['product'][$vmProdFile->file_product_id]);
					$jsProdVideoTbl->set('video_name', $availFilename);
					
					$jsProdVideoTbl->store();
					
					break;
					
				# Non-categorized file
				default:
					# Get first available filename if file with given filename already exists
					$availFilename = MMLib::getAvailableFileName($this->jsConf->files_product_path.DS.
																 $filteredBasename);
						
					# File copy
					copy(JPATH_SITE.$vmProdFile->file_name,
						 $this->jsConf->files_product_path.DS.$availFilename);
					chmod($this->jsConf->files_product_path.DS.$availFilename, 0777);

					# DB import
					$jsProdFileTbl =& JTable::getInstance('ProductFiles', 'jshop');

					$jsProdFileTbl->set('product_id',
										$this->vmIdXjsId['product'][$vmProdFile->file_product_id]);
					$jsProdFileTbl->set('file', $availFilename);
					$jsProdFileTbl->set('file_descr', $vmProdFile->file_description);
					$jsProdFileTbl->set('ordering', ++$ordCnt);
					
					$jsProdFileTbl->store();
					
					break;
			}
		}
	}
	
	# Products relations
	function _importProductsRelations() {
		$query = "SELECT *
				  FROM `#__vm_product_relations`";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmProdRelation) {
			$jsProdId = $this->vmIdXjsId['product'][$vmProdRelation->product_id];
			$relatedIds = explode('|', $vmProdRelation->related_products);

			foreach ($relatedIds as $relProdId) {
				$jsRelProdId = $this->vmIdXjsId['product'][$relProdId];
				
				# DB import
				# JShop have no JTable for products_relations, so I add manually
				$query = "INSERT INTO `#__jshopping_products_relations`
						  (product_id, product_related_id)
						  VALUES ($jsProdId, $jsRelProdId)";
				$this->DB->setQuery($query);
				$this->DB->query();
			}
		}
		
		
		# Make subproducts related if such option is checked
		if ($this->makeSubproductsRelative) {
			$query = "SELECT product_id, product_parent_id
					  FROM `#__vm_product`
					  WHERE product_parent_id <> 0";

			$this->DB->setQuery($query);
			$this->DB->query();
			
			foreach ($this->DB->loadObjectList() as $vmProd) {
				$jsProdId = $this->vmIdXjsId['product'][$vmProd->product_id];
				$jsParProdId = $this->vmIdXjsId['product'][$vmProd->product_parent_id];
					
				# DB import
				# JShop have no JTable for products_relations, so I add manually
				$query = "INSERT INTO `#__jshopping_products_relations`
						  (product_id, product_related_id)
						  VALUES ($jsParProdId, $jsProdId)";
				$this->DB->setQuery($query);
				$this->DB->query();
			}
		}
	}

	# Products reviews
	function _importProductsReviews() {
		$query = "SELECT prod_reviews.*, users.username, users.email
				  FROM `#__vm_product_reviews` AS prod_reviews
				  LEFT JOIN `#__users` AS users
				  ON prod_reviews.userid = users.id";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmProdReview) {
			$jsProductReviewTbl = JTable::getInstance('Review', 'jshop');
			
			$jsProductReviewTbl->set('product_id', $this->vmIdXjsId['product'][$vmProdReview->product_id]);
			$jsProductReviewTbl->set('user_id', $vmProdReview->userid);
			$jsProductReviewTbl->set('user_name', $vmProdReview->username);
			$jsProductReviewTbl->set('user_email', $vmProdReview->email);
			$jsProductReviewTbl->set('time', date('Y-m-d H:i:s', $vmProdReview->time));
			$jsProductReviewTbl->set('review', $vmProdReview->comment);
			
			# Transpose curr rating to JShop max rating
			$jsProductReviewTbl->set('mark', ($vmProdReview->user_rating * $this->jsConf->max_mark) / 5);
			
			$jsProductReviewTbl->set('publish', ($vmProdReview->published == 'Y') ? 1 : 0);
			
			$jsProductReviewTbl->store();
		}
	}
	
	# Products shipment prices
	function _importProductsShipmentPrices() {
		$defaultShopperSubQuery = "SELECT shopper_group_id
								   FROM `#__vm_shopper_group`
								   WHERE vendor_id = 0 AND `default` = 1";
								   
		$query = "SELECT prod_prices_quantity.*,
						 prod_prices_base.product_price AS base_price,
						 prod_prices_base.product_currency AS base_currency
						 
				  FROM `#__vm_product_price` AS prod_prices_quantity
				  
				  LEFT JOIN `#__vm_product_price` AS prod_prices_base ON prod_prices_quantity.product_id = prod_prices_base.product_id
				  LEFT JOIN `#__vm_product` AS prod ON prod_prices_quantity.product_id = prod.product_id
				  LEFT JOIN `#__vm_shopper_group` AS vm_shopper_group USING (vendor_id)

				  WHERE (prod_prices_quantity.price_quantity_start <> 0 OR prod_prices_quantity.price_quantity_end) <> 0 AND
						(prod_prices_base.price_quantity_start = 0 AND prod_prices_base.price_quantity_end = 0) AND
						prod_prices_quantity.shopper_group_id = COALESCE(vm_shopper_group.shopper_group_id, ($defaultShopperSubQuery))";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmProdShipmentPrice) {
			# Convert prices considering currency
			$basePrice = $this->_convertPrice($vmProdShipmentPrice->base_price,
											  $vmProdShipmentPrice->base_currency);
			
			$discountPrice = $this->_convertPrice($vmProdShipmentPrice->product_price,
												  $vmProdShipmentPrice->product_currency);
													  
			# DB import
			$jsProdShipmentPriceTbl =& JTable::getInstance('ProductPrice', 'jshop');

			$jsProdShipmentPriceTbl->set('product_id',
										 $this->vmIdXjsId['product'][$vmProdShipmentPrice->product_id]);

			# 1 - price, 2 - percent
			switch ($this->jsConf->product_price_qty_discount) {
				case 1:
					$jsProdShipmentPriceTbl->set('discount', $basePrice - $discountPrice);
					
					break;
				case 2:
					$jsProdShipmentPriceTbl->set('discount',
												 abs(($discountPrice - $basePrice) / $basePrice) * 100);

					break;
			}

			$jsProdShipmentPriceTbl->set('product_quantity_start',
									 $vmProdShipmentPrice->price_quantity_start);
			$jsProdShipmentPriceTbl->set('product_quantity_finish',
									 $vmProdShipmentPrice->price_quantity_end);
			
			$jsProdShipmentPriceTbl->store();
		}
	}

	# Products to categories accessory
	function _importProductsToCategoriesAccessory() {
		$query = "SELECT *
				  FROM `#__vm_product_category_xref`";

		$this->DB->setQuery($query);
		$this->DB->query();
		
		foreach ($this->DB->loadObjectList() as $vmProdCatXref) {
			$jsProdId = $this->vmIdXjsId['product'][$vmProdCatXref->product_id];
			$jsCatId = $this->vmIdXjsId['category'][$vmProdCatXref->category_id];
			
			$ordCnt = $vmProdCatXref->product_list;
			MMLib::setZeroIfVarEmpty($ordCnt);
			
			# DB import
			$query = "INSERT INTO `#__jshopping_products_to_categories`
					  (product_id, category_id, product_ordering)
					  VALUES ($jsProdId, $jsCatId, $ordCnt)";
			$this->DB->setQuery($query);
			$this->DB->query();
		}
	}
	
	# Shipping methods
	function _importShippingMethods() {
		# In JShop one shipping method have different weight ranges,
		# in VMart each weight range are stored in a new shipping method.
		# In both JShop and VMart for each shipping method I can select one or more country.
		# So I will import VMart shipping methods with the same first word of title
		# as one JShop shipping method with the same countries list, currency and tax, 
		# but different weight ranges, price, package price as one JShop shipping method.
		# I imply that VMart shipping methods with the same first word have the same countries list & currency
		
		# Get last ordering
		$ordCnt = $this->_getLastOrdering('shipping_methods');
		
		# Assoc array of shipping methods with first word of name as key
		$shippingMethodsArr = array();
		
		$query = "SELECT sm.shipping_rate_name, sm.shipping_rate_country, sm.shipping_rate_weight_start, 
						 sm.shipping_rate_weight_end, sm.shipping_rate_value, sm.shipping_rate_package_fee,
						 c.currency_code
				  FROM `#__vm_shipping_rate` AS sm
				  LEFT JOIN `#__vm_currency` AS c
					ON sm.shipping_rate_currency_id = c.currency_id
				  ORDER BY sm.shipping_rate_id";

		$this->DB->setQuery($query);
		$this->DB->query();

		
		# Make assoc array of shipping methods with first word of name as key
		foreach ($this->DB->loadObjectList() as $vmShippingMethod) {
			$firstWord = substr($vmShippingMethod->shipping_rate_name,
								0,
								strpos($vmShippingMethod->shipping_rate_name, ' '));
			
			$shippingMethodsArr[$firstWord][] = $vmShippingMethod;
		}
		
		
		# DB import
		foreach ($shippingMethodsArr as $shippingMethodName => $shippingMethodValues) {
			# DB import of shipping method
			$jsShippingMethodTbl =& JTable::getInstance('ShippingMethod', 'jshop');
			
			$jsShippingMethodTbl->set($this->jsLang->get('name'), $shippingMethodName);
			$jsShippingMethodTbl->set('shipping_publish', 1); // Default
			$jsShippingMethodTbl->set('shipping_ordering', ++$ordCnt);
			
			$jsShippingMethodTbl->store();
			
			
			# DB import of shipping method price
			$jsShippingMethodPriceTbl =& JTable::getInstance('ShippingMethodPrice', 'jshop');
		
			$jsShippingMethodPriceTbl->set('shipping_method_id', $jsShippingMethodTbl->shipping_id);
			$jsShippingMethodPriceTbl->set('shipping_tax_id', 0); // None
			
			# If there are only one price value for shipping method I set stand price too
			if (count($shippingMethodValues) == 1)
				$jsShippingMethodPriceTbl->set('shipping_stand_price',
											   $shippingMethodValues[0]->shipping_rate_value);
			
			$jsShippingMethodPriceTbl->store();
			
			
			# DB import of shipping method price countries
			$countryCodes = explode(';', $shippingMethodValues[0]->shipping_rate_country);
			
			if (!empty($countryCodes[0]))
				foreach ($countryCodes as $countryCode) {
					$countryId = $this->_getJSCountryID($countryCode);
					
					# JShop have no JTable for ShippingMethodPriceCountries, so I add manually
					$query = "INSERT INTO `#__jshopping_shipping_method_price_countries`
							  (country_id, sh_pr_method_id)
							  VALUES ($countryId, $jsShippingMethodPriceTbl->sh_pr_method_id)";
					$this->DB->setQuery($query);
					$this->DB->query();
				}
			

			# DB import of shipping method weight ranges and prices for them
			foreach ($shippingMethodValues as $shippingMethodValue) {
				$jsShippingMethodPriceWeightTbl =& JTable::getInstance('ShippingMethodPriceWeight', 'jshop');
		
				$jsShippingMethodPriceWeightTbl->set('sh_pr_method_id',
													 $jsShippingMethodPriceTbl->sh_pr_method_id);
				$jsShippingMethodPriceWeightTbl->set('shipping_price',
													 $shippingMethodValue->shipping_rate_value);
				$jsShippingMethodPriceWeightTbl->set('shipping_weight_from',
													 $shippingMethodValue->shipping_rate_weight_start);
				$jsShippingMethodPriceWeightTbl->set('shipping_weight_to',
													 $shippingMethodValue->shipping_rate_weight_end);
				$jsShippingMethodPriceWeightTbl->set('shipping_package_price',
													 $shippingMethodValue->shipping_rate_package_fee);
													 
				$jsShippingMethodPriceWeightTbl->store();
			}
		}
	}
	
	# Store info
	function _importStoreInfo() {
		# VMart keep store info in vm_vendor table with vendor_id=1, other records are vendors
		
		$query = "SELECT *
				  FROM `#__vm_vendor`
				  WHERE vendor_id = 1";

		$this->DB->setQuery($query);
		$this->DB->query();
		
		$vmStoreInfo = $this->DB->loadObject();

		# DB import
		$jsConfigTbl =& JTable::getInstance('Config', 'jshop');

		$jsConfigTbl->set('id', 1); // Only one record is allowed
		$jsConfigTbl->set('store_name', $vmStoreInfo->vendor_store_name);
		$jsConfigTbl->set('store_company_name', $vmStoreInfo->vendor_name);
		$jsConfigTbl->set('store_url', $vmStoreInfo->vendor_url);
		$jsConfigTbl->set('store_address', $vmStoreInfo->vendor_address_1);
		$jsConfigTbl->set('store_city', $vmStoreInfo->vendor_city);
		
		# Get country ID
		$jsConfigTbl->set('store_country', $this->_getJSCountryID($vmStoreInfo->vendor_country));
		
		# Get state name
		$jsConfigTbl->set('store_state',
						  $this->_getVMStateName($vmStoreInfo->vendor_country, $vmStoreInfo->vendor_state));
		
		$jsConfigTbl->set('store_zip', $vmStoreInfo->vendor_zip);
		
		
		# Vmart uses 2 addresses, JShop only one. I will use first. Other variables match
		$addressFormat = str_replace('{address_1}', '{address}', $vmStoreInfo->vendor_address_format);
		$addressFormat = str_replace('{', '%', $addressFormat);
		$addressFormat = str_replace('}', '', $addressFormat);
		
		MMLib::setIfValNoEmpty($jsConfigTbl->store_address_format, $addressFormat);
		
		
		MMLib::setIfValNoEmpty($jsConfigTbl->store_date_format, $vmStoreInfo->vendor_date_format);
		$jsConfigTbl->set('contact_firstname', $vmStoreInfo->contact_first_name);
		$jsConfigTbl->set('contact_lastname', $vmStoreInfo->contact_last_name);
		$jsConfigTbl->set('contact_middlename', $vmStoreInfo->contact_middle_name);
		$jsConfigTbl->set('contact_phone', $vmStoreInfo->contact_phone_1);
		$jsConfigTbl->set('contact_fax', $vmStoreInfo->contact_fax);
		$jsConfigTbl->set('contact_email', $vmStoreInfo->contact_email);
		
		
		# Processing logo
		
		# In JShop this is URL of picture, in VMart - stored picture.
		# So I will copy it to JShop path and save URL of it in DB

		switch ($this->storeLogo) {
			case 'full':
				if (!empty($vmStoreInfo->vendor_full_image)) {
					# Get first available filename if file with given filename already exists
					$availFilename = MMLib::getAvailableFileName($this->jsConf->image_vendors_path.DS.
																 $vmStoreInfo->vendor_full_image);

					# File copy
					copy($this->vmImgPath.'vendor'.DS.$vmStoreInfo->vendor_full_image,
						 $this->jsConf->image_vendors_path.DS.$availFilename);
					chmod($this->jsConf->image_vendors_path.DS.$availFilename, 0777);

					$jsConfigTbl->set('store_logo',
									  $this->jsConf->image_vendors_live_path.'/'.$availFilename);
				}
				
				break;
			case 'thumb':
				if (!empty($vmStoreInfo->vendor_thumb_image)) {
					# Get first available filename if file with given filename already exists
					$availFilename = MMLib::getAvailableFileName($this->jsConf->image_vendors_path.DS.
																 vendor_thumb_image);
																 
					# File copy
					copy($this->vmImgPath.'vendor'.DS.$vmStoreInfo->vendor_thumb_image,
						 $this->jsConf->image_vendors_path.DS.$availFilename);
					chmod($this->jsConf->image_vendors_path.DS.$availFilename, 0777);

					$jsConfigTbl->set('store_logo',
									  $this->jsConf->image_vendors_live_path.'/'.$availFilename);
				}
				
				break;
		}
		
		
		$jsConfigTbl->set('store_email', $vmStoreInfo->contact_email);

		$jsConfigTbl->store();
	}

	# Taxes
	function _importTaxes() {
		$query = "SELECT *
				  FROM `#__vm_tax_rate`";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmTaxRate) {
			# DB import
			$jsTaxTbl =& JTable::getInstance('Tax', 'jshop');

			$jsTaxTbl->set('tax_name', $vmTaxRate->tax_country.', '.$vmTaxRate->tax_state);
			$jsTaxTbl->set('tax_value', $vmTaxRate->tax_rate * 100);
			
			$jsTaxTbl->store();
			
			# Save relations between ids
			$this->vmIdXjsId['tax'][$vmTaxRate->tax_rate_id] = $jsTaxTbl->tax_id;
		}
	}

	# User groups
	function _importUserGroups() {
		$query = "SELECT *
				  FROM `#__vm_shopper_group`";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmShopperGroup) {
			# DB import
			$jsUserGroupTbl =& JTable::getInstance('UserGroup', 'jshop');

			$jsUserGroupTbl->set('usergroup_name', $vmShopperGroup->shopper_group_name);
			$jsUserGroupTbl->set('usergroup_discount', $vmShopperGroup->shopper_group_discount);
			$jsUserGroupTbl->set('usergroup_description', $vmShopperGroup->shopper_group_desc);
			$jsUserGroupTbl->set('usergroup_is_default', 0); // Its not default
			
			$jsUserGroupTbl->store();
			
			# Save relations between ids
			$this->vmIdXjsId['usergroup'][$vmShopperGroup->shopper_group_id] = $jsUserGroupTbl->usergroup_id;
		}
	}

	# Users extended data
	function _importUsersExtendedData() {
		$query = "SELECT ui.*, us.shopper_group_id
				  FROM `#__vm_user_info` AS ui
				  LEFT JOIN `#__vm_shopper_vendor_xref` AS us USING (user_id)";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmUserInfo) {
			# Delete extended data for this user
			$query = "DELETE FROM #__jshopping_users
					  WHERE user_id = $vmUserInfo->user_id";

			$this->DB->setQuery($query);
			$this->DB->query();
			
			# DB import
			$jsUserShopTbl =& JTable::getInstance('UserShop', 'jshop');

			$jsUserShopTbl->set('user_id', $vmUserInfo->user_id);
			
			if (!empty($vmUserInfo->shopper_group_id))
				$jsUserShopTbl->set('usergroup_id', $this->vmIdXjsId['usergroup'][$vmUserInfo->shopper_group_id]);
			else
				$jsUserShopTbl->set('usergroup_id', 1); // Default
				
			$jsUserShopTbl->set('f_name', $vmUserInfo->first_name);
			$jsUserShopTbl->set('l_name', $vmUserInfo->last_name);
			$jsUserShopTbl->set('firma_name', $vmUserInfo->company);
			$jsUserShopTbl->set('email', $vmUserInfo->user_email);
			$jsUserShopTbl->set('street', $vmUserInfo->address_1);
			$jsUserShopTbl->set('zip', $vmUserInfo->zip);
			$jsUserShopTbl->set('city', $vmUserInfo->city);
			$jsUserShopTbl->set('state', $vmUserInfo->state);
			
			# Get country ID
			# In VMart field contains code, in JShop - foreign key to countries table record
			$query = "SELECT country_id
					  FROM #__jshopping_countries
					  WHERE country_code = '$vmUserInfo->country' OR country_code_2 = '$vmUserInfo->country'";

			$this->DB->setQuery($query);
			$this->DB->query();
			
			$jsUserShopTbl->set('country', $this->DB->loadResult());

			$jsUserShopTbl->set('phone', $vmUserInfo->phone_1);
			$jsUserShopTbl->set('fax', $vmUserInfo->fax);
			$jsUserShopTbl->set('title', $vmUserInfo->title);
			
			# When we set primary_key standart joomla $tbl->store() method will always make UPDATE
			# and rows will never be inserted. So we should use more low-level code to solve this:
			# $this->DB->insertObject($tbl->getTableName(), $tbl, $tbl->getKeyName());
			$this->DB->insertObject($jsUserShopTbl->getTableName(), $jsUserShopTbl,
									$jsUserShopTbl->getKeyName());
		}
	}

	# Vendors
	function _importVendors() {
		# VMart keep store info in vm_vendor table with vendor_id=1, other records are vendors
		
		$query = "SELECT *
				  FROM `#__vm_vendor`
				  WHERE vendor_id <> 1";

		$this->DB->setQuery($query);
		$this->DB->query();

		foreach ($this->DB->loadObjectList() as $vmVendor) {
			# DB import
			$jsVendorTbl =& JTable::getInstance('Vendor', 'jshop');

			$jsVendorTbl->set('shop_name', $vmVendor->vendor_store_name);
			$jsVendorTbl->set('company_name', $vmVendor->vendor_name);
			$jsVendorTbl->set('url', $vmVendor->vendor_url);
			
			
			# Processing logo
		
			# In JShop this is URL of picture, in VMart - stored picture.
			# So I will copy it to JShop path and save URL of it in DB

			switch ($this->vendorLogo) {
				case 'full':
					if (!empty($vmVendor->vendor_full_image)) {
						# Get first available filename if file with given filename already exists
						$availFilename = MMLib::getAvailableFileName($this->jsConf->image_vendors_path.DS.
																	 $vmVendor->vendor_full_image);
																	 
						# File copy
						copy($this->vmImgPath.'vendor'.DS.$vmVendor->vendor_full_image,
							 $this->jsConf->image_vendors_path.DS.$availFilename);
						chmod($this->jsConf->image_vendors_path.DS.$availFilename, 0777);

						$jsVendorTbl->set('logo', $this->jsConf->image_vendors_live_path.'/'.$availFilename);
					}
					
					break;
				case 'thumb':
					if (!empty($vmVendor->vendor_thumb_image)) {
						# Get first available filename if file with given filename already exists
						$availFilename = MMLib::getAvailableFileName($this->jsConf->image_vendors_path.DS.
																	 $vmVendor->vendor_thumb_image);

						# File copy
						copy($this->vmImgPath.'vendor'.DS.$vmVendor->vendor_thumb_image,
							 $this->jsConf->image_vendors_path.DS.$availFilename);
						chmod($this->jsConf->image_vendors_path.DS.$availFilename, 0777);

						$jsVendorTbl->set('logo', $this->jsConf->image_vendors_live_path.'/'.$availFilename);
					}
					
					break;
			}
			
			
			$jsVendorTbl->set('adress', $vmVendor->vendor_address_1);
			$jsVendorTbl->set('city', $vmVendor->vendor_city);
			$jsVendorTbl->set('zip', $vmVendor->vendor_zip);
			
			# Get state name
			$jsVendorTbl->set('state', $this->_getVMStateName($vmVendor->vendor_country, $vmVendor->vendor_state));
			
			# Get country ID
			$jsVendorTbl->set('country', $this->_getJSCountryID($vmVendor->vendor_country));
			
			$jsVendorTbl->set('f_name', $vmVendor->contact_first_name);
			$jsVendorTbl->set('l_name', $vmVendor->contact_last_name);
			$jsVendorTbl->set('phone', $vmVendor->contact_phone_1);
			$jsVendorTbl->set('fax', $vmVendor->contact_fax);
			$jsVendorTbl->set('email', $vmVendor->contact_email);
			$jsVendorTbl->set('user_id', 0); // None
			
			$jsVendorTbl->store();
			
			# Save relations between ids
			$this->vmIdXjsId['vendor'][$vmVendor->vendor_id] = $jsVendorTbl->id;
		}
	}
	
	# Import
	function _import() {
		# Order of the import:
		# 1. Categories, manufacturers, taxes and vendors
		# 2. Products
		# 3. All other
		
		
		# Categories
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_CATEGORIES);
		$this->_importCategories();
		$this->_printImportingFooter();

		# Manufacturers
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_MANUFACTURERS);
		$this->_importManufacturers();
		$this->_printImportingFooter();
		
		# Taxes
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_TAXES);
		$this->_importTaxes();
		$this->_printImportingFooter();
		
		# Vendors
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_VENDORS);
		$this->_importVendors();
		$this->_printImportingFooter();
		
		# Products
		echo '<br />';
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_PRODUCTS);
		echo '<br />';
		$this->_importProducts();
		$this->_printImportingFooter();
		echo '<br />';
		
		# Products files
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_PRODUCTSFILES);
		$this->_importProductsFiles();
		$this->_printImportingFooter();

		# Products relations
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_PRODUCTSRELATIONS);
		$this->_importProductsRelations();
		$this->_printImportingFooter();

		# Product reviews
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_PRODUCTSREVIEWS);
		$this->_importProductsReviews();
		$this->_printImportingFooter();
		
		# Product shipment prices
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_PRODUCTSSHIPMENTPRICES);
		$this->_importProductsShipmentPrices();
		$this->_printImportingFooter();

		# Products to categories accessory
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_PRODUCTSTOCATEGORIES);
		$this->_importProductsToCategoriesAccessory();
		$this->_printImportingFooter();
		
		# Attributes
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_ATTRIBUTES);
		$this->_importAttributes();
		$this->_printImportingFooter();
		
		# Characteristics
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_CHARACTERISTICS);
		$this->_importCharacteristics();
		$this->_printImportingFooter();
		
		# Coupons
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_COUPONS);
		$this->_importCoupons();
		$this->_printImportingFooter();
		
		# Free attributes
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_FREEATTRIBUTES);
		$this->_importFreeAttributes();
		$this->_printImportingFooter();
		
		# Shipping methods
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_SHIPPINGMETHODS);
		$this->_importShippingMethods();
		$this->_printImportingFooter();
		
		# Store info (if JShop Data delete is checked)
		if ($this->deleteJSData) {
			$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_STOREINFO);
			$this->_importStoreInfo();
			$this->_printImportingFooter();
		}
		
		# User groups
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_USERGROUPS);
		$this->_importUserGroups();
		$this->_printImportingFooter();

		# Users extended data
		$this->_printImportingHeader(_JSHOP_IE_VMIMPORT_USERSEXTENDEDDATA);
		$this->_importUsersExtendedData();
		$this->_printImportingFooter();
	}

	# Start view
	function view() {
		# Don't work in constructor
		$this->loadLanguageFile();
		
		# Checking for JShop is installed
		#(actually not needed, if this script runs - that means JShop installed, but for unification :))
		$JSInstalled = $this->_checkForJS();
		# Checking for VMart is installed
		$VMInstalled = $this->_checkForVM();
		
		# Building page header and controls
		JToolBarHelper::title(_JSHOP_IMPORT. ' "'.$this->ieTbl->get('name').'"', 'generic.png' );
		JToolBarHelper::custom("backtolistie", "back", 'browser.png',
							   _JSHOP_BACK_TO.' "'._JSHOP_PANEL_IMPORT_EXPORT.'"', false );

		# Don't show "Save" button if no VMart present
		if ($VMInstalled && $JSInstalled) {
			JToolBarHelper::spacer();
			JToolBarHelper::save("save", _JSHOP_IMPORT);
		}
		else
			JError::raiseWarning('', '* '._JSHOP_IE_VMIMPORT_NOTINSTALLED_WARNING);
		
		# Generate warning if JShop Data delete is checked
		if ($this->deleteJSData)
			JError::raiseNotice('', '* '._JSHOP_IE_VMIMPORT_DELETEJSDATA_WARNING);
		
		JError::raiseNotice('', '* '._JSHOP_IE_VMIMPORT_CURRENCIES_NOTICE);
		
		
		# Generate choise options
		$choiceOptions = array(
			JHTML::_('select.option', 1, _JSHOP_IE_VMIMPORT_YES),
			JHTML::_('select.option', 0, _JSHOP_IE_VMIMPORT_NO)
		);
		
		
		$JHTMLDeleteJSData = JHTMLSelect::radiolist($choiceOptions, 'delete_js_data', null, 'value', 'text',
													$this->deleteJSData, false);

		$JHTMLMakeSubproductsRelative = JHTMLSelect::radiolist($choiceOptions, 'make_subproducts_relative',
															   null, 'value', 'text',
															   $this->makeSubproductsRelative, false);

		$JHTMLAddAttrsToSubproductTitle = JHTMLSelect::radiolist($choiceOptions,
																 'add_attrs_to_subproduct_title',
																 null, 'value', 'text',
																 $this->addAttrsToSubproductTitle, false);
		
		$JHTMLMakeFreeAttributesRequired = JHTMLSelect::radiolist($choiceOptions,
																  'make_free_attributes_required', null,
																  'value', 'text',
																  $this->makeFreeAttributesRequired, false);
		
		# Generate attributes style options (jshop | vmart)
		$attrStyleOptions = array(
			JHTML::_('select.option', 'jshop', _JSHOP_IE_VMIMPORT_JSHOP),
			JHTML::_('select.option', 'vmart', _JSHOP_IE_VMIMPORT_VMART)
		);
		
		$JHTMLAttrStyle = JHTMLSelect::radiolist($attrStyleOptions, 'attr_style', null, 'value', 'text',
												 $this->attrStyle, false);
		
		
		$JHTMLCharacteristicPrefix = JHTMLSelect::radiolist($choiceOptions, 'characteristic_prefix', null,
															'value', 'text', $this->characteristicPrefix,
															false);
		
		
		# Generate image options (full | thumb)
		$imageOptions = array(
			JHTML::_('select.option', 'full', _JSHOP_IE_VMIMPORT_IMAGEFULL),
			JHTML::_('select.option', 'thumb', _JSHOP_IE_VMIMPORT_IMAGETHUMB)
		);
		

		$JHTMLCatImage = JHTMLSelect::radiolist($imageOptions, 'cat_image', null, 'value', 'text',
												$this->catImage, false);
		
		$JHTMLStoreLogo = JHTMLSelect::radiolist($imageOptions, 'store_logo', null, 'value', 'text',
												 $this->storeLogo, false);
		
		$JHTMLVendorLogo = JHTMLSelect::radiolist($imageOptions, 'vendor_logo', null, 'value', 'text',
												  $this->vendorLogo, false);
		
		$JHTMLResizeImages = JHTMLSelect::radiolist($choiceOptions, 'resize_images', null, 'value', 'text',
													$this->resizeImages, false);
		
		
		$JHTMLAutofillMeta = JHTMLSelect::radiolist($choiceOptions, 'autofill_meta', null, 'value', 'text',
													$this->autofillMeta, false);
		
		$JHTMLGenerateAliases = JHTMLSelect::radiolist($choiceOptions, 'generate_aliases', null, 'value',
													   'text', $this->generateAliases, false);
												  

		# Show start template
		include (dirname(__FILE__).DS.'startpage.php');
	}

	# Here we are after Import button click
	function save() {
		if (isset($_POST['manual_execute'])) {
			# Manual execution
			
			# Don't work in constructor
			$this->loadLanguageFile();
			
			
			# Set settings
			$this->deleteJSData = JRequest::getVar('delete_js_data');
			
			$this->makeSubproductsRelative = JRequest::getVar('make_subproducts_relative');
			$this->addAttrsToSubproductTitle = JRequest::getVar('add_attrs_to_subproduct_title');
			$this->makeFreeAttributesRequired = JRequest::getVar('make_free_attributes_required');
			$this->attrStyle = JRequest::getVar('attr_style');
			$this->characteristicPrefix = JRequest::getVar('characteristic_prefix');
			
			$this->catImage = JRequest::getVar('cat_image');
			$this->storeLogo = JRequest::getVar('store_logo');
			$this->vendorLogo = JRequest::getVar('vendor_logo');
			$this->resizeImages = JRequest::getVar('resize_images');
			
			$this->autofillMeta = JRequest::getVar('autofill_meta');
			$this->generateAliases = JRequest::getVar('generate_aliases');
			

			# Save settings to DB
			$params = parseParamsToArray($this->ieTbl->params); // There can be another params excepting settings
			
			$params['deleteJSData'] = $this->deleteJSData;
			
			$params['makeSubproductsRelative'] = $this->makeSubproductsRelative;
			$params['addAttrsToSubproductTitle'] = $this->addAttrsToSubproductTitle;
			$params['makeFreeAttributesRequired'] = $this->makeFreeAttributesRequired;
			$params['attrStyle'] = $this->attrStyle;
			$params['characteristicPrefix'] = $this->characteristicPrefix;
			
			$params['catImage'] = $this->catImage;
			$params['storeLogo'] = $this->storeLogo;
			$params['vendorLogo'] = $this->vendorLogo;
			$params['resizeImages'] = $this->resizeImages;
			
			$params['autofillMeta'] = $this->autofillMeta;
			$params['generateAliases'] = $this->generateAliases;

			$this->ieTbl->params = parseArrayToParams($params);
			$this->ieTbl->store();
			

			# Output start message
			echo "<font style='font-size: 14px;'>";
			echo _JSHOP_IE_VMIMPORT_STARTED;
			echo "<br />";
			
			# Disable buffering, so we can see progress for each file download
			# (later in each download iteration I made flush)
			ob_end_flush();
			
			
			# Truncate tables if needed
			if ($this->deleteJSData) {
				echo '<br />'._JSHOP_IE_VMIMPORT_DELETINGJSDATA.'... ';
				flush();
				ob_flush();
				$this->_deleteJSData();
				echo '<font color="green">'._JSHOP_IE_VMIMPORT_SUCCEEDED.'</font></b><br><br>';
			}
			
			# Make import
			$this->_import();
			
			
			# Output finish message
			$redirectURL = JRoute::_('index.php?option=com_jshopping&controller=importexport&task=view&ie_id='.
									 $this->ieTbl->id);
			
			echo "<br /><br />";
			echo "<font style='font-size: 14px;'>";
			echo _JSHOP_IE_VMIMPORT_FINISHED;
			echo "<br /><br /><input type='button' onclick='location.href = \"$redirectURL\";'
				 value='"._JSHOP_IE_VMIMPORT_BACKTOIMPORT."' />";
			echo "</font>";
			
			exit;
		}
		else {
			# Automatic execution
			
			# Truncate tables if needed
			if ($this->deleteJSData)
				$this->_deleteJSData();
			
			$this->_import();
			
			# Save last execution time
			$this->ieTbl->set('endstart', time());
			$this->ieTbl->store();
		}
	}
}

?>