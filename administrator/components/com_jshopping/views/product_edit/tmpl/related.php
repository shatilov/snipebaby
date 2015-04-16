<?php
	defined('_JEXEC') or die();
	echo $pane->startPanel(_JSHOP_PRODUCT_RELATED, 'product_related');
?>
   <div class="col100">
    <fieldset class="adminform">
        <legend><?php echo _JSHOP_PRODUCT_RELATED ?></legend>
        <div id="list_related">
        <?php
            foreach($this->related_products as $row_related){
                if (!$row_related->image) $row_related->image = $jshopConfig->noimage;
            ?>      
            <div class="block_related" id="related_product_<?php print $row_related->product_id;?>">
                <div class="block_related_inner">
                    <div class="name"><?php echo $row_related->name;?> (ID:&nbsp;<?php print $row_related->product_id?>)</div>
                    <div class="image"><a href="index.php?option=com_jshopping&controller=products&task=edit&product_id=<?php print $row_related->product_id;?>"><img src="<?php print $jshopConfig->image_product_live_path."/".$row_related->image?>" width="90" border="0" /></a></div>
                    <div style="padding-top:5px;"><input type="button" value="<?php print _JSHOP_DELETE;?>" onclick="delete_related(<?php print $row_related->product_id;?>)"></div>
                    <input type="hidden" name="related_products[]" value="<?php print $row_related->product_id;?>"/>
                </div>
            </div>
            <?php
            }
        ?>
        </div>
    </fieldset>
    </div>
    <div class="clr"></div>
    <?php $pkey = 'plugin_template_related'; if ($this->$pkey){ print $this->$pkey;}?>
   <br/>
   <div class="col100">
    <fieldset class="adminform">
        <legend><?php echo _JSHOP_SEARCH ?></legend>
       <div>
            <input type = "text" size="35" id = "related_search" value = "" />
            &nbsp;
            <input type = "button" class = "button" value = "<?php echo _JSHOP_SEARCH;?>" onclick="releted_product_search(0, '<?php echo $row->product_id?>');" />
        </div>
        <br/>
        <div id="list_for_select_related"></div>
    </fieldset>
    </div>
    <div class="clr"></div>
<?php
  echo $pane->endPanel();
?>