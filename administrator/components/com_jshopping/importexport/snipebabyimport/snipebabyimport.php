<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.filesystem.folder');

class IeSnipeBabyImport extends IeController{
    
    function view(){
        $jshopConfig = JSFactory::getConfig();
        $ie_id = JRequest::getInt("ie_id");
        $_importexport = JTable::getInstance('ImportExport', 'jshop'); 
        $_importexport->load($ie_id);
        $name = $_importexport->get('name');                        
            
        JToolBarHelper::title(_JSHOP_IMPORT. ' "'.$name.'"', 'generic.png' ); 
        JToolBarHelper::custom("backtolistie", "back", 'browser.png', _JSHOP_BACK_TO.' "'._JSHOP_PANEL_IMPORT_EXPORT.'"', false );        
        JToolBarHelper::spacer();
        JToolBarHelper::save("save", _JSHOP_IMPORT);    
        
        include(dirname(__FILE__)."/form.php");  
    }

    function save(){
        $mainframe = JFactory::getApplication();
        $jshopConfig = JSFactory::getConfig();
        require_once(JPATH_COMPONENT_SITE.'/lib/uploadfile.class.php');
        require_once(JPATH_COMPONENT_SITE."/lib/csv.io.class.php");
        
        $ie_id = JRequest::getInt("ie_id");
		$unpublic_products = JRequest::getBool("unpublic_products");

        if (!$ie_id) $ie_id = $this->get('ie_id');
        
        $lang = JSFactory::getLang();
        $db = JFactory::getDBO();

        $_importexport = JTable::getInstance('ImportExport', 'jshop'); 
        $_importexport->load($ie_id);
        $alias = $_importexport->get('alias');
        $_importexport->set('endstart', time());
        $_importexport->store();

		/*
        //get list tax
        $query = "SELECT tax_id, tax_value FROM `#__jshopping_taxes`";
        $db->setQuery($query);        
        $rows = $db->loadObjectList();
        $listTax = array();
        foreach($rows as $row){
            $listTax[intval($row->tax_value)] = $row->tax_id;
        }


        //get list category
        $query = "SELECT category_id as id, `".$lang->get("name")."` as name FROM `#__jshopping_categories`";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $listCat = array();
        foreach($rows as $row){
            $listCat[$row->name] = $row->id;
        }


        $_products = JModel::getInstance('products', 'JshoppingModel');                
        */

        $dir = $jshopConfig->importexport_path.$alias."/";
        
        $upload = new UploadFile($_FILES['file']);
        $upload->setAllowFile(array('csv'));
        $upload->setDir($dir);
        if ($upload->upload()){
            $filename = $dir."/".$upload->getName();
            @chmod($filename, 0777);
            $csv = new csv();
            $data = $csv->read($filename);
            if (is_array($data)){

				if($unpublic_products)
				{
					$query = "UPDATE `#__jshopping_products` set product_price = '0'";
					$db->setQuery($query);
					$db->loadResult();
				}

                foreach($data as $k=>$csvrow)
                {
                    $query = "SELECT product_id as product_id FROM `#__jshopping_products` where product_ean = '".str_replace(' ','',$csvrow[0])."'";
                    $db->setQuery($query);
                    $rows = $db->loadObjectList();
					if(count($rows) > 0)
					{
						foreach($rows as  $row)
						{

							$query = "UPDATE `#__jshopping_products` set product_price = '".$csvrow[1]."' WHERE product_id = ".$row->product_id;
							$db->setQuery($query);
							$db->loadResult();

							$query = "UPDATE `#__jshopping_products` set product_publish = 1 WHERE product_id = ".$row->product_id;
							$db->setQuery($query);
							$db->loadResult();

						}
					}
					else
					{
						echo $csvrow[0].'<br>';
					}
                    unset($product);
                }

				if($unpublic_products)
				{
					$query = "UPDATE `#__jshopping_products` set product_publish = 0 where product_price = 0";
					$db->setQuery($query);
					$db->loadResult();
				}
            }
            @unlink($filename);
        }else{            
            JError::raiseWarning("", _JSHOP_ERROR_UPLOADING);
        }
                
        if (!JRequest::getInt("noredirect")){
            $mainframe->redirect("index.php?option=com_jshopping&controller=importexport&task=view&ie_id=".$ie_id, _JSHOP_COMPLETED);
        }
    }
    
}
?>