<?php
/**
* @version   $Id: component.php 2901 2012-08-30 20:47:24Z kevin $
 * @author RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - ${copyright_year} RocketTheme, LLC
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

?>
<?php if (JRequest::getString('type')=='raw'):?>
	<jdoc:include type="component" />
<?php else: ?>
	<!doctype html>
	<html xml:lang="<?php echo $gantry->language; ?>" lang="<?php echo $gantry->language;?>" >
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
			<?php
				$gantry->displayHead();
				$gantry->addLess('global.less', $gantry->templateName . '-compiled.css', 8, array('headerstyle'=>'"header-'.$gantry->get('headerstyle','dark').'.less"'));
			?>
		</head>
		<body class="component-body">
			<div id="rt-main">
					<div class="rt-block">
						<div id="rt-mainbody">
						<div class="component-content">
					    	<jdoc:include type="component" />
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>
<?php endif; ?>
<?php
$gantry->finalize();
?>
