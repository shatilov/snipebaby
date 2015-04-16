<?php
/**
 * @package n3tSeznamCaptcha
 * @author Pavel Poles - n3t.cz
 * @copyright (C) 2012-2014 - Pavel Poles - n3t.cz
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No _JEXEC test, as this file is called directly, not through Joomla API
// defined( '_JEXEC' ) or die( 'Restricted access' );

header("Cache-Control: max-age=0,no-cache,no-store,post-check=0,pre-check=0,must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

$url = 'http://captcha.seznam.cz/captcha.create';
if (ini_get('allow_url_fopen')) {
  echo file_get_contents($url);
} elseif (extension_loaded('curl') && function_exists('curl_exec')) {
  $c = curl_init();
  curl_setopt($c, CURLOPT_URL, $url);
  curl_exec($c);
  curl_close($c);
}
?>