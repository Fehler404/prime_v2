<?php
/*
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 *
 */

if($user->isLoggedIn()){
	if(!$user->canViewACP()){
		// No
		Redirect::to(URL::build('/'));
		die();
	}
	if(!$user->isAdmLoggedIn()){
		// Needs to authenticate
		Redirect::to(URL::build('/panel/auth'));
		die();
	} else {
		if($user->data()->group_id != 2 && !$user->hasPermission('admincp.monarch')){
			require_once(ROOT_PATH . '/404.php');
			die();
		}
	}
} else {
	// Not logged in
	Redirect::to(URL::build('/login'));
	die();
}

define('PAGE', 'panel');
define('PARENT_PAGE', 'monarch');
define('PANEL_PAGE', 'monarch');
$page_title = $monarch_language->get('language', 'monarch_title');
require_once(ROOT_PATH . '/core/templates/backend_init.php');

if(isset($_POST['view'])){
	if(Token::check(Input::get('token'))){
		// Header
		$view = $_POST['view']; 
		$getTheme = $_POST['theme']; 
		$getBG = $_POST['bg'];
		$getNavbarBgPosition = $_POST['bgposition']; 
		$getLOGO = $_POST['logo']; 

	} else
		$errors = array($language->get('general', 'invalid_token'));
} else
	$view = null;

if($view == "update"){
	$f = fopen(ROOT_PATH . "/modules/Monarch/pages/settings.php","w");
	require ROOT_PATH . '/modules/Monarch/pages/settings.default.php';

	if(fwrite($f, $settings_inf) > 0){
		fclose($f);

		Session::flash('monarch_success', $monarch_language->get('language', 'successfully_updated'));

		Redirect::to(URL::build('/panel/monarch'));
		die();

	} else
		$errors = array($monarch_language->get('language', 'unable_to_write_to_settings'));

}

// Load modules + template
Module::loadPage($user, $pages, $cache, $smarty, array($navigation, $cc_nav, $mod_nav), $widgets);

if(Session::exists('monarch_success'))
	$success = Session::flash('monarch_success');

if(isset($success))
	$smarty->assign(array(
		'SUCCESS' => $success,
		'SUCCESS_TITLE' => $language->get('general', 'success')
	));

if(isset($errors) && count($errors))
	$smarty->assign(array(
		'ERRORS' => $errors,
		'ERRORS_TITLE' => $language->get('general', 'error')
	));

require ROOT_PATH . '/modules/Monarch/pages/settings.php';
// Header
$getNavbarTheme = MONARCH_THEME;
$getNavbarBg = MONARCH_BG;
$getNavbarBgPosition = MONARCH_BG_POSITION;
$getNavbarLogo = MONARCH_LOGO;


$smarty->assign(array(
	// Header
	'PARENT_PAGE' => PARENT_PAGE,
	'DASHBOARD' => $language->get('admin', 'dashboard'),
	'MONARCH' => $monarch_language->get('language', 'monarch_title'),
	'PAGE' => PANEL_PAGE,
	'TOKEN' => Token::get(),
	'SUBMIT' => $language->get('general', 'submit'),
	'NAV_THEME_VALUE' => $getNavbarTheme,
	'HEADER_BG_VALUE' => $getNavbarBg,
	'HEADER_BG_POSITION' => $getNavbarBgPosition,
	'LOGO_VALUE' => $getNavbarLogo,
	
	// Header
	'NAV_THEME' => $monarch_language->get('language', 'theme'),
	'HEADER_BG' => $monarch_language->get('language', 'header_background'),
	'HEADER_BG_PLACEHOLDER' => $monarch_language->get('language', 'header_background__position_placeholder'),
	'HEADER_BG_POSITION' => $monarch_language->get('language', 'header_background_position'),
	'HEADER_BG_POSITION_PLACEHOLDER' => $monarch_language->get('language', 'header_background_position'),
	'LOGO' => $monarch_language->get('language', 'logo'),
	'LOGO_PLACEHOLDER' => $monarch_language->get('language', 'logo_placeholder'),

	// Thems
	'MONARCH' => $monarch_language->get('language', 'monarch'),
	'SOMEWHATORANGE' => $monarch_language->get('language', 'somewhatorange'),
	'RED' => $monarch_language->get('language', 'red'),
	'DARKRED' => $monarch_language->get('language', 'darkred'),
	'AQUA' => $monarch_language->get('language', 'aqua'),
	'BLUE' => $monarch_language->get('language', 'blue'),
	'DARKBLUE' => $monarch_language->get('language', 'darkblue'),
	'GREEN' => $monarch_language->get('language', 'green'),
	'DARKGREEN' => $monarch_language->get('language', 'darkgreen'),
	'GOLD' => $monarch_language->get('language', 'gold'),
	'ORANGE' => $monarch_language->get('language', 'orange'),
	'BROWN' => $monarch_language->get('language', 'brown'),
	'PINK' => $monarch_language->get('language', 'pink'),
	'PURPLE' => $monarch_language->get('language', 'purple'),
	'GRAY' => $monarch_language->get('language', 'gray'),
	'BLACK' => $monarch_language->get('language', 'black'),
));

$page_load = microtime(true) - $start;
define('PAGE_LOAD_TIME', str_replace('{x}', round($page_load, 3), $language->get('general', 'page_loaded_in')));
$template->onPageLoad();
require(ROOT_PATH . '/core/templates/panel_navbar.php');
$template->displayTemplate('monarch/index.tpl', $smarty);