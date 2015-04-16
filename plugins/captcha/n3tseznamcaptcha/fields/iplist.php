<?php
/**
 * @package n3tSeznamCaptcha
 * @author Pavel Poles - n3t.cz
 * @copyright (C) 2012-2014 - Pavel Poles - n3t.cz
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

JFormHelper::loadFieldClass('textarea');

class JFormFieldIPList extends JFormFieldTextarea
{

	protected $type = 'IPList';

	protected function getInput()
	{
    $button = '<br />';
    $onclick = '$(\'jform_params_'.$this->element['name'].'\').set(\'value\',$(\'jform_params_'.$this->element['name'].'\').get(\'value\')+($(\'jform_params_'.$this->element['name'].'\').get(\'value\') ? \'\n\' : \'\')+\''.$_SERVER['REMOTE_ADDR'].'\'); return false;';
    $button.= '<button class="btn" onclick="'.$onclick.'" href="#">'.JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_CFG_IP_FILTER_ADD_CURRENT').'</button>';
    $onclick = '$(\'jform_params_'.$this->element['name'].'\').set(\'value\',\'\'); return false;';
    $button.= ' <button class="btn" onclick="'.$onclick.'" href="#">'.JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_CFG_IP_FILTER_CLEAR').'</button>';
    return parent::getInput().$button;
	}
}
