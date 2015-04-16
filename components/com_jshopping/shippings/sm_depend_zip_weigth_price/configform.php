<?php JHTML::_('behavior.tooltip');?>
<tr>
    <td><?php print _JSHOP_WEIGHT_MULTIPLY;?></td>
    <td>
        <table>
            <tr><td><input type='checkbox' name="params[weight_multiply]" value='1' <?php if($config['weight_multiply']):?>checked<?php endif;?>></td><td>&nbsp;&nbsp; </td><td><?php print _JSHOP_WEIGHT_MULTIPLY_DELIVERY;?></td></tr>
            <tr><td><input type='checkbox' name="params[weight_multiply_packing]" value='1' <?php if($config['weight_multiply_packing']):?>checked<?php endif;?>></td><td></td><td><?php print _JSHOP_WEIGHT_MULTIPLY_PACKING;?></td></tr>
        </table>
    </td>
</tr>
<tr>
    <td><?php print _JSHOP_WEIGHT_PALLETTITLE;?></td>
    <td>
        <table>
            <tr><td><input type='text' name="params[weight_pallet]" value='<?php echo $config['weight_pallet'];?>' ></td><td></td><td><?php echo JHTML::tooltip(_JSHOP_WEIGHT_PALLET);?></td></tr>
        </table>
    </td>
</tr>