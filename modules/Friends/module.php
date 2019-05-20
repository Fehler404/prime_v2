<?php

/*
 *  Friends Module
 *  For NamelessMC v2-pr6 - https://namelessmc.com
 *  By Xemah - https://xemah.com
 */

class FriendsModule extends Module {
	private $_language;

	public function __construct($language, $pages, $user, $queries, $navigation, $cache, $smarty) {

		$name = 'Friends';
		$author = '<a href="https://xemah.com" target="_blank" rel="nofollow noopener">Xemah</a>';
		$module_version = '2.0.0-pr6';
		$nameless_version = '2.0.0-pr6';

		$this->_language = $language;
		$this->_queries = $queries;
		$this->_navigation = $navigation;
		$this->_cache = $cache;
		$this->_smarty = $smarty;

		parent::__construct($this, $name, $author, $module_version, $nameless_version);
	}

	public function onInstall(){

		try {
			$this->_queries->alterTable('friends', 'accepted', 'tinyint(1) NOT NULL DEFAULT 0');
		}
		catch(Exception $e) {
		}
		
	}

	public function onUninstall(){
	}

	public function onEnable(){
	}

	public function onDisable(){
	}

	public function onPageLoad($user, $pages, $cache, $smarty, $navs, $widgets, $template){

		$queries = $this->_queries;
		$smarty = $this->_smarty;
		$language = $this->_language;

		$user = new User();

		if (PAGE == "profile") {

			$profile = explode('/', rtrim($_GET['route'], '/'));
			$profile = $profile[count($profile) - 1];
			$profile = $queries->getWhere('users', array('username', '=', $profile));
			
			$smarty->assign('FRIENDS', $language->get('friends', 'friends'));

			include('includes/functions.php');
			include('includes/post.php');
			include('includes/template.php');

		}
	}
}