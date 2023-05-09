<?php

declare(strict_types=1);

/*
Plugin Name: User Spotlight Pro
Plugin URI: https://github.com/asemdevs/Users-List-REST-API-Integration
Description: A WordPress plugin that displays an HTML table with users fetched from a JSON REST API.
Version: 1.0.0
Author: Asem Abdou
License: MIT
License URI: https://opensource.org/licenses/MIT
Text Domain: user-spotlight-pro
*/

require __DIR__ . '/vendor/autoload.php';

use UserSpotlightPro\UserSpotlightPro;

$user_spotlight_pro = new UserSpotlightPro();
$user_spotlight_pro->init();
$user_spotlight_pro->registerDeactivationHook(__FILE__);
