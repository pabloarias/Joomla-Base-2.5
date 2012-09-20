<?php
/**
 * @package   gantry
 * @subpackage core
 * @version   4.0.5 September 18, 2012
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JController::getInstance('Gantry');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();