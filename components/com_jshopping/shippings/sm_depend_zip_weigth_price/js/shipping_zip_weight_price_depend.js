function addFieldShPriceZipWeightDepend(){    
    shipping_pricedepend_price_zip_weight_num++;
    var html;    
    html = '<tr id="shipping_pricezipweightdepend_price_row_'+shipping_pricedepend_price_zip_weight_num+'">';
    html += '<td><input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_price_from][]" value = "" /></td>';    
    html += '<td><input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_price_to][]" value = "" /></td>';    
    html += '<td><input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_zip_from][]" value = "" /></td>';    
    html += '<td><input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_zip_to][]" value = "" /></td>';
    html += '<td><input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_weight_from][]" value = "" /></td>';
    html += '<td><input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_weight_to][]" value = "" /></td>';
    html += '<td><input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_price][]" value = "" /></td>';
    html += '<td><input type = "text" class = "inputbox" name = "sm_params[shipping_pricezipweight_package_price][]" value = "" /></td>';
    html += '<td style="text-align:center"><a href="#" onclick="delete_shipping_price_zip_weightdepend_price_row('+shipping_pricedepend_price_zip_weight_num+');return false;"><img src="components/com_jshopping/images/publish_r.png" border="0"/></a></td>';    
    html += '</tr>';
    jQuery("#table_shipping_depend_price_zip_weight").append(html);
}
function delete_shipping_price_zip_weightdepend_price_row(num){
    jQuery("#shipping_pricezipweightdepend_price_row_"+num).remove();   
}