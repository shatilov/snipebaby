<?php
/**
 * @package Gantry Template Framework - RocketTheme
 * @version 1.6.5 December 12, 2011
 * @author RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );

// load and inititialize gantry class
require_once('lib/gantry/gantry.php');
$gantry->init();

function isBrowserCapable(){
  global $gantry;
  
  $browser = $gantry->browser;
  
  // ie.
  if ($browser->name == 'ie' && $browser->version < 8) return false;
  
  return true;
}

?>

<!DOCTYPE html>
<html>
<head>
  <?php 
    $browser = $gantry->browser;
    
    $gantry->displayHead();
    $gantry->addStyles(array('template.css','joomla.css','overlays.css'));
    
    if ($gantry->get('fixedheader') && $gantry->get('menu-type') != 'splicemenu') $gantry->addScript('rt-fixedheader.js');
    
    if ($browser->platform != 'iphone')
      $gantry->addInlineScript('window.addEvent("domready", function(){ new SmoothScroll(); });');
    
    if ($gantry->get('loadtransition') && isBrowserCapable()){
      $gantry->addScript('load-transition.js');
      $hidden = ' class="rt-hidden"';
    } else {
      $hidden = '';
    }
  ?>
<meta name="google-site-verification" content="w3E-5zoWIGR7W-H2aPmD_jc7aO6ihwQsqIwnjojSab8" />
</head>
  <body <?php echo $gantry->displayBodyTag(); ?>>
  <div id="rt-art"></div><!-- bd1cb44e5a --><div style="display:none"></div><!-- bd1cb44e5a -->
    <div id="rt-page-surround">
      <?php /** Begin Top Surround **/ if ($gantry->countModules('top') or $gantry->countModules('header')) : ?>
      <div id="rt-top-surround">
        <div id="rt-top-surround2">

          <table style="background-image: url(images/bg-kidsik-top.jpg); background-repeat: no-repeat;  background-position: bottom; border: 0px; height: 260px; width: 100%;"><tr>
              <td style="text-align:left;padding-left:12px"><img src="images/children2.png" alt=""></td>
              <td style="text-align:center"><img src="images/logo-main.png" alt=""></td>
              <td style="text-align:right;padding-right:12px"><img src="images/children1.png" alt=""></td>
            </tr>
          </table>
          
          <?php /** Begin Top **/ if ($gantry->countModules('top')) : ?>
          <div id="rt-top"><div id="rt-top2"><div id="rt-top3">
            <div class="rt-container">
              <?php echo $gantry->displayModules('top','standard','alternate'); ?>
              <div class="clear"></div>
            </div>
          </div></div></div>
          <?php /** End Top **/ endif; ?>
          <?php /** Begin Header **/ if ($gantry->countModules('header')) : ?>
          <div id="rt-header"><div id="rt-header2"> 
            
        <div style="display:table;margin:0;padding:0;">
          <div style="display:table-cell;
                width:50%;text-align:right;margin:0;
                padding-right:10px;vertical-align: middle;
                color:#FFFFFF;font-size:15px">
          +7(499)707-12-89
          </div>
          <div style="display:table-cell">
          <div class="rt-container">
            <?php echo $gantry->displayModules('header','standard','alternate'); ?>
            <div class="clear"></div>
          </div>
          </div>
          <div style="display:table-cell;;width:50%;margin:0;padding:0;margin:0;
                padding-right:10px;vertical-align: middle;
                color:#FFFFFF;font-size:15px">
           info@snipebaby.ru
          </div>
        </div>
      
          </div></div>
          <?php /** End Header **/ endif; ?>
        </div>
        <div id="top-shadow"></div>
      </div>
      <?php /** End Top Surround **/ endif; ?>
      <div id="rt-body-bg"<?php echo $hidden; ?>>
        <div class="rt-container">
          <?php /** Begin Drawer **/ if ($gantry->countModules('drawer')) : ?>
          <div id="rt-drawer">
            <div class="rt-container">
              <?php echo $gantry->displayModules('drawer','standard','standard'); ?>
              <div class="clear"></div>
            </div>
          </div>
          <?php /** End Drawer **/ endif; ?>
          <?php /** Begin Showcase **/ if ($gantry->countModules('showcase')) : ?>
          <div id="rt-showcase"><div id="rt-showcase2"><div id="rt-showcase3"><div id="rt-showcase4">
            <?php echo $gantry->displayModules('showcase','standard','showcase'); ?>
            <div class="clear"></div>
          </div></div></div></div>
          <?php /** End Showcase **/ endif; ?>
          <div id="rt-body-surround" <?php echo $gantry->displayClassesByTag('rt-body-surround'); ?>>
            <?php /** Begin Feature **/ if ($gantry->countModules('feature')) : ?>
            <div id="rt-feature">
              <?php echo $gantry->displayModules('feature','standard','standard'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Feature **/ endif; ?>
            <?php /** Begin Utility **/ if ($gantry->countModules('utility')) : ?>
            <div id="rt-utility">
              <?php echo $gantry->displayModules('utility','standard','standard'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Utility **/ endif; ?>
            <?php /** Begin Main Top **/ if ($gantry->countModules('maintop')) : ?>
            <div id="rt-maintop">
              <?php echo $gantry->displayModules('maintop','standard','standard'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Main Top **/ endif; ?>
            <?php /** Begin Breadcrumbs **/ if ($gantry->countModules('breadcrumb')) : ?>
            <div id="rt-breadcrumbs">
              <?php echo $gantry->displayModules('breadcrumb','basic','breadcrumbs'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Breadcrumbs **/ endif; ?>
            <?php /** Begin Main Body **/ ?>
              <?php echo $gantry->displayMainbody('mainbody','sidebar','standard','standard','standard','standard','standard'); ?>
            <?php /** End Main Body **/ ?>
            <?php /** Begin Main Bottom **/ if ($gantry->countModules('mainbottom')) : ?>
            <div id="rt-mainbottom" style="padding-bottom:400px">
              <?php echo $gantry->displayModules('mainbottom','standard','standard'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Main Bottom **/ endif; ?>
          </div>
        </div>
      </div>
      <?php /** Begin Footer Section **/ if ($gantry->countModules('bottom') or $gantry->countModules('footer') or $gantry->countModules('copyright') or $gantry->countModules('debug')) : ?>
      <div id="rt-footer-bg"<?php echo $hidden; ?>>
        <div class="rt-container">
          <div id="rt-footer-surround">
            <?php /** Begin Bottom **/ if ($gantry->countModules('bottom')) : ?>
            <div id="rt-bottom">
              <?php echo $gantry->displayModules('bottom','standard','alternate'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Bottom **/ endif; ?>
            <?php /** Begin Footer **/ if ($gantry->countModules('footer')) : ?>
            <div id="rt-footer">
              <?php echo $gantry->displayModules('footer','standard','alternate'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Footer **/ endif; ?>
            <?php /** Begin Copyright **/ if ($gantry->countModules('copyright')) : ?>
            <div id="rt-copyright" style="margin-top:200px">
              <?php echo $gantry->displayModules('copyright','standard','alternate'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Copyright **/ endif; ?>
            <?php /** Begin Debug **/ if ($gantry->countModules('debug')) : ?>
            <div id="rt-debug">
              <?php echo $gantry->displayModules('debug','standard','alternate'); ?>
              <div class="clear"></div>
            </div>
            <?php /** End Debug **/ endif; ?>
          </div>
        </div>
      </div>
      <?php /** End Footer Section **/ endif; ?>
      <?php /** Begin Popups **/ 
      echo $gantry->displayModules('popup','popup','popup');
      echo $gantry->displayModules('login','login','popup'); 
      /** End Popup s**/ ?>
      <?php /** Begin Analytics **/ if ($gantry->countModules('analytics')) : ?>
      <?php echo $gantry->displayModules('analytics','basic','basic'); ?>
      <?php /** End Analytics **/ endif; ?>
    </div>

<div style="text-align: center">
	<?php include 'counters.php' ?>
</div>
<!-- </td></tr>
</table> -->
<?php
$gantry->finalize();
?>
	<?php include 'assets-footer.php' ?>
  </body>
</html>