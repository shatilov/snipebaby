<?php
/**
 * @version   $Id$
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

defined('_JEXEC') or die();

/**
 * @package     gantry
 * @subpackage  admin.elements
 */
class JFormFieldDateformats extends JFormField
{
    /**
     * @var string
     */
    var $_name = 'DateFormats';

    /**
     * @var string
     */
    public $type = 'DateFormats';

    /**
     * @return mixed
     */
    function getInput()
    {
        $class = ($this->element['class'] ? 'class="' . $this->element['class'] . '"' : 'class="inputbox"');

        $options = array();
        $dates   = $this->element->children();

        $now = &JFactory::getDate();

        $user = & JFactory::getUser();
        $now->setOffset($user->getParam('timezone', 0));

        foreach ($dates as $option) {
            $val           = (string)$option['value'];
            $option->_data = $now->toFormat($val);
            $options[]     = JHTML::_('select.option', $val, (string)$option->_data);
        }
        return JHTML::_('select.genericlist', $options, $this->name, $class, 'value', 'text', $this->value, $this->name);
    }
}
