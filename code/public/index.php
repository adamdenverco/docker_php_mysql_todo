<?php

// LOAD EXTERNAL SETTINGS
// load file
$external_settings = parse_ini_file( '../settings.ini', true );
// loop through settings
foreach( $external_settings as $prefix => $section ) {
	foreach( $section as $key=>$setting ) {
    $var = 'MY_' . strtoupper($prefix) . '_' . strtoupper($key);
		define( $var, $setting );
	}
}

// LOAD GENERAL FUNCTIONS
include_once __DIR__ . '/../misc/myfunctions.php';

// SET or CREATE USER based on IP ADDRESS
// - We're not going to have usernames and logins quite yet.
// - So we're going to keep track of user entered data via IP.
$user = new Ipuser();
$user->setOrCreateUserIdConstantBasedOnIpAddress();

// FIND AND LOAD CONTROLLER TYPE
// - extract "api" from url or use "page"
$urlType = (strtolower(trim((explode("/", $_SERVER['REQUEST_URI'])) [1])) == "api" ) ? "api" : "page";

// LOAD THE CONTROLLER
include_once __DIR__ . '/../controllers/'.$urlType.'.php';
