<?php
/**
 * @package			"VirtueMart Importer Addon for JoomShopping"
 * @version			1.5 [2011-09-06]
 * @compatibility	PHP 5.2/5.3, Joomla 1.5, JoomShopping 2.9.6, VirtueMart 1.1.9
 * @author			Vova Olar vovaolar@gmail.com
 * @copyright		Copyright (C) 2010-2011 Vova Olar - All rights reserved.
 * @license			GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die('Direct access is not allowed.');

define('_JSHOP_IE_VMIMPORT_SEARCHING_FOR_JSHOP', 'Searching for JoomShopping');
define('_JSHOP_IE_VMIMPORT_SEARCHING_FOR_VMART', 'Searching for VirtueMart');
define('_JSHOP_IE_VMIMPORT_JSHOP', 'JoomShopping');
define('_JSHOP_IE_VMIMPORT_VMART', 'VirtueMart');
define('_JSHOP_IE_VMIMPORT_SETTINGS', 'Settings');
define('_JSHOP_IE_VMIMPORT_NOTINSTALLED_WARNING', 'JoomShopping and VirtueMart should be installed!');
define('_JSHOP_IE_VMIMPORT_DELETEJSDATA_WARNING', 'Involved JoomShopping database tables will be truncated before the import, files (images, videos...) will be deleted! Uncheck option if you do not want this.');
define('_JSHOP_IE_VMIMPORT_CURRENCIES_NOTICE', 'If You are using a different currencies in VirtueMart, for correct conversion of prices on import, You must first create and configure currencies in JoomShopping (with appropriate codes).');
define('_JSHOP_IE_VMIMPORT_YES', 'Yes');
define('_JSHOP_IE_VMIMPORT_NO', 'No');

define('_JSHOP_IE_VMIMPORT_DELETEJSDATA', 'Delete JoomShopping data before import?');
define('_JSHOP_IE_VMIMPORT_MAKESUBPRODUCTSRELATIVE', 'Make VirtueMart product items relative?');
define('_JSHOP_IE_VMIMPORT_MAKESUBPRODUCTSRELATIVE_NOTICE', 'JoomShopping don\'t support product items (but supports relations between products). Enable this option to make subproducts relative to parent.');
define('_JSHOP_IE_VMIMPORT_ADDATTRSTOSUBPRODUCTTITLE', 'Add VirtueMart product item attributes to JoomShopping product title?');
define('_JSHOP_IE_VMIMPORT_ADDATTRSTOSUBPRODUCTTITLE_NOTICE', 'JoomShopping don\'t support product items attributes. Enable this option to add attributes to JoomShopping product title.');
define('_JSHOP_IE_VMIMPORT_MAKEFREEATTRIBUTESREQUIRED', 'Make custom attributes required?');
define('_JSHOP_IE_VMIMPORT_MAKEFREEATTRIBUTESREQUIRED_NOTICE', 'Select \'Yes\' to make all imported custom attributes required, or \'No\' to leave all of them required to fill by client. In VirtueMart custom attributes are set in concrete product, therefore they are required to fill by user (if You don\'t need them - You don\'t set them in product). In JoomShopping You can just select in product use attribute or not, they are common for all products, so each custom attribute (local name - free attribute) can be required or not.');
define('_JSHOP_IE_VMIMPORT_ATTRSTYLE', 'Advanced attributes declaration style');
define('_JSHOP_IE_VMIMPORT_ATTRSTYLE_NOTICE', 'JoomShopping supports 2 styles of attribute declaration: same as in VirtueMart and depentent style.');
define('_JSHOP_IE_VMIMPORT_CHARACTERISTICPREFIX', 'Prefix imported parameter label with product type name?');
define('_JSHOP_IE_VMIMPORT_CHARACTERISTICPREFIX_NOTICE', 'JoomShopping do not support grouping parameters to product type, so You can add prefix to know to which product type belongs this parameter.');
define('_JSHOP_IE_VMIMPORT_IMAGEFULL', 'Full');
define('_JSHOP_IE_VMIMPORT_IMAGETHUMB', 'Thumb');
define('_JSHOP_IE_VMIMPORT_CATIMAGE', 'Which VirtueMart category image to import?');
define('_JSHOP_IE_VMIMPORT_STORELOGO', 'Which VirtueMart store logo to import?');
define('_JSHOP_IE_VMIMPORT_VENDORLOGO', 'Which VirtueMart vendor logo to import?');
define('_JSHOP_IE_VMIMPORT_RESIZEIMAGES', 'Resize images to JoomShopping config dimensions?');
define('_JSHOP_IE_VMIMPORT_AUTOFILLMETA', 'Auto fill META tags?');
define('_JSHOP_IE_VMIMPORT_GENERATEALIASES', 'Generate aliases from title?');

define('_JSHOP_IE_VMIMPORT_STARTED', 'Import started');
define('_JSHOP_IE_VMIMPORT_DELETINGJSDATA', 'Deleting JoomShopping data');
define('_JSHOP_IE_VMIMPORT_IMPORTING', 'Importing');
define('_JSHOP_IE_VMIMPORT_SUCCEEDED', 'OK');
define('_JSHOP_IE_VMIMPORT_FAILED', 'FAILED');

define('_JSHOP_IE_VMIMPORT_ATTRIBUTES', 'Advanced attributes');
define('_JSHOP_IE_VMIMPORT_CATEGORIES', 'Categories');
define('_JSHOP_IE_VMIMPORT_CHARACTERISTICS', 'Types parameters');
define('_JSHOP_IE_VMIMPORT_COUPONS', 'Coupons');
define('_JSHOP_IE_VMIMPORT_FREEATTRIBUTES', 'Custom attributes');
define('_JSHOP_IE_VMIMPORT_MANUFACTURERS', 'Manufacturers');
define('_JSHOP_IE_VMIMPORT_PRODUCTS', 'Products');
define('_JSHOP_IE_VMIMPORT_PRODUCTSFILES', 'Products files');
define('_JSHOP_IE_VMIMPORT_PRODUCTSRELATIONS', 'Products relations');
define('_JSHOP_IE_VMIMPORT_PRODUCTSREVIEWS', 'Products reviews');
define('_JSHOP_IE_VMIMPORT_PRODUCTSSHIPMENTPRICES', 'Products shipment prices');
define('_JSHOP_IE_VMIMPORT_PRODUCTSTOCATEGORIES', 'Products to categories accessory');
define('_JSHOP_IE_VMIMPORT_SHIPPINGMETHODS', 'Shipping methods');
define('_JSHOP_IE_VMIMPORT_STOREINFO', 'Store info');
define('_JSHOP_IE_VMIMPORT_TAXES', 'Taxes');
define('_JSHOP_IE_VMIMPORT_USERGROUPS', 'User groups');
define('_JSHOP_IE_VMIMPORT_USERSEXTENDEDDATA', 'Users extended data');
define('_JSHOP_IE_VMIMPORT_VENDORS', 'Vendors');

define('_JSHOP_IE_VMIMPORT_FINISHED', 'Import finished');
define('_JSHOP_IE_VMIMPORT_BACKTOIMPORT', 'Back to VirtueMart Import for JoomShopping page');
?>