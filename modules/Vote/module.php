<?php 
/*
 *	Made by Partydragen and Samerton
 *  https://github.com/partydragen/Vote-Module
 *  https://partydragen.com
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 *
 *  Vote module info file
 */

class Vote_Module extends Module {
	private $_vote_language;
	
	public function __construct($vote_language, $pages){
		$this->_vote_language = $vote_language;
		
		$name = 'Vote';
		$author = '<a href="https://partydragen.com" target="_blank" rel="nofollow noopener">Partydragen</a>, <a href="https://samerton.me" target="_blank" rel="nofollow noopener">Samerton</a>';
		$module_version = '2.0.0-pr6';
		$nameless_version = '2.0.0-pr6';
		
		parent::__construct($this, $name, $author, $module_version, $nameless_version);
		
		// Define URLs which belong to this module
		$pages->add('Vote', '/vote', 'pages/vote.php', 'vote', true);
		$pages->add('Vote', '/panel/vote', 'pages/panel/vote.php');
	}
	
	public function onInstall(){
		// Queries
		$queries = new Queries();
		
		try {
			$data = $queries->createTable("vote_settings", " `id` int(11) NOT NULL AUTO_INCREMENT, `name` varchar(20) NOT NULL, `value` varchar(2048) NOT NULL, PRIMARY KEY (`id`)", "ENGINE=InnoDB DEFAULT CHARSET=latin1");
			$data = $queries->createTable("vote_sites", " `id` int(11) NOT NULL AUTO_INCREMENT, `site` varchar(512) NOT NULL, `name` varchar(64) NOT NULL, PRIMARY KEY (`id`)", "ENGINE=InnoDB DEFAULT CHARSET=latin1");
		} catch(Exception $e){
			// Error
		}
		
		try {
			// Insert data
			$queries->create('vote_settings', array(
				'name' => 'vote_message',
				'value' => 'You can manage this vote module in StaffCP -> Vote'
			));
			$queries->create('vote_sites', array(
				'site' => 'https://mccommunity.net/',
				'name' => 'MCCommunity (Example)'
			));
			$queries->create('vote_sites', array(
				'site' => 'http://planetminecraft.com/',
				'name' => 'PlanetMinecraft (Example)'
			));
		} catch(Exception $e){
			// Error
		}
		
		try {
			// Update main admin group permissions
			$group = $queries->getWhere('groups', array('id', '=', 2));
			$group = $group[0];
			
			$group_permissions = json_decode($group->permissions, TRUE);
			$group_permissions['admincp.vote'] = 1;
			
			$group_permissions = json_encode($group_permissions);
			$queries->update('groups', 2, array('permissions' => $group_permissions));
		} catch(Exception $e){
			// Error
		}
	}

	public function onUninstall(){
		// No actions necessary
	}

	public function onEnable(){
		// No actions necessary
	}

	public function onDisable(){
		// No actions necessary
	}

	public function onPageLoad($user, $pages, $cache, $smarty, $navs, $widgets, $template){
		// AdminCP
		PermissionHandler::registerPermissions('Vote', array(
			'admincp.vote' => $this->_vote_language->get('vote', 'vote')
		));
		
		// navigation link location
		$cache->setCache('nav_location');
		if(!$cache->isCached('vote_location')){
			$link_location = 1;
			$cache->store('vote_location', 1);
		} else {
			$link_location = $cache->retrieve('vote_location');
		}
		
		// Navigation icon
		$cache->setCache('navbar_icons');
		if(!$cache->isCached('vote_icon')) {
			$icon = '';
		} else {
			$icon = $cache->retrieve('vote_icon');
		}
		
		// Navigation order
		$cache->setCache('navbar_order');
		if(!$cache->isCached('vote_order')){
			// Create cache entry now
			$vote_order = 3;
			$cache->store('vote_order', 3);
		} else {
			$vote_order = $cache->retrieve('vote_order');
		}
		
		switch($link_location){
			case 1:
				// Navbar
				$navs[0]->add('vote', $this->_vote_language->get('vote', 'vote'), URL::build('/vote'), 'top', null, $vote_order, $icon);
			break;
			case 2:
				// "More" dropdown
				$navs[0]->addItemToDropdown('more_dropdown', 'vote', $this->_vote_language->get('vote', 'vote'), URL::build('/vote'), 'top', null, $icon, $vote_order);
			break;
			case 3:
				// Footer
				$navs[0]->add('vote', $this->_vote_language->get('vote', 'vote'), URL::build('/vote'), 'footer', null, $vote_order, $icon);
			break;
		}

		if(defined('BACK_END')){
			if($user->hasPermission('admincp.vote')){
				$cache->setCache('panel_sidebar');
				if(!$cache->isCached('vote_order')){
					$order = 20;
					$cache->store('vote_order', 20);
				} else {
					$order = $cache->retrieve('vote_order');
				}

				if(!$cache->isCached('vote_icon')){
					$icon = '<i class="nav-icon fas fa-cogs"></i>';
					$cache->store('vote_icon', $icon);
				} else {
					$icon = $cache->retrieve('vote_icon');
				}
				
				$navs[2]->add('vote_divider', mb_strtoupper($this->_vote_language->get('vote', 'vote'), 'UTF-8'), 'divider', 'top', null, $order, '');
				$navs[2]->add('vote', $this->_vote_language->get('vote', 'vote'), URL::build('/panel/vote'), 'top', null, $order, $icon);
			}
		}
	}
}