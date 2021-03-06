<?php
$GLOBALS['config'] = array(
		"config"=>array("name" => "Social-Media"),
		"mysql" => array(
		"host" => "127.0.0.1", //127.0.0.1.
		"user" => "root", //root
		"password" => "", //password
		"db" => "1064t", //social-media
		"port" => "3306", //3306
	),
	"remember" => array(
		"expiry" => 604800,
	),
	"session" => array (
		"token_name" => "robotics",
		"cookie_name"=>"robotics",
		"session_name"=>"robotics"
	),
);
//Uncomment the following if the installation didn't add the code.
/*
$GLOBALS['config'] = array(
	"config"=>array("name" => "Socal-Media"),
	"mysql" => array(
		"host" => "127.0.0.1", //127.0.0.1
		"user" => "root", //root
		"password" => "", //password
		"db" => "social-media", //social-media
		"port" => "3306", //3306
	),
	"remember" => array(
		"expiry" => 604800,
	),
	"session" => array (
		"token_name" => "token_sm",
		"cookie_name"=>"cookie_sm",
		"session_name"=>"session_sm"
	),
);
 */

session_start();

spl_autoload_register(function($class){
	require 'inc/classes/'.$class.'.class.php';
});
require_once 'functions.php';

if(!empty($GLOBALS['config']) && !file_exists('/pages/install/install.php')){
	$db = DB::getInstance();
	if(Cookies::exists(Config::get('session/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
		$hash = Cookies::get(Config::get('session/cookie_name'));
		$hashCheck= $db->get('user_session', array('hash','=',$hash));
		if($hashCheck->count()){
			$user = new User($hashCheck->first()->user_id);
			$user->login();
		}
	}

	//Error Reporting
	ini_set('diplay_errors', Setting::get('debug'));
	$error_reporting =(Setting::get('debug') == 'Off')? '0':'-1';
	error_reporting($error_reporting);

	//if we didnt set a unique id then lets make one.
	if(Setting::get('unique_id') == null || Setting::get('unique_id') == ""){
		Setting::update('unique_id', substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0,62));
	}

	$user = new User();
	if($user->isLoggedIn()){

		if($user->data()->banned == 1){
			$user->logout();
		} 

		//Get the IP. Update it to our databases.
		$ip = $user->getIP();
		if(filter_var($ip, FILTER_VALIDATE_IP)){
			$user->update(array(
				'last_ip' => $ip
			));
		}

		// Update online status
		$user->update([
			'last_online'=> date('Y-m-d H:i:s'),
		]);
	}
	unset($user);
}