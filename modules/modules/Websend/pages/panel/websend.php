<?php
/*
 *	Made by Samerton
 *  https://github.com/NamelessMC/Nameless/
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 *
 *  Websend configuration page
 */

// Can the user view the panel?
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
		if(!$user->hasPermission('admincp.websend')){
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
define('PARENT_PAGE', 'websend');
define('PANEL_PAGE', 'websend');
$page_title = $websend_language->get('language', 'websend');
require_once(ROOT_PATH . '/core/templates/backend_init.php');

// Load modules + template
Module::loadPage($user, $pages, $cache, $smarty, array($navigation, $cc_nav, $mod_nav), $widgets);

if(isset($_GET['hook'])){
	$hook = HookHandler::getHook($_GET['hook']);

	if(!$hook){
		Redirect::to(URL::build('/panel/websend'));
		die();
	}

	$db_hook = $queries->getWhere('websend_commands', array('hook', '=', Output::getClean($_GET['hook'])));
	if(count($db_hook))
		$db_hook = $db_hook[0];
	else
		$db_hook = null;

	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			if(isset($_POST['enable_hook']) && $_POST['enable_hook'] == 'on')
				$enabled = 1;
			else
				$enabled = 0;

			if(isset($_POST['commands']))
				$commands = $_POST['commands'];
			else
				$commands = '';

			if(is_null($db_hook)){
				$queries->create('websend_commands', array(
					'hook' => $_GET['hook'],
					'commands' => $commands,
					'enabled' => $enabled
				));
			} else {
				$queries->update('websend_commands', $db_hook->id, array(
					'commands' => $commands,
					'enabled' => $enabled
				));
			}

			$db_hook = $queries->getWhere('websend_commands', array('hook', '=', Output::getClean($_GET['hook'])));
			$db_hook = $db_hook[0];

		} else
			$errors = array($language->get('general', 'invalid_token'));
	}

	$hooks = array();
	if(count($hook['params'])){
		foreach($hook['params'] as $param => $desc){
			$hooks[Output::getClean($param)] = Output::getClean($desc);
		}
	}

	$smarty->assign(array(
		'HOOK_DESCRIPTION' => Output::getClean($hook['description']),
		'ENABLE_HOOK' => $websend_language->get('language', 'enable_hook'),
		'HOOK_ENABLED' => (!is_null($db_hook) && $db_hook->enabled == 1),
		'COMMANDS_INFO' => $websend_language->get('language', 'commands_information'),
		'HOOKS' => $hooks,
		'COMMANDS' => $websend_language->get('language', 'commands'),
		'COMMANDS_VALUE' => (!is_null($db_hook)) ? Output::getClean($db_hook->commands) : '',
		'INFO' => $language->get('general', 'info'),
		'BACK' => $language->get('general', 'back'),
		'BACK_LINK' => URL::build('/panel/websend')
	));

	$template->addCSSFiles(array(
		(defined('CONFIG_PATH') ? CONFIG_PATH : '') . '/core/assets/plugins/switchery/switchery.min.css' => array()
	));

	$template->addJSFiles(array(
		(defined('CONFIG_PATH') ? CONFIG_PATH : '') . '/core/assets/plugins/switchery/switchery.min.js' => array()
	));

	$template->addJSScript('
		var elems = Array.prototype.slice.call(document.querySelectorAll(\'.js-switch\'));

		elems.forEach(function(html) {
		  var switchery = new Switchery(html, {color: \'#23923d\', secondaryColor: \'#e56464\'});
		});
	');

	$template_file = 'websend/websend_hook.tpl';

} else {
	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			$address = (isset($_POST['address']) ? $_POST['address'] : '');
			$port = (isset($_POST['port']) ? (int)$_POST['port'] : 4445);
			$password = (isset($_POST['password']) ? $_POST['password'] : $ws_config['websend_password']);

			$ws_conf =  '<?php' . PHP_EOL .
				'$ws_config = array(' . PHP_EOL .
				'   \'websend_server_address\' => \'' . $address . '\',' . PHP_EOL .
				'   \'websend_server_port\' => ' . $port . ',' . PHP_EOL .
				'   \'websend_password\' => \'' . $password . '\'' . PHP_EOL .
				');';

			if(file_put_contents(ROOT_PATH . '/modules/Websend/config.php', $ws_conf) === false){
				$errors = array($websend_language->get('language', 'unable_to_create_config'));

			} else {
				Redirect::to(URL::build('/panel/websend'));
				die();
			}


		} else
			$errors = array($language->get('general', 'invalid_token'));
	}

	// Get hooks
	$hookQuery = $queries->getWhere('websend_commands', array('enabled', '=', 1));

	$hooks = array();
	foreach($hookQuery as $hook){
		$hooks[] = $hook->hook;
	}

	$all_hooks = HookHandler::getHooks();
	$template_hooks = array();

	foreach($all_hooks as $hook => $description){
		$template_hooks[] = array(
			'link' => URL::build('/panel/websend/', 'hook=' . Output::getClean($hook)),
			'description' => Output::getClean($description),
			'enabled' => in_array($hook, $hooks)
		);
	}

	if(!isset($ws_config) && file_exists(ROOT_PATH . '/modules/Websend/config.php')){
		require_once(ROOT_PATH . '/modules/Websend/config.php');
	}

	$smarty->assign(array(
		'AVAILABLE_HOOKS' => $websend_language->get('language', 'available_hooks'),
		'HOOKS' => $template_hooks,
		'ENABLED' => $websend_language->get('language', 'enabled'),
		'DISABLED' => $websend_language->get('language', 'disabled'),
		'CONNECTION_DETAILS' => $websend_language->get('language', 'connection_details'),
		'CONNECTION_ADDRESS' => $websend_language->get('language', 'connection_address'),
		'CONNECTION_ADDRESS_VALUE' => Output::getClean($ws_config['websend_server_address']),
		'CONNECTION_PORT' => $websend_language->get('language', 'connection_port'),
		'CONNECTION_PORT_VALUE' => Output::getClean($ws_config['websend_server_port']),
		'CONNECTION_PASSWORD' => $websend_language->get('language', 'connection_password')
	));

	$template_file = 'websend/websend.tpl';

}

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

$smarty->assign(array(
	'PARENT_PAGE' => PARENT_PAGE,
	'DASHBOARD' => $language->get('admin', 'dashboard'),
	'WEBSEND' => $websend_language->get('language', 'websend'),
	'PAGE' => PANEL_PAGE,
	'TOKEN' => Token::get(),
	'SUBMIT' => $language->get('general', 'submit')
));

$page_load = microtime(true) - $start;
define('PAGE_LOAD_TIME', str_replace('{x}', round($page_load, 3), $language->get('general', 'page_loaded_in')));

$template->onPageLoad();

require(ROOT_PATH . '/core/templates/panel_navbar.php');

// Display template
$template->displayTemplate($template_file, $smarty);