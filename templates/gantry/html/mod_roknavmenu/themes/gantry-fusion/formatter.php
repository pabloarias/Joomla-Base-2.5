<?php
/**
* @version   $Id: formatter.php 1639 2012-07-13 00:22:06Z kevin $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - ${copyright_year} RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
* Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 *
 */
class GantryFusionFormatter extends AbstractJoomlaRokMenuFormatter
{
    function format_subnode(&$node)
    {
	    // Format the current node
        if ($node->getType() == 'menuitem' or $node->getType() == 'separator')
        {
            if ($node->hasChildren())
            {
    			$node->addLinkClass("daddy");
            } else
            {
    		    $node->addLinkClass("orphan");
    		}
    		$node->addLinkClass("item");
		}
        if ($node->getLevel() == 0)
        {
		$node->addListItemClass("root");
		}
	}
}