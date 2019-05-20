<?php 

/*
 *  Friends Module
 *  For NamelessMC v2-pr6 - https://namelessmc.com
 *  By Xemah - https://xemah.com
 */

$friendsLanguage = new Language(ROOT_PATH . '/modules/Friends/language', LANGUAGE);
require_once(ROOT_PATH . '/modules/Friends/module.php');
$module = new FriendsModule($friendsLanguage, $pages, $user, $queries, $navigation, $cache, $smarty);