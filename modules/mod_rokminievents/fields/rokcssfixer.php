<?php
/**
 * @version   $Id$
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die();

/**
 *
 */
class JFormFieldRokcssfixer extends JFormField
{

    /**
     * @var string
     */
    public $type = 'RokCssFixer';

    /**
     *
     */
    public function getInput()
    {

        $document =& JFactory::getDocument();

        $document->addStyleSheet(JURI::Root(true) . "/modules/mod_rokminievents/admin/rokminievents-admin.css");
    }
}

?>