<?php
/*
 *	Made by Partydragen and Samerton
 *  https://github.com/partydragen/Vote-Module
 *  https://partydragen.com
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 */
 
// Always define page name
define('PAGE', 'vote');
$page_title = $vote_language->get('vote', 'vote');
require_once(ROOT_PATH . '/core/templates/frontend_init.php');

// Get message
$vote_message = $queries->getWhere("vote_settings", array("name", "=", "vote_message"));
$vote_message = $vote_message[0]->value;
	
// Is vote message empty?
if(!empty($vote_message)){
	$message_enabled = true;
}
	
// Get sites from database
$sites = $queries->getWhere("vote_sites", array("id", "<>", 0));
	
$sites_array = array();
foreach($sites as $site){
    $sites_array[] = array(
        'name' => Output::getClean($site->name),
        'url' => Output::getClean($site->site),
    );
}
	
// Assign Smarty variables
$smarty->assign(array(
	'VOTE_TITLE' => $vote_language->get('vote', 'vote'),
	'MESSAGE_ENABLED' => $message_enabled,
	'MESSAGE' => htmlspecialchars($vote_message),
	'SITES' => $sites_array,
));

// Load modules + template
Module::loadPage($user, $pages, $cache, $smarty, array($navigation, $cc_nav, $mod_nav), $widgets);

$page_load = microtime(true) - $start;
define('PAGE_LOAD_TIME', str_replace('{x}', round($page_load, 3), $language->get('general', 'page_loaded_in')));

$template->onPageLoad();

$smarty->assign('WIDGETS', $widgets->getWidgets());

require(ROOT_PATH . '/core/templates/navbar.php');
require(ROOT_PATH . '/core/templates/footer.php');
	
// Display template
$template->displayTemplate('vote.tpl', $smarty);
