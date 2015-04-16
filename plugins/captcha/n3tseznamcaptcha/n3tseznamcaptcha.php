<?php
/**
 * @package n3tSeznamCaptcha
 * @author Pavel Poles - n3t.cz
 * @copyright (C) 2012-2014 - Pavel Poles - n3t.cz
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgCaptchaN3tSeznamCaptcha extends JPlugin
{

	public function __construct($subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}
  
	public function onInit($id)
	{
    if (!$this->params->def('enable_captcha', 1)) return;

		$doc = JFactory::getDocument();
    if ($this->params->def('theme', 'dark-icons'))
      JHtml::stylesheet('plg_n3tseznamcaptcha/'.$this->params->def('theme', 'dark-icons').'.css', false, true);
    JHtml::script('plg_n3tseznamcaptcha/captcha.js', true, true);
		$doc->addScriptDeclaration("
      window.addEvent('domready', function() {
        new n3tSeznamCaptcha({
          'url': '".JURI::root(true)."',
          'audio': ".( $this->params->def('show_audio', 1) ? "true" : "false" ).",
          'loading': ".( $this->params->def('show_loading', 0) ? "true" : "false" )."
        });
      });"
		);

    JText::script('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_CAPTCHA',true);
    JText::script('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_RELOAD',true);
    JText::script('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_RELOAD_TITLE',true);
    JText::script('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_AUDIO',true);
    JText::script('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_AUDIO_TITLE',true);

    if( !ini_get('allow_url_fopen') && (!extension_loaded('curl') || !function_exists('curl_exec') ) ) {
      throw new Exception(JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_NO_DOWNLOAD_SUPPORT'));
    }
  }

	public function onDisplay($name, $id, $class)
	{
    if (!$this->params->def('enable_captcha', 1)) return;

    return '<div class="seznam-captcha'.($this->params->def('show_loading', 0) ? ' loading' : '').'"></div>';
	}

	public function onCheckAnswer($code)
	{
    if ($this->params->def('enable_captcha', 1))
    {
      jimport( 'joomla.filter.input' );
      $requestData = JRequest::getVar('jform', array(), 'post', 'array');
  		$hash	= JFilterInput::getInstance()->clean($requestData['captcha_hash'], 'cmd');
  		$answer	= JFilterInput::getInstance()->clean($requestData['captcha'], 'cmd');

  		if ($hash == null || strlen($hash) == 0 || $answer == null || strlen($answer) == 0)
  		{
  			$this->_subject->setError(JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_EMPTY_ANSWER'));
  			return false;
  		}
      if (!$this->_checkAnswer($hash, $answer)) {
  		  $this->_subject->setError(JText::_('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_WRONG_ANSWER'));
  		  return false;
      }
    }

    $check = array();
    if (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',$_SERVER['REMOTE_ADDR'])) {
      $check['ip'] = $_SERVER['REMOTE_ADDR'];
      $check['reverseip'] = implode('.',array_reverse(explode('.',$_SERVER['REMOTE_ADDR'])));
    } else {
      $check['ip'] = false;
      $check['reverseip'] = false;
    }

    $ip_whitelist = preg_split('/\s*\n\s*/', $this->params->def('ip_whitelist', ''));
    if (array_search($check['ip'], $ip_whitelist) !== false) {
      return true;
    }

    $ip_blacklist = preg_split('/\s*\n\s*/', $this->params->def('ip_blacklist', ''));
    if (array_search($check['ip'], $ip_blacklist) !== false) {
		  $this->_subject->setError(JText::sprintf('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_BLACKLIST',$check['ip']));
		  return false;
    }

    if ($this->params->def('check_stopforumspam', '0') && !$this->_checkStopForumSpam($check)) {
		  $this->_subject->setError(JText::sprintf('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_BLACKLIST',$check['ip']));
		  return false;
    }

    if ($this->params->def('check_spambusted', '0') && !$this->_checkSpamBusted($check)) {
		  $this->_subject->setError(JText::sprintf('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_BLACKLIST',$check['ip']));
		  return false;
    }

    if ($this->params->def('check_botscout', '0') && !$this->_checkBotScout($check)) {
		  $this->_subject->setError(JText::sprintf('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_BLACKLIST',$check['ip']));
		  return false;
    }

    if ($this->params->def('check_spamhaus', '0') && !$this->_checkSpamHaus($check)) {
		  $this->_subject->setError(JText::sprintf('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_BLACKLIST',$check['ip']));
		  return false;
    }

    if ($this->params->def('check_sorbs', '0') && !$this->_checkSorbs($check)) {
		  $this->_subject->setError(JText::sprintf('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_BLACKLIST',$check['ip']));
		  return false;
    }

    if ($this->params->def('check_spamcop', '0') && !$this->_checkSpamCop($check)) {
		  $this->_subject->setError(JText::sprintf('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_BLACKLIST',$check['ip']));
		  return false;
    }

    if ($this->params->def('check_honeypot', '0') && !$this->_checkHoneyPot($check)) {
		  $this->_subject->setError(JText::sprintf('PLG_CAPTCHA_N3TSEZNAMCAPTCHA_BLACKLIST',$check['ip']));
		  return false;
    }

    return true;
  }

  private function _checkAnswer($hash, $answer)
  {
    $url = 'http://captcha.seznam.cz/captcha.check?hash='.$hash.'&code='.$answer;
    if (extension_loaded('curl') && function_exists('curl_exec')) {
      $c = curl_init();
      curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($c, CURLOPT_URL, $url);
      curl_exec($c);
      $info = curl_getinfo($c);
      curl_close($c);
      return $info['http_code'] == 200;
    } else if (ini_get('allow_url_fopen')) {
      $headers = get_headers($url);
      if (is_array($headers)
      && isset($headers[0])
      && strpos($headers[0],'200'))
        return true;
    }
    return false;
  }

  private function _getUrl($url)
  {
    $response = '';
    if (extension_loaded('curl') && function_exists('curl_exec')) {
      $c = curl_init();
			curl_setopt($c, CURLOPT_URL, $url);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c, CURLOPT_HEADER, 0);
			$response = @curl_exec($c);
			curl_close($c);
    } else if (function_exists('file_get_contents') && ini_get('allow_url_fopen')) {
      $response = @file_get_contents($url);
    }
    return $response;
  }

  private function _checkStopForumSpam($data)
  {
    if ($data['ip']) {
      $address = 'http://www.stopforumspam.com/api?f=serial&ip='.$data['ip'];
      $response = $this->_getUrl($address);
      if ($response) {
        $response = unserialize($response);
        if ($response['success'] && $response['ip']['appears']) return true;
      }
    }
    return true;
  }

  private function _checkSorbs($data)
  {
    if ($data['reverseip']) {
      $address = $data['reverseip'].'.l2.spews.dnsbl.sorbs.net.';
      $response = @gethostbyname($address);
      if ($response != $address) return false;

      $address = $data['reverseip'].'.problems.dnsbl.sorbs.net.';
      $response = @gethostbyname($address);
      if ($response != $address) return false;
    }
    return true;
  }

  private function _checkBotScout($data)
  {
    if ($data['ip']) {
      $address = 'http://botscout.com/test/?ip='.$data['ip'];
      if ($this->params->def('botscout_api_key', ''))
        $address .= '&key='.$this->params->get('botscout_api_key');
      $response = $this->_getUrl($address);
      if ($response) {
        $response = explode('|',$response);
        if ($response[0] == 'Y') return false;
      }
    }
    return true;
  }

  private function _checkSpamHaus($data)
  {
    if ($data['reverseip']) {
      $address = $data['reverseip'].'.zen.spamhaus.org.';
      $response = @gethostbyname($address);
      if ($response != $address) return false;
    }
    return true;
  }

  private function _checkSpamCop($data)
  {
    if ($data['reverseip']) {
      $address = $data['reverseip'].'.bl.spamcop.net.';
      $response = @gethostbyname($address);
      if ($response == '127.0.0.2') return false;
    }
    return true;
  }

  private function _checkSpamBusted($data)
  {
    if ($data['ip']) {
      $address = 'http://www.spambusted.com/api.php?ip='.$data['ip'];
      $response = $this->_getUrl($address);
      if ($response && $response == 'Yes') return false;
    }
    return true;
  }

  private function _checkHoneyPot($data)
  {
    if ($data['reverseip'] && $this->params->def('honeypot_api_key', '')) {
      $address = $this->params->get('honeypot_api_key').'.'.$data['reverseip'].'.dnsbl.httpbl.org.';
      $response = @gethostbyname($address);
      if ($response != $address) {
        $response = explode('.',$response);
        if ($response[2] > 0 && $response[3] > 1) return false;
      }
    }
    return true;
  }
}