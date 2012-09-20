<?php
/**
* @version   $Id: fusionmenu.php 2865 2012-08-29 20:59:33Z rhuk $
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - ${copyright_year} RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*
* Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
*
*/

defined('JPATH_BASE') or die();
gantry_import('core.gantryfeature');


/**
 * @package     gantry
 * @subpackage  features
 */
class GantryFeatureFusionMenu extends GantryFeature
{
    var $_feature_name = 'fusionmenu';
    var $_feature_prefix = 'menu';
    var $_menu_picker = 'menu-type';

    function isEnabled()
    {
        /** @var $gantry Gantry */
		global $gantry;
        $menu_enabled = $gantry->get('menu-enabled');
        $selected_menu = $gantry->get($this->_menu_picker);

        $cookie = 0;

        if (1 == (int)$menu_enabled && $selected_menu == $this->_feature_name && $cookie == 0) return true;
        return false;
    }

    function isOrderable()
    {
        return false;
    }

    function render($position)
    {
        /** @var $gantry Gantry */
		global $gantry;

        $renderer = $gantry->document->loadRenderer('module');
        $options = array('style' => "menu");
        $module = JModuleHelper::getModule('mod_roknavmenu','_z_empty');

        $params = $gantry->getParams($this->_feature_prefix . "-" . $this->_feature_name, true);
        $reg = new JRegistry();
        foreach ($params as $param_name => $param_value)
        {
            $reg->set($param_name, $param_value['value']);
        }
		$reg->set('style', 'mainmenu');
        $reg->merge($group_params_reg);
        $module->params = $reg->toString();
        $rendered_menu = $renderer->render($module, $options);

        if (!($gantry->browser->name == 'ie' && $gantry->browser->shortver <= 8)){
    		$reg->set('style', 'mobile');
    		$module->params = $reg->toString();
    		$rendered_menu .= $renderer->render($module, array('style', 'mobile-menu-block'));
        }

        return $rendered_menu;
    }
}
