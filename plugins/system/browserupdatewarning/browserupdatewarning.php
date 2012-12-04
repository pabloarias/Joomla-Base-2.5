<?php
/**
 * @version		$Id: browserupdatewarning.php 20196 2011-03-04 02:40:25Z mrichey $
 * @package		plg_sys_browserupdatewarning
 * @copyright	Copyright (C) 2005 - 2011 Michael Richey. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemBrowserUpdateWarning extends JPlugin
{
        var $_initialized = false;

//	function onBeforeRender() altered to accommodate JA T3 framework
        function onAfterRoute()
	{
                if($this->_initialized) return true;
                $app = JFactory::getApplication();
                
                // do we run in administrator ?
                if($app->isAdmin()) return true;

                $cookiepath = $app->getCfg('cookie_path',JURI::root(true));

                $this->_initialized = true;

                if(JRequest::getString('plg_system_browserupdatewarning', false, 'cookie')) {
                    // user has already opted to continue
                    return true;
                }
                
                $doc = JFactory::getDocument();

                // we don't run in pages that aren't html
                if($doc->getType() != 'html') return true;

                // we don't run in modal pages or other incomplete pages
                $nogo = array('component','raw');
                if(in_array(JRequest::getString('tmpl'),$nogo)) return true;
                
                // sweet - it's on!
                JFactory::getLanguage()->load('plg_system_browserupdatewarning',JPATH_ADMINISTRATOR);
                JHtml::_('behavior.framework',true);
                
                // include the basic mootools plugin
                $doc->addScript(JURI::root(true).'/media/plg_system_browserupdatewarning/js/BrowserUpdateWarning.js');
                if($this->params->get('defaultcss',1)) {
                    $doc->addStyleSheet(JURI::root(true).'/media/plg_system_browserupdatewarning/css/BrowserUpdateWarning.css');
                }

                $options = $this->_getOptions();
                
                // initialize with options
                $script=array("window.addEvent('domready',function(){");
                $script[]="var plg_system_browserupdatewarning_cookie = Cookie.read('plg_system_browserupdatewarning');";
                $script[]="\tif(!plg_system_browserupdatewarning_cookie) {";
                $script[]="\t\tvar plg_system_browserupdatewarning = new BrowserUpdateWarning({";
                $script[]=implode(",\n",$options);
                $script[]="\t\t});";
                $script[]="\t\tplg_system_browserupdatewarning.check();";
                $script[]="\t}";
                $script[]='});';
                $script[]='var plg_system_browserupdatewarning_language = '.json_encode($this->_getLanguage());
                $script[]='var plg_system_browserupdatewarning_cookiepath = \''.$cookiepath.'\';';
                $doc->addScriptDeclaration(implode("\n",$script));
		return true;
	}

        private function _getLanguage() {
            $strings=array(
                'TIMETOUPGRADE',
                'UPDATECURRENT',
                'IE','SAFARI','FIREFOX','CHROME','OPERA',
                'WHYSHOULDI','WHYFASTER','WHYSAFER','WHYRENDER','WHYMORE',
                'CONTINUE'
                );
            $output=array();
            foreach ($strings as $string) {
                $fullstring='PLG_SYS_BROWSERUPDATEWARNING_JS_'.$string;
                $output[$string]=JText::_($fullstring);
            }
            return $output;
        }
        
        private function _getOptions() {
                $options=array();
                // the basic settings
                if($this->params->get('shade',1)) {
                    $options[]="\t\t\t'opacity': ".$this->params->get('opacity',30); // Opacity for shade div over content
                } else {
                    $options[]="\t\t\t'shade':false";
                }
                $options[]="\t\t\t'imagesDirectory': '".JURI::root(true)."/media/plg_system_browserupdatewarning/images/'"; // images folder
                $options[]="\t\t\t'allowContinue':".($this->params->get('allowContinue',1)?'true':'false'); // Show Continue to site button
                
                // minimum version overrides
                foreach(array('ie'=>7,'safari'=>5,'firefox'=>5,'chrome'=>15,'opera'=>10) as $browser=>$default) {
                    $optname = 'minVersion_'.$browser;
                    $optvalue = $this->params->get($optname,$default);
                    if($optvalue != $default) {
                        $options[]="\t\t\t'".$optname."':".$optvalue;
                    }
                }
                // downloadOptions override
                $downloadoptions = $this->params->get('downloadoptions',array('ie','safari','firefox','chrome','opera'));
                if($downloadoptions != array('ie,safari,firefox,chrome,opera')) {
                    $options[]="\t\t\t'downloadOptions':".json_encode($downloadoptions);
                }
                return $options;
        }
}