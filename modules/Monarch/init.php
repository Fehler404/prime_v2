<?php 
/*
 *  NamelessMC version 2.0.0-pre6
 *
 *  License: MIT
 *
 */

// Custom language
$monarch_language = new Language(ROOT_PATH . '/modules/Monarch/language', LANGUAGE);

// Add link to admin sidebar - temp
if(!isset($admin_sidebar)) $admin_sidebar = array();
$admin_sidebar['monarch'] = array(
	'title' => $monarch_language->get('language', 'monarch_title'),
	'url' => URL::build('/admin/monarch')
);

require_once(ROOT_PATH . '/modules/Monarch/module.php');
$module = new Monarch_Module($pages, $language, $monarch_language);