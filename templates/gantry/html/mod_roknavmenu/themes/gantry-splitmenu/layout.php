<?php
/**
* @version   $Id: layout.php 3559 2012-09-13 10:08:59Z james $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - ${copyright_year} RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class GantrySplitmenuLayout extends AbstractRokMenuLayout
{
    protected $theme_path;
    protected $params;
	static $jsLoaded = false;

    private $activeid;

    public function __construct(&$args)
    {
        parent::__construct($args);
        /** @var $gantry Gantry */
		global $gantry;
        $theme_rel_path = "/html/mod_roknavmenu/themes/gantry-splitmenu";
        $this->theme_path = $gantry->templatePath . $theme_rel_path;
        $this->args['theme_path'] = $this->theme_path;
        $this->args['theme_rel_path'] = $gantry->templateUrl. $theme_rel_path;
        $this->args['theme_url'] = $this->args['theme_rel_path'];
    }

    public function stageHeader()
    {
        /** @var $gantry Gantry */
		global $gantry;

        //don't include class_sfx on 3rd level menu
        $this->args['class_sfx'] =  (array_key_exists('startlevel', $this->args) && $this->args['startLevel']==1) ? '' : $this->args['class_sfx'];
        $this->activeid = (array_key_exists('splitmenu_fusion_enable_current_id', $this->args) && $this->args['splitmenu_fusion_enable_current_id']== 0) ? false : true;

        JHtml::_('behavior.mootools');

		if (!self::$jsLoaded){
			$mobileScript = "
			window.addEvent('domready', function(){
				document.getElements('[data-rt-menu-mobile]').addEvent('change', function(){
					window.location.href = this.value;
				});
			});";

			$this->appendInlineScript($mobileScript);
			self::$jsLoaded = true;
		}
    }

    function isIe($version = false)
    {
        $agent=$_SERVER['HTTP_USER_AGENT'];
        $found = strpos($agent,'MSIE ');
        if ($found) {
                if ($version) {
                    $ieversion = substr(substr($agent,$found+5),0,1);
                    if ($ieversion == $version) return true;
                    else return false;
                } else {
                    return true;
                }

            } else {
                    return false;
            }
        if (stristr($agent, 'msie'.$ieversion)) return true;
        return false;
    }


    protected function renderItem(JoomlaRokMenuNode &$item, RokMenuNodeTree &$menu)
    {
        $item_params = $item->getParams();
        //not so elegant solution to add subtext
        $item_subtext = $item_params->get('splitmenu_item_subtext','');
        if ($item_subtext=='') $item_subtext = false;
        else $item->addLinkClass('subtext');

		if ($item_params->get('splitmenu_menu_entry_type','normal') == 'normal'):
        ?>
        <li <?php if($item->hasListItemClasses()) : ?>class="<?php echo $item->getListItemClasses()?>"<?php endif;?> <?php if($item->hasCssId() && $this->activeid):?>id="<?php echo $item->getCssId();?>"<?php endif;?>>
            <?php if ($item->getType() == 'menuitem') : ?>
                <a <?php if($item->hasLinkClasses()):?>class="<?php echo $item->getLinkClasses();?>"<?php endif;?> <?php if($item->hasLink()):?>href="<?php echo $item->getLink();?>"<?php endif;?> <?php if($item->hasTarget()):?>target="<?php echo $item->getTarget();?>"<?php endif;?> <?php if ($item->hasAttribute('onclick')): ?>onclick="<?php echo $item->getAttribute('onclick'); ?>"<?php endif; ?><?php if ($item->hasLinkAttribs()): ?> <?php echo $item->getLinkAttribs(); ?><?php endif; ?>>
                    <span>
                    <?php echo $item->getTitle();?>
                    <?php if (!empty($item_subtext)) :?>
                    <em><?php echo $item_subtext; ?></em>
                    <?php endif; ?>
                    <?php if ($item->getParent() == 0 && $item->hasChildren()): ?>
                    <span class="daddyicon"></span>
                    <?php endif; ?>
                    </span>
                </a>
            <?php elseif($item->getType() == 'separator') : ?>
                <span <?php if($item->hasLinkClasses()):?>class="<?php echo $item->getLinkClasses();?> nolink"<?php endif;?>>
                    <span>
                    <?php echo $item->getTitle();?>
                    <?php if (!empty($item_subtext)) :?>
                    <em><?php echo $item_subtext; ?></em>
                    <?php endif; ?>
                    <?php if ($item->getParent() == 0 && $item->hasChildren()): ?>
                    <span class="daddyicon"></span>
                    <?php endif; ?>
                    </span>
                </span>
            <?php endif; ?>
            <?php if ($item->hasChildren()): ?>
            <ul class="level<?php echo intval($item->getLevel())+2; ?>">
                <?php foreach ($item->getChildren() as $child) : ?>
                    <?php $this->renderItem($child, $menu); ?>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </li>
		<?php else:
			$item->addListItemClass('menu-module');
			$module_id      = $item_params->get('splitmenu_menu_module');
			$menu_module    = $this->getModule($module_id);
			$document       = JFactory::getDocument();
			$renderer       = $document->loadRenderer('module');
			$params         = array('style'=> 'fusion');
			$module_content = $renderer->render($menu_module, $params);
			?>
		<li <?php if ($item->hasListItemClasses()) : ?>class="<?php echo $item->getListItemClasses()?>"<?php endif;?> <?php if ($item->hasCssId() && $this->activeid): ?>id="<?php echo $item->getCssId();?>"<?php endif;?>>
			<?php echo $module_content; ?>
		</li>
        <?php
		endif;
    }

	public function curPageURL($link) {
		$pageURL = 'http';
	 	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 	$pageURL .= "://";
	 	if ($_SERVER["SERVER_PORT"] != "80") {
	  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 	} else {
	  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 	}

		$replace = str_replace('&', '&amp;', (preg_match("/^http/", $link) ? $pageURL : $_SERVER["REQUEST_URI"]));

		return $replace == $link || $replace == $link . 'index.php';
	}

    public function renderMenu(&$menu) {

        ob_start();
		/** @var $gantry Gantry */
		global $gantry;
?>
<?php if ($this->args['style'] != 'mobile' && $menu->getChildren()) : ?>
<div class="rt-menubar splitmenu">
    <ul class="menu<?php echo $this->args['class_sfx']; ?> level1" <?php if(array_key_exists('tag_id',$this->args)):?>id="<?php echo $this->args['tag_id'];?>"<?php endif;?>>
        <?php foreach ($menu->getChildren() as $item) :  ?>
             <?php $this->renderItem($item, $menu); ?>
        <?php endforeach; ?>
    </ul>
	<div class="clear"></div>
</div>
<?php endif; ?>
<?php if ($this->args['style'] == 'mobile'): ?>
<div class="rt-menu-mobile">
	<select data-rt-menu-mobile>
		<?php foreach ($menu->getChildren() as $item) : ?>
		<?php $this->renderMobileItem($item, $menu); ?>
		<?php endforeach; ?>
	</select>
</div>
<?php endif; ?>
<?php
        return ob_get_clean();
    }

	function renderMobileItem(JoomlaRokMenuNode &$item, RokMenuNodeTree &$menu){
		$item_params = new JParameter($item->getParams());
		$level = str_repeat("&mdash;", $item->getLevel()) . " ";
		$isActive = in_array('active', explode(" ", $item->getListItemClasses())) ? ' selected="selected"' : '';
		?>
		<?php if ($item_params->get('splitmenu_menu_entry_type','normal') == 'normal' && $item->getType() == 'menuitem') : ?>
			<option value="<?php echo $item->getLink();?>"<?php echo $isActive;?>><?php echo $level.$item->getTitle();?></option>

			<?php
				if ($item->hasChildren()){
					foreach($item->getChildren() as $child){
						if ($item->getType() == 'menuitem'){
							$this->renderMobileItem($child, $menu);
						}
					}
				}
			?>
		<?php endif; ?>
		<?php
	}

	function getModule ($id=0, $name='')
	{

		$modules	=& RokNavMenu::loadModules();
		$total		= count($modules);
		for ($i = 0; $i < $total; $i++)
		{
			// Match the name of the module
			if ($modules[$i]->id == $id || $modules[$i]->name == $name)
			{
				return $modules[$i];
			}
		}
		return null;
	}
}
