<?php
/**
 * @package		Gantry Template Framework - RocketTheme
 * @version		1.6.5 December 12, 2011
 * @author		RocketTheme http://www.rockettheme.com
 * @copyright 	Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureStyleDeclaration extends GantryFeature {
    var $_feature_name = 'styledeclaration';
	var $_light = '#fff';
	var $_dark = '#222';
	
	var $_opacity = 1;

    function isEnabled() {
        global $gantry;
        $menu_enabled = $this->get('enabled');

        if (1 == (int)$menu_enabled) return true;
        return false;
    }

	function init() {
        global $gantry;
		$browser = $gantry->browser;

		// Contrast defaults
		
		if ($browser->name == 'ie' && version_compare($browser->version, 9, '>=') || $browser->name != 'ie'){
			$this->_opacity = 0.9;
		}
			
        // top section
        $css = '#rt-top-surround2, .title1 .module-title, #rt-top-surround .readon span, #rt-top-surround .readon .button {background:'.$gantry->get('topblock-background').';}'."\n";
        $css .= '#rt-top-surround, .notitle .title, #rt-top-surround, .notitle .title span, #rt-top-surround .title, #rt-top-surround .title span, #rt-body-surround .title1 .title, #rt-body-surround .title1 .title span, #rt-footer-surround .title1 .title, #rt-footer-surround .title1 .title span, #rt-top-surround .inputbox, .ft-highlight .featuretable-cell.ft-row-top, .ft-highlight .featuretable-cell.ft-row-top a {color: '.$this->contrast($gantry->get('topblock-background')).';}'."\n";
        $css .= '#rt-top-surround a, #rt-top-surround .menutop li > .item, .title1 .title, .title1 .title span, #rt-top-surround .readon span, #rt-top-surround .readon .button, .rokminievents-badge .day, .rokminievents-badge .day, .timeline-dates.date-inline .active {color:'.$gantry->get('topblock-link').';}'."\n";
        $css .= '#rt-top-surround .readon:hover span, #rt-top-surround .readon:hover .button {background-color:'.$this->contrast($gantry->get('topblock-background')).'}'."\n";
		$css .= '.rokminievents-wrapper .timeline .progress .knob, .rokminievents-badge .day, .timeline-dates.date-inline .active, .ft-highlight .featuretable-cell.ft-row-top {background-color:'.$gantry->get('topblock-background').';}'."\n";
        
        // showcase section
        $css .= '#rt-showcase, .title2 .module-title {background:'.$gantry->get('showcaseblock-background').';}'."\n";
        $css .= '#rt-showcase, #rt-showcase .title, #rt-showcase .title span, #rt-top-surround .title2 .title, #rt-top-surround .title2 .title span, #rt-body-surround .title2 .title, #rt-body-surround .title2 .title span, #rt-footer-surround .title2 .title, #rt-footer-surround .title2 .title span, #rt-showcase a:hover, #rt-showcase .inputbox {color: '.$this->contrast($gantry->get('showcaseblock-background')).';}'."\n";
        $css .= '#rt-showcase .readon span, #rt-showcase .readon .button {color: '.$this->contrast($gantry->get('showcaseblock-link')).';}'."\n";
        $css .= '#rt-showcase .readon:hover span, #rt-showcase .readon:hover .button {color: '.$this->contrast($gantry->get('showcaseblock-background')).';}'."\n";
        $css .= '#rt-showcase a {color:'.$gantry->get('showcaseblock-link').';}'."\n";
        $css .= '#rt-showcase .readon span, #rt-showcase .readon .button {background-color:'.$gantry->get('showcaseblock-link').';}'."\n";  
        $css .= '#rt-showcase .readon:hover span, #rt-showcase .readon:hover .button {background-color:'.$gantry->get('showcaseblock-background').';}'."\n";

		// body section
        $css .= 'a, body .root-sub a, #rt-top-surround .menutop li > .item:hover, #rt-top-surround .readon:hover span, #rt-top-surround .readon:hover .button, #rt-top-surround .menutop li.root.f-mainparent-itemfocus > .item, #rt-page-surround #rokweather .day, #rokweather h5,.featuretable-cell-data b, .featuretable-cell-data strong, #rt-body-surround .module-content ul.menu li > a, #rt-body-surround .module-content ul.menu li > .separator, #rt-body-surround .module-content ul.menu li > .item, #rt-top-surround .fusion-submenu-wrapper ul li > .item {color:'.$gantry->get('body-link').';}'."\n";
        $css .= '.rt-article-icons .icon, .rt-article-icons ul li a, #rt-accessibility .button {background-color:'.$gantry->get('body-link').';}'."\n";
        $css .= 'body ul.checkmark li:after, body ul.circle-checkmark li:before, body ul.square-checkmark li:before, body ul.circle-small li:after, body ul.circle li:after, body ul.circle-large li:after {border-color:'.$gantry->get('body-link').';}'."\n";
        $css .= 'body ul.triangle-small li:after, body ul.triangle li:after, body ul.triangle-large li:after {border-left-color:'.$gantry->get('body-link').';}'."\n";
        
		if ($gantry->browser->platform == 'iphone' || $gantry->browser->platform == 'android'){
			// iphone sub-root color
			$css .= '#idrops li.root-sub a, #idrops li.root-sub span.separator, #idrops li.root-sub.active a, #idrops li.root-sub.active span.separator {color:'.$gantry->get('body-link').';}'."\n";
		}

        // footer section
        $css .= 'body {background:'.$gantry->get('footerblock-background').';}'."\n";
        $css .= '#rt-footer-surround, #rt-bottom, #rt-footer, #rt-copyright, #rt-footer-surround .title, #rt-footer-surround .title span, #rt-footer-surround a:hover, #rt-footer-surround .inputbox {color: '.$this->contrast($gantry->get('footerblock-background')).';}'."\n";
        $css .= '#rt-footer-surround .readon span, #rt-footer-surround .readon .button {color: '.$this->contrast($gantry->get('footerblock-link')).';}'."\n";
        $css .= '#rt-footer-bg a {color:'.$gantry->get('footerblock-link').';}'."\n";
        $css .= '#rt-footer-surround .readon span, #rt-footer-surround .readon .button {background-color:'.$gantry->get('footerblock-link').';}'."\n";
        $css .= '#rt-footer-surround .readon:hover span, #rt-footer-surround .readon:hover .button {background-color:'.$this->contrast($gantry->get('footerblock-background')).'}'."\n";
        
        if ($gantry->get('static-enabled')) {
            // do file stuff
            jimport('joomla.filesystem.file');
            $filename = $gantry->templatePath.DS.'css'.DS.'static-styles.css';

            if (file_exists($filename)) {
                if ($gantry->get('static-check')) {
                    //check to see if it's outdated

                    $md5_static = md5_file($filename);
                    $md5_inline = md5($css);

                    if ($md5_static != $md5_inline) {
                        JFile::write($filename, $css);
                    }
                }
            } else {
                // file missing, save it
                JFile::write($filename, $css);
            }
            // add reference to static file
            $gantry->addStyle('static-styles.css',99);

        } else {
            // add inline style
            $gantry->addInlineStyle($css);
        }
        

		$this->_disableRokBoxForiPhone();

		// Style Inclusion
		$bodystyle = $gantry->get('body-style');
		$gantry->addStyle('bodystyle-'.$bodystyle.'.css');
		if ($gantry->get('typography-enabled')) $gantry->addStyle('typography.css');
		if ($gantry->get('extensions')) $gantry->addStyle('extensions.css');
		if ($gantry->get('extensions')) $gantry->addStyle('extensions-'.$bodystyle.'.css');

	}
	
	function contrast($value, $dark = null, $light = null, $opacity = null){
		if (!isset($dark)) $dark = $this->_dark;
		if (!isset($light)) $light = $this->_light;
		if (!isset($opacity)) $opacity = $this->_opacity;
		
		$dark = substr($dark, 0, 1) == '#' ? str_replace('#', '', $dark) : $dark;
		$light = substr($light, 0, 1) == '#' ? str_replace('#', '', $light) : $light;
		$value = substr($value, 0, 1) == '#' ? str_replace('#', '', $value) : $value;
			
		if (strlen($value) == 3) $value = str_repeat($value[0], 2) . str_repeat($value[1], 2) . str_repeat($value[2], 2);
		if (strlen($dark) == 3) $dark = str_repeat($dark[0], 2) . str_repeat($dark[1], 2) . str_repeat($dark[2], 2);
		if (strlen($light) == 3) $light = str_repeat($light[0], 2) . str_repeat($light[1], 2) . str_repeat($light[2], 2);
		
		if ($opacity != 1){
			$dark = $this->_RGBA($dark, $opacity);
			$light = $this->_RGBA($light, $opacity);
		} else {
			$dark = '#' . $dark;
			$light = '#' . $light;
		}
		
	    return (hexdec($value) > 0xffffff/2) ? $dark : $light;
	}
	
	function _HEX2RGB($hexStr, $returnAsString = false, $seperator = ','){
		$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr);
	    $rgbArray = array();
	
	    if (strlen($hexStr) == 6){
	        $colorVal = hexdec($hexStr);
	        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
	        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
	        $rgbArray['blue'] = 0xFF & $colorVal;
	    } elseif (strlen($hexStr) == 3){
	        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
	        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
	        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	    } else {
	        return false;
	    }
	
	    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray;
	}
	
	function _RGBA($hex, $opacity){
		return 'rgba(' . implode(', ', $this->_HEX2RGB($hex)) . ', '.$opacity.')';
	}

	function _disableRokBoxForiPhone() {
		global $gantry;

		if ($gantry->browser->platform == 'iphone') {
			$gantry->addInlineScript("window.addEvent('domready', function() {\$\$('a[rel^=rokbox]').removeEvents('click');});");
		}
	}

}