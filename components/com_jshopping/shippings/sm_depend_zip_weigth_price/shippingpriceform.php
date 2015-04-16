<?php
    $row = $template->sh_method_price;

    if (!is_array($params['shipping_pricezipweight_zip_from']))
    { $params['shipping_pricezipweight_zip_from'] = array(); }
?>
<tr><td>&nbsp;</td></tr>
<tr>
  <td class="key" style = "text-align:right; vertical-align:top">
    <b><?php echo _JSHOP_PRICE_DEPENCED_ZIP_WEIGHT0;?></b>
  </td>
  <td>
    <table class="adminlist" id="table_shipping_depend_price_zip_weight">
    <thead>
       <tr>
         <th>
           <?php echo _JSHOP_MINIMAL_ORDER_PRICE0;?> (<?php echo $template->currency->currency_code; ?>)
         </th>
         <th>
           <?php echo _JSHOP_MAXIMAL_ORDER_PRICE0;?> (<?php echo $template->currency->currency_code; ?>)
         </th>
         <th>
           <?php echo _JSHOP_ZIP_FROM0;?>
         </th>
         <th>
           <?php echo _JSHOP_ZIP_TO0;?> 
         </th>
         <th>
           <?php echo _JSHOP_WEIGHT_FROM0;?>
         </th>
         <th>
           <?php echo _JSHOP_WEIGHT_TO0;?> 
         </th>         
         <th>
           <?php echo _JSHOP_PRICE;?> (<?php echo $template->currency->currency_code; ?>)
         </td>
         <th>
           <?php echo _JSHOP_PACKAGE_PRICE;?> (<?php echo $template->currency->currency_code; ?>)
         </th>         
         <th>
           <?php echo _JSHOP_DELETE;?>
         </th>
       </tr>                   
       </thead>
       <?php
       $key = 0;
       if(count($params['shipping_pricezipweight_zip_from']))
       foreach ($params['shipping_pricezipweight_zip_from'] as $key=>$value){?>
       <tr id='shipping_pricezipweightdepend_price_row_<?php print $key?>'>
         <td>
           <input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_price_from][]" value = "<?php echo $params['shipping_pricezipweight_price_from'][$key];?>" />
         </td>
         <td>
           <input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_price_to][]" value = "<?php echo $params['shipping_pricezipweight_price_to'][$key];?>" />
         </td>       
         <td>
           <input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_zip_from][]" value = "<?php echo $params['shipping_pricezipweight_zip_from'][$key];?>" />
         </td>
         <td>
           <input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_zip_to][]" value = "<?php echo $params['shipping_pricezipweight_zip_to'][$key];?>" />
         </td>
         <td>
           <input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_weight_from][]" value = "<?php echo $params['shipping_pricezipweight_weight_from'][$key];?>" />
         </td>
         <td>
           <input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_weight_to][]" value = "<?php echo $params['shipping_pricezipweight_weight_to'][$key];?>" />
         </td>
         <td>
           <input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_price][]" value = "<?php echo $params['shipping_pricezipweight_price'][$key];?>" />
         </td>
         <td>
           <input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_package_price][]" value = "<?php echo $params['shipping_pricezipweight_package_price'][$key];?>" />
         </td>         
         <td style="text-align:center">
            <a href="#" onclick="delete_shipping_price_zip_weightdepend_price_row(<?php print $key?>);return false;"><img src="components/com_jshopping/images/publish_r.png" border="0"/></a>
         </td>
       </tr>
       <?php }?>    
    </table>
    <table class="adminlist"> 
    <tr>
        <td style="padding-top:5px;" align="right"><input type="button" value="<?php echo _JSHOP_ADD_VALUE?>" onclick = "addFieldShPriceZipWeightDepend();"></td>
    </tr>
    </table>
    <script type="text/javascript"> 
        <?php print "var shipping_pricedepend_price_zip_weight_num = $key;";?>
    </script>
</td>
</tr>