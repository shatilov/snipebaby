<?php

/**
 * NOTES:
 * - this plugin works only for .html SEF urls
 * - works best if all site structure (categories and article pages) created by menu
 * - category structure aliases must repeat menu structure aliases
 * - canonical url used from menu if exists, else by category/article aliases
 * - execute ALTER TABLE `#__menu` ADD INDEX (`link`); ???
 * - for category pages use menu
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');

// from https://github.com/rivetweb/urlvalidator
require_once JPATH_ROOT . '/app/lib/urlvalidator/init.php';

class plgSystemUrlvalidator extends JPlugin {

	private $menuTypes;
	private $pageExtension;

	function __construct(&$subject, $config) {
		parent::__construct($subject, $config);

		$this->menuTypes = array(
			'mainmenu',
			'mainmenuru',
			'hiddenru'
		);
	}

	public function error404() {
		JError::raiseError(404, JText::_('Page Not Found'));
	}

	private function addCanonical($path) {
		// TODO remove other canonical
		JFactory::getDocument()->addHeadLink(
				'http://' . $_SERVER['SERVER_NAME'] . '/' .
				$path . '.' . $this->pageExtension, 'canonical', 'rel', '');
	}

	private function checkMenuItem($path) {
		$db = JFactory::getDBO();

		$tmp = array();
		foreach ($this->menuTypes as $menu) {
			$tmp[] = 'menutype = ' . $db->quote($menu);
		}
		$db->setQuery('select id from #__menu where ' .
				'path = ' . $db->quote($path) . ' and (' . implode(' or ', $tmp) . ') and published = 1');
		$row = $db->loadObject();
		if ($row) {
			$this->addCanonical($path);
		}

		return $row;
	}

	private function checkAlias($path, $fname) {
		// check component SEF url if method defined
		$checkerName = 'check_' . JRequest::getVar('option');
		return method_exists($this, $checkerName) ? $this->$checkerName($path, $fname) : true;
	}

	public function validate($currentUrl) {
		$tmp = explode('/', $currentUrl['path']);

		$p = pathinfo($currentUrl['path']);
		if (!empty($p['extension'])) {
			$this->error404();
			//if (!in_array($p['extension'], array('html')) || substr($currentUrl['path'], -1) == '/') {
			//	$this->error404();
			//}
		}
		else if (substr($_SERVER['REQUEST_URI']/* $currentUrl['path'] */, -1) == '/') {
			$this->error404();
		}
	}

	function onAfterInitialise() {
		$app = JFactory::getApplication();
		if ($app->isAdmin()) {
			return;
		}

		validate_urls(array(
			'error_callback' => array($this, 'error404'),
			'validate_callback' => array($this, 'validate'),
			'ignored' => array(
				'/index.php?option=com_foxcontact',
				'/index.php?option=com_xmap',
				'/index.php?option=com_custom',
				//'/index.php?option=com_aicontactsafe',
				'/index.php?option=com_users',
				'/component/search'
			),
			'error404' => array(
				'/index.php',
				'/home',
			),
			'extensions' => array(
			//'.html', '.feed'
			),
			'check_slash' => false
		));
	}

	function onAfterDispatch() {
		$app = JFactory::getApplication();
		if ($app->isAdmin()) {
			return;
		}

		return;

		if (!$this->checkMenuItem($path)) {
			if (!$this->checkAlias($path, $p['filename'])) {
				$this->error404();
			}
		}

		return true;
	}

	private function check_com_content($path, $fname) {
		$db = JFactory::getDBO();
		$id = JRequest::getInt('id');
		$result = false;

		switch (JRequest::getCmd('view')) {
			case 'article':
				$db->setQuery('select a.id, concat(c.path, "/", a.id, "-", a.alias) as path from #__content as a '
						. 'left join #__categories as c on a.catid = c.id '
						. 'where a.id = ' . $id . ' and (a.state = 1 or a.state = 2)');
				$row = $db->loadObject();
				$result = $row && $row->path == $path;
				if ($result) {
					$db->setQuery('select * from #__menu where link = ' .
							$db->quote('index.php?option=com_content&view=article&id=' . $row->id) .
							' and published = 1');
					$row = $db->loadObject();
					if ($row) {
						$result = false;
						//$this->addCanonical($row->path);
					}
					else {
						$this->addCanonical($path);
					}
				}
				break;

			case 'category':
				// TODO check cateory
				// TODO set cannonical link
				/*
				  $query = 'select c.path, c.alias from #__categories as c '
				  . 'where id = ' . $id;
				  if ($row) {
				  print '<pre>';
				  var_dump($query);
				  var_dump($row, $path, $fname);
				  print '</pre>';
				  } */
				break;
		}

		return $result;
	}

	// check SEF url for com_jshopping component
	private function check_com_jshopping($path, $fname) {
		if (JRequest::getVar('task') != 'view') {
			return false;
		}

		$pathElements = explode('/', $path);
		switch (JRequest::getVar('controller')) {
			case 'category':
				if (count($pathElements) != 4 || !ctype_digit($pathElements[3])) {
					return false;
				}
				break;

			case 'product':
				if (count($pathElements) != 5 ||
						!ctype_digit($pathElements[3]) || !ctype_digit($pathElements[4])) {
					return false;
				}
				break;
		}

		return true;
	}

}
