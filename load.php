<?php
// absolute path indicates route directory, admin path indicates our admin folder, admin script path indicates our scripts folder
define('ABSPATH', __DIR__);
define('ADMIN_PATH', ABSPATH.'/admin');
define('ADMIN_SCRIPT_PATH', ADMIN_PATH.'/scripts');

// ini_set('display_errors', 1);
session_start();

// load the database connection
require_once ABSPATH.'/config/database.php';
require_once ADMIN_SCRIPT_PATH.'/login.php';
require_once ADMIN_SCRIPT_PATH.'/functions.php';
require_once ADMIN_SCRIPT_PATH.'/user.php';