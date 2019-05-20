<?php 
/*
 *	Made by Partydragen and Samerton
 *  https://github.com/partydragen/Vote-Module
 *  https://partydragen.com
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 *
 *  Vote module initialisation file
 */

// Initialise forum language
$vote_language = new Language(ROOT_PATH . '/modules/Vote/language', LANGUAGE);

// Initialise module
require_once(ROOT_PATH . '/modules/Vote/module.php');
$module = new Vote_Module($vote_language, $pages);