<?php 
/*
 *  NamelessMC version 2.0.0-pre6
 *
 *  License: MIT
 *
 */

class Monarch_Module extends Module {
	private $_language, $_monarch_language;

	public function __construct($pages, $language, $monarch_language){
		$this->_language = $language;
		$this->_monarch_language = $monarch_language;

		$name = 'Monarch';
		$author = '<a href="https://spigotmc.org">Spiele</a>';
		$module_version = '2.0.0-pr6';
		$nameless_version = '2.0.0-pr6';

		parent::__construct($this, $name, $author, $module_version, $nameless_version);

		// Pages
		$pages->add('Monarch', '/panel/monarch', 'pages/panel.php');
	}

	public function onInstall(){
		// Copy panel template
		if(!is_dir(ROOT_PATH . '/custom/panel_templates/' . PANEL_TEMPLATE . '/monarch')){
			try {
				mkdir(ROOT_PATH . '/custom/panel_templates/' . PANEL_TEMPLATE . '/monarch');
				copy(ROOT_PATH . '/custom/panel_templates/Default/monarch/index.tpl', ROOT_PATH . '/custom/panel_templates/' . PANEL_TEMPLATE . '/monarch/index.tpl');
			} catch(Exception $e){
				// Unable to copy
			}
		}
	}

	public function onUninstall(){
		// Not necessary
	}

	public function onEnable(){
		// Not necessary
	}

	public function onDisable(){
		// Not necessary
	}

	public function onPageLoad($user, $pages, $cache, $smarty, $navs, $widgets, $template){
		// Permissions
		PermissionHandler::registerPermissions('Monarch', array(
			'admincp.monarch' => $this->_language->get('moderator', 'staff_cp') . ' &raquo; Monarch'
		));

		if(defined('FRONT_END')){
			require(ROOT_PATH . '/modules/Monarch/pages/getvariables.php');

			$smarty->assign(array(
				'MONARCH_COLOR' => $monarch_color,
				'MONARCH_BG' => $monarch_bg,
				'MONARCH_PAGE_BG' => $monarch_page_bg,
				'MONARCH_CONTENT_BG' => $monarch_content_bg,
				'MONARCH_LOGO' => $monarch_logo,
				'MONARCH_FAVICON' => $monarch_favicon_desc,
			));

		} else {
			if($user->data()->group_id == 2 || $user->hasPermission('admincp.monarch')){
				$cache->setCache('panel_sidebar');
				if(!$cache->isCached('monarch_order')){
					$order = 35;
					$cache->store('monarch_order', 35);
				} else {
					$order = $cache->retrieve('monarch_order');
				}

				if(!$cache->isCached('monarch_icon')){
					$icon = '<i class="nav-icon fas fa-archive"></i>';
					$cache->store('monarch_icon', $icon);
				} else
					$icon = $cache->retrieve('monarch_icon');

				$navs[2]->add('monarch_divider', mb_strtoupper($this->_monarch_language->get('language', 'monarch_title')), 'divider', 'top', null, $order, '');
				$navs[2]->add('monarch', $this->_monarch_language->get('language', 'monarch_title'), URL::build('/panel/monarch'), 'top', null, ($order + 0.1), $icon);
			}
		}
	}
}