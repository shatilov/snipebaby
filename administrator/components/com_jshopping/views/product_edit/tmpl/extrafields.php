<?php
	defined('_JEXEC') or die();
	echo $pane->startPanel(_JSHOP_EXTRA_FIELDS, 'product_extra_fields');
?>
    <div class="col100" id="extra_fields_space">
    <?php print $this->tmpl_extra_fields;?>
    <?php $pkey = 'plugin_template_extrafields'; if ($this->$pkey){ print $this->$pkey;}?>
    </div>
    <div class="clr"></div>
<?php
   echo $pane->endPanel();
?>