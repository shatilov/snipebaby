<?php
/**
 * @package n3tSeznamCaptcha
 * @author Pavel Poles - n3t.cz
 * @copyright (C) 2012-2014 - Pavel Poles - n3t.cz
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

JFormHelper::loadFieldClass('radio');

class JFormFieldRadioSwitch extends JFormFieldRadio
{

	protected $type = 'RadioSwitch';

	protected function getInput()
	{
    $more='';
    if ($this->element['more']) {
      $more.= '<div style="clear: both;">';
      $more.= '<a href="'.$this->element['more'].'" target="_blank">'.JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_CFG_MORE_INFORMATION').'</a>';
      $more.= '</div>';
    }
    return parent::getInput();
    return preg_replace('~</fieldset>~',$more.'</fieldset>',parent::getInput());
	}

  protected function getOptions()
  {
    $tmp = array(
      JHtml::_('select.option', '0', JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_CFG_FALSE'), 'value', 'text'),
      JHtml::_('select.option', '1', JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_CFG_TRUE'), 'value', 'text')
    );
    return array_merge($tmp,parent::getOptions());
  }

  protected function getLabel()
  {
    $more='';
    if ($this->element['more']) {
      $more.= '<a href="'.$this->element['more'].'" target="_blank">'.JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_CFG_MORE_INFORMATION').'</a>';
    }
    return preg_replace('~</label>~','<br />'.$more.'</label>',parent::getLabel());
  }

}
