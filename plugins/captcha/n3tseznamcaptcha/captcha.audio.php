<?php
/**
 * @package n3tSeznamCaptcha
 * @author Pavel Poles - n3t.cz
 * @copyright (C) 2012-2014 - Pavel Poles - n3t.cz
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// No _JEXEC test, as this file is called directly, not through Joomla API
// defined( '_JEXEC' ) or die( 'Restricted access' );

$url = 'http://captcha.seznam.cz/captcha.getAudio?hash='.$_GET['hash'];
if (ini_get('allow_url_fopen')) {
  $audio = file_get_contents($url);
} elseif (extension_loaded('curl') && function_exists('curl_exec')) {
  $c = curl_init();
  curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($c, CURLOPT_URL, $url);
  $audio = curl_exec($c);
  curl_close($c);
}

header("Cache-Control: max-age=0,no-cache,no-store,post-check=0,pre-check=0,must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Content-Type: audio/x-wav");
if (isset($_GET['d']) && $_GET['d'])
  header("Content-Disposition: attachment; filename=captcha.wav");
else
  header("Content-Disposition: inline; filename=captcha.wav");
header("Content-Length: ".strlen($audio));

echo $audio;
?>