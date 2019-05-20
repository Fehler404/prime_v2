<?php
/*
 *	Made by Samerton
 *  https://github.com/samerton
 *  NamelessMC version 2.0.0-pr6
 *
 *  License: MIT
 *
 *  Websend hook class
 */

class WSHook {
	private static $_events = array();
	private static $_ws = null;

	public static function setEvents($events){
		self::$_events = $events;
	}

	public static function initWebsend($conf){
		self::$_ws = new Websend($conf['websend_server_address'], $conf['websend_server_port']);
		self::$_ws->setPassword($conf['websend_password']);
	}

	public static function execute($params = array()){
		if(!isset($params['event']) || is_null(self::$_ws)){
			return false;
		}

		if(array_key_exists($params['event'], self::$_events)){
			$event = self::$_events[$params['event']];

			if(count($event)){
				$event_params = HookHandler::getHook($params['event']);
				$event_params = $event_params['params'];

				$event_param_keys = array();
				$event_param_values = array();
				if(count($event_params)){
					foreach($event_params as $key => $event_param){
						$event_param_keys[] = '{' . $key . '}';
						$event_param_values[] = $params[$key];
					}
				}

				if(self::$_ws->connect()){
					foreach($event as $command){
						self::$_ws->doCommandAsConsole(str_ireplace($event_param_keys, $event_param_values, $command));
					}
				}

				self::$_ws->disconnect();

				return true;
			}
		}

		return false;

	}
}