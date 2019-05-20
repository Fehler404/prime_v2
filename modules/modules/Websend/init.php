<?php
/*
 *	Made by Samerton
 *  https://github.com/samerton
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 *
 *  Websend initialisation file
 */

// Language
$websend_language = new Language(ROOT_PATH . '/modules/Websend/language', LANGUAGE);

require_once(ROOT_PATH . '/modules/Websend/module.php');
$module = new Websend_Module($pages, $language, $websend_language, $queries, $cache);