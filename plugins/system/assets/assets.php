<?php

defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');

// from https://github.com/rivetweb/assets
//require_once JPATH_ROOT . '/app/lib/assets/init.php';

class plgSystemAssets extends JPlugin {

	function __construct(&$subject, $config) {
		parent::__construct($subject, $config);
	}

	function onAfterRender() {
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		if ($app->isAdmin() || $doc->getType() != 'html') {
			return;
		}

//		$filter = new AssetsBuilderFilter();
//		$filter2 = new HideExternalsFilter(array(
//			'hide_link' => 'hideexternals_hideLink'
//		));
//		JResponse::setBody(
//				$filter2->process(
//						$filter->process(JResponse::getBody()
//						)
//		));
	}

}
