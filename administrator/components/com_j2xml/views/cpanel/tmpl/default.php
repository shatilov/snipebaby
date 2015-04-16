<?php
/**
 * @version		2.5.93 models/cpanel/tmpl/default.php
 * @package		J2XML
 * @subpackage	com_j2xml
 * @since		1.5.3
 *
 * @author		Helios Ciancio <info@eshiol.it>
 * @link		http://www.eshiol.it
 * @copyright	Copyright (C) 2010-2012 Helios Ciancio. All Rights Reserved
 * @license		http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL v3
 * J2XML is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access.');
JHTML::_('behavior.tooltip');
jimport('joomla.language.language');

//require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'version.php');

$data = file_get_contents(JPATH_COMPONENT_ADMINISTRATOR.DS.'j2xml.xml');
$xml = simplexml_load_string($data);
?>
<table width='100%'>
    <tr>
        <td width='55%' class='adminform' valign='top'>
		<div id='cpanel'>
<?php 
		$link = 'index.php?option=com_content';
		$this->_quickiconButton($link, 'icon-48-article.png', JText::_('COM_J2XML_TOOLBAR_ARTICLE_MANAGER'));

		$link = 'index.php?option=com_j2xml&amp;view=websites';
		$this->_quickiconButton($link, 'icon-48-websites.png', JText::_('COM_J2XML_TOOLBAR_WEBSITE_MANAGER'), '../media/com_j2xml/images/');
?>
		</div>
        <div class='clr'></div>
        </td>
		<td valign='top' width='45%' style='padding: 7px 0 0 5px'>
			<?php
			echo $this->pane->startPane('pane');
			
			$title = JText::_('Welcome_to_j2xml');
			echo $this->pane->startPanel($title, 'welcome');

			$exts = array(
					'eshiol Library'=>JPATH_MANIFESTS.DS.'libraries'.DS.'eshiol.xml',
					'J2XML Library'=>JPATH_MANIFESTS.DS.'libraries'.DS.'j2xml.xml',
					'System - J2XML Plugin'=>JPATH_SITE.DS.'plugins'.DS.'system'.DS.'j2xml'.DS.'j2xml.xml',
			);
			jimport('joomla.filesystem.folder');
			jimport('joomla.filesystem.file');

			$file = JPATH_MANIFESTS.DS.'libraries'.DS.'filemanager.xml';
			if (JFile::exists($file)) {
				$xml = JFactory::getXML($file);
				if ($xml) {
					if ($xml->getName() == 'extension')
						$exts = $exts + array((string)$xml->name.' Plugin' => $file);
				}
			}	
			$plugins = JFolder::folders(JPATH_SITE.DS.'plugins'.DS.'j2xml');
			foreach($plugins as $plugin) {
				// Is it a valid Joomla installation manifest file?
				$file = JPATH_SITE.DS.'plugins'.DS.'j2xml'.DS.$plugin.DS.$plugin.'.xml';
				if (!JFile::exists($file)) continue;
				$xml = JFactory::getXML($file);
				if (!$xml) continue;
				if ($xml->getName() != 'extension') continue;
				$exts = $exts + array((string)$xml->name.' Plugin' => $file);
			}
			$lang = JFactory::getLanguage();
			?>
			<table class='adminlist'>
			<tr>
				<td colspan='3'>
					<p><?php echo JText::_('COM_J2XML_DESCRIPTION')?></p>
				</td>
			</tr>
			<tr>
				<td width='25%'>
					<?php echo JText::_('Installed_Version'); ?>
				</td>
				<td width='45%'>
					<?php echo $xml->version; ?>
				</td>
				<td rowspan='<?php echo 3 + count($exts); ?>' style="text-align:center">
					<a href='http://www.eshiol.it/j2xml.html'>
					<img src='../media/com_j2xml/images/j2xml.png' width='110' height='110' alt='j2xml' title='j2xml' align='middle' border='0'>
					</a>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('Copyright'); ?>
				</td>
				<td>
					<a href='http://www.eshiol.it' target='_blank'>
					<?php echo str_replace("(C)", "&copy", $xml->copyright); ?> 
					<img src='../media/com_j2xml/images/eshiol.png' alt='eshiol.it' title='eshiol.it' border='0'></a>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JText::_('License'); ?>
				</td>
				<td>
					<a href='http://www.gnu.org/licenses/gpl-3.0.html' target='_blank'>GNU/GPL v3</a>
				</td>
			</tr>
			<?php foreach ($exts as $k=>$v): ?>
			<tr>
				<td width='25%'>
					<?php echo $k; ?>
				</td>
				<td width='45%'>
				<?php 
					if (JFile::exists($v))
					{
						$data = file_get_contents($v);
						$xml = simplexml_load_string($data);
						if ($xml['type']=='plugin')
						{
							$lang->load('plg_'.$xml['group'].'_'.$xml->files->filename['plugin']);
						}
						echo $xml->version;
					}
					else
					{
						echo JText::_('Not installed');
					}
				?>
				</td>
			</tr>
			<?php endforeach; ?>
			</table>
			<?php
			echo $this->pane->endPanel();

			$title = JText::_('Support_us');
			echo $this->pane->startPanel($title, 'supportus');
			?>
			<table class='adminlist'>
			<tr>
				<td>
					<p><?php echo JText::_('COM_J2XML_MSG_DONATION1'); ?></p>
					<div style="text-align: center;">
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_donations">
							<input type="hidden" name="business" value="info@eshiol.it">
							<input type="hidden" name="lc" value="en_US">
							<input type="hidden" name="item_name" value="eshiol.it">
							<input type="hidden" name="currency_code" value="EUR">
							<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
							<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal secure payments.">
							<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div>
					<p><?php echo JText::_('COM_J2XML_MSG_DONATION2'); ?></p>
				</td>
			</tr>
			</table>
			<?php 
			echo $this->pane->endPanel();
			
			echo $this->pane->endPane();
			?>
		</td>
    </tr>
</table>
<form action="index.php" method="post" name="adminForm">
	<input type="hidden" name="option" value="com_j2xml" />
	<input type="hidden" name="c" value="website" />
	<input type="hidden" name="view" value="cpanel" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_('form.token'); ?>
</form>
