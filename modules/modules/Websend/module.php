<?php
/*
 *	Made by Samerton
 *  https://github.com/samerton
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 *
 *  Websend module for NamelessMC
 */

class Websend_Module extends Module {
	private $_language, $_websend_language, $_queries, $_cache;

	public function __construct($pages, $language, $websend_language, $queries, $cache){
		$this->_language = $language;
		$this->_websend_language = $websend_language;
		$this->_queries = $queries;
		$this->_cache = $cache;

		$name = 'Websend';
		$author = '<a href="https://samerton.me" target="_blank" rel="nofollow noopener">Samerton</a>';
		$module_version = '1.1.0';
		$nameless_version = '2.0.0-pr6';

		parent::__construct($this, $name, $author, $module_version, $nameless_version);

		// Pages
		$pages->add('Websend', '/panel/websend', 'pages/panel/websend.php');

		// Hooks
		$ws_hooks = $queries->getWhere('websend_commands', array('enabled', '=', 1));
		if(count($ws_hooks)){
			if(!file_exists(ROOT_PATH . '/modules/Websend/config.php')){
				return;
			}

			require_once(ROOT_PATH . '/modules/Websend/config.php');
			require_once(ROOT_PATH . '/modules/Websend/classes/Websend.php');
			require_once(ROOT_PATH . '/modules/Websend/classes/WSHook.php');

			WSHook::initWebsend($ws_config);

			$ws_events = array();
			foreach($ws_hooks as $hook){
				$ws_events[$hook->hook] = explode(PHP_EOL, $hook->commands);

				HookHandler::registerHook($hook->hook, 'WSHook::execute');
			}

			WSHook::setEvents($ws_events);
		}
	}

	public function onInstall(){
		$admin_permissions = $this->_queries->getWhere('groups', array('id', '=', 2));
		$admin_permissions = $admin_permissions[0]->permissions;

		$admin_permissions = json_decode($admin_permissions, true);
		$admin_permissions['admincp.websend'] = 1;

		$admin_permissions_updated = json_encode($admin_permissions);

		$this->_queries->update('groups', 2, array(
			'permissions' => $admin_permissions_updated
		));

		try {
			$engine = Config::get('mysql/engine');
			$charset = Config::get('mysql/charset');
		} catch(Exception $e){
			$engine = 'InnoDB';
			$charset = 'utf8mb4';
		}

		try {
			if(!$this->_queries->tableExists('websend_commands')){
				$this->_queries->createTable('websend_commands', ' `id` int(11) NOT NULL AUTO_INCREMENT, `hook` varchar(64) NOT NULL, `commands` mediumtext NOT NULL, `enabled` tinyint(1) NOT NULL DEFAULT \'0\', PRIMARY KEY (`id`)', "ENGINE=$engine DEFAULT CHARSET=$charset");
			}
		} catch(Exception $e){
			$ws_db_err = true;
		}

		$ws_conf =  '<?php' . PHP_EOL .
			'$ws_config = array(' . PHP_EOL .
			'   \'websend_server_address\' => \'\',' . PHP_EOL .
			'   \'websend_server_port\' => 4445,' . PHP_EOL .
			'   \'websend_password\' => \'\'' . PHP_EOL .
			');';

		if(file_put_contents(ROOT_PATH . '/modules/Websend/config.php', $ws_conf) === false){
			// Error creating config
			Session::flash('admin_modules_error', $this->_websend_language->get('language', 'unable_to_create_config'));

		}
	}

	public function onUninstall(){
		// Not implemented yet
	}

	public function onEnable(){
		// Not necessary
	}

	public function onDisable(){
		// Not necessary
	}

	public function onPageLoad($user, $pages, $cache, $smarty, $navs, $widgets, $template){
		$queries = new Queries();

		// Permissions
		PermissionHandler::registerPermissions('Websend', array(
			'admincp.websend' => $this->_language->get('moderator', 'staff_cp') . ' &raquo; ' . $this->_websend_language->get('language', 'websend')
		));

		if(defined('BACK_END')){
			// StaffCP sidebar link
			if($user->hasPermission('admincp.websend')){
				$cache->setCache('panel_sidebar');
				if(!$cache->isCached('websend_order')){
					$order = 51;
					$cache->store('websend_order', $order);
				} else {
					$order = $cache->retrieve('websend_order');
				}

				if(!$cache->isCached('websend_icon')){
					$icon = '<i class="nav-icon fas fa-terminal"></i>';
					$cache->store('websend_icon', $icon);
				} else
					$icon = $cache->retrieve('websend_icon');

				$navs[2]->add('websend_divider', mb_strtoupper($this->_websend_language->get('language', 'websend')), 'divider', 'top', null, $order, '');
				$navs[2]->add('websend', $this->_websend_language->get('language', 'websend'), URL::build('/panel/websend'), 'top', null, ($order + 0.1), $icon);
			}
		}
	}
}