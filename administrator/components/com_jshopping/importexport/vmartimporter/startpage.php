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
?>

<form action="index.php?option=com_jshopping&controller=importexport" method="post" name="adminForm">
 <input type="hidden" name="task" value="" />
 <input type="hidden" name="hidemainmenu" value="0" />
 <input type="hidden" name="boxchecked" value="0" />
 <input type="hidden" name="ie_id" value="<?php echo $this->ieTbl->id; ?>" />
 <input type="hidden" name="manual_execute" value='1' />
 
 <?php echo _JSHOP_IE_VMIMPORT_SEARCHING_FOR_JSHOP; ?>...
 <b>

<?php
if ($JSInstalled) {
?>
  <font color="green"><?php echo _JSHOP_IE_VMIMPORT_SUCCEEDED; ?></font>
<?php
}
else {
?>
  <font color="red"><?php echo _JSHOP_IE_VMIMPORT_FAILED; ?></font>
<?php
}
?>
 </b>
 
 <br />
 
  <?php echo _JSHOP_IE_VMIMPORT_SEARCHING_FOR_VMART; ?>...
 <b>

<?php
if ($VMInstalled) {
?>
  <font color="green"><?php echo _JSHOP_IE_VMIMPORT_SUCCEEDED; ?></font>
<?php
}
else {
?>
  <font color="red"><?php echo _JSHOP_IE_VMIMPORT_FAILED; ?></font>
<?php
}
?>
 </b>
 
 <br /><br />
 
 <fieldset>
  <legend><?php echo _JSHOP_IE_VMIMPORT_SETTINGS; ?></legend>
  
  <table class="admintable">
   <tr>
	<td class="key" style="width: 300px !important;">
	 <label for="delete_js_data"><?php echo _JSHOP_IE_VMIMPORT_DELETEJSDATA; ?></label>
	</td>
	<td>
	 <?php echo $JHTMLDeleteJSData; ?>
	</td>
   </tr>
   
   <tr><td colspan="2">&nbsp;</td></tr>
   
   <tr>
	<td class="key">
	 <label for="make_subproducts_relative"><?php echo _JSHOP_IE_VMIMPORT_MAKESUBPRODUCTSRELATIVE; ?></label>
	 <?php echo JHTML::tooltip(_JSHOP_IE_VMIMPORT_MAKESUBPRODUCTSRELATIVE_NOTICE)?>
	</td>
	<td>
	 <?php echo $JHTMLMakeSubproductsRelative; ?>
	</td>
   </tr>
   <tr>
	<td class="key">
	 <label for="add_attrs_to_subproduct_title"><?php echo _JSHOP_IE_VMIMPORT_ADDATTRSTOSUBPRODUCTTITLE; ?></label>
	 <?php echo JHTML::tooltip(JSHOP_IE_VMIMPORT_ADDATTRSTOSUBPRODUCTTITLE_NOTICE)?>
	</td>
	<td>
	 <?php echo $JHTMLAddAttrsToSubproductTitle; ?>
	</td>
   </tr>
   <tr>
	<td class="key">
	 <label for="make_free_attributes_required"><?php echo _JSHOP_IE_VMIMPORT_MAKEFREEATTRIBUTESREQUIRED; ?></label>
	 <?php echo JHTML::tooltip(_JSHOP_IE_VMIMPORT_MAKEFREEATTRIBUTESREQUIRED_NOTICE)?>
	</td>
	<td>
	 <?php echo $JHTMLMakeFreeAttributesRequired; ?>
	</td>
   </tr>
   <tr>
	<td class="key">
	 <label for="attr_style"><?php echo _JSHOP_IE_VMIMPORT_ATTRSTYLE; ?></label>:
	 <?php echo JHTML::tooltip(_JSHOP_IE_VMIMPORT_ATTRSTYLE_NOTICE)?>
	</td>
	<td>
	 <?php echo $JHTMLAttrStyle; ?>
	</td>
   </tr>
   <tr>
	<td class="key">
	 <label for="characteristic_prefix"><?php echo _JSHOP_IE_VMIMPORT_CHARACTERISTICPREFIX; ?></label>
	 <?php echo JHTML::tooltip(_JSHOP_IE_VMIMPORT_CHARACTERISTICPREFIX_NOTICE)?>
	</td>
	<td>
	 <?php echo $JHTMLCharacteristicPrefix; ?>
	</td>
   </tr>
   
   <tr><td colspan="2">&nbsp;</td></tr>
   
   <tr>
	<td class="key">
	 <label for="cat_image"><?php echo _JSHOP_IE_VMIMPORT_CATIMAGE; ?></label>
	</td>
	<td>
	 <?php echo $JHTMLCatImage; ?>
	</td>
   </tr>
   <tr>
	<td class="key">
	 <label for="store_logo"><?php echo _JSHOP_IE_VMIMPORT_STORELOGO; ?></label>
	</td>
	<td>
	 <?php echo $JHTMLStoreLogo; ?>
	</td>
   </tr>
   <tr>
	<td class="key">
	 <label for="vendor_logo"><?php echo _JSHOP_IE_VMIMPORT_VENDORLOGO; ?></label>
	</td>
	<td>
	 <?php echo $JHTMLVendorLogo; ?>
	</td>
   </tr>
   <tr>
	<td class="key">
	 <label for="resize_images"><?php echo _JSHOP_IE_VMIMPORT_RESIZEIMAGES; ?></label>
	</td>
	<td>
	 <?php echo $JHTMLResizeImages; ?>
	</td>
   </tr>
   
   <tr><td colspan="2">&nbsp;</td></tr>
   
   <tr>
	<td class="key">
	 <label for="autofill_meta"><?php echo _JSHOP_IE_VMIMPORT_AUTOFILLMETA; ?></label>
	</td>
	<td>
	 <?php echo $JHTMLAutofillMeta; ?>
	</td>
   </tr>
   <tr>
	<td class="key">
	 <label for="generate_aliases"><?php echo _JSHOP_IE_VMIMPORT_GENERATEALIASES; ?></label>
	</td>
	<td>
	 <?php echo $JHTMLGenerateAliases; ?>
	</td>
   </tr>
   
   <tr><td colspan="2">&nbsp;</td></tr>
  </table>
  
 </fieldset>
</form>
