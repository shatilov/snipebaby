<?php
$joomlaLangs = getAllLanguages();
$db = JFactory::getDBO();

foreach($joomlaLangs as $lang){
    $query = "alter table #__jshopping_product_labels add column `name_".$lang->language."` varchar(255) NOT NULL;";
    $db->setQuery($query);
    $db->query();
}

foreach($joomlaLangs as $lang){
    $query = "update #__jshopping_product_labels set `name_".$lang->language."`=name";
    $db->setQuery($query);
    $db->query();
}

?>