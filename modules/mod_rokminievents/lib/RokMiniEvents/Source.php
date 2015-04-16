<?php
/**
 * @version   1.7 January 24, 2012
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

defined('ROKMINIEVENTS') or die('Restricted access');

interface RokMiniEvents_Source {
    function getEvents(&$params);

    /**
     * Checks to see if the source is available to be used
     * @abstract
     * @return bool
     */
    function available();
}
