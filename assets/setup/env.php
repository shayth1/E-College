<?php
// app vars
if (!defined('APP_NAME')) define('APP_NAME', 'E-College');
if (!defined('APP_ORGANIZATION')) define('APP_ORGANIZATION', 'WISE');
if (!defined('APP_OWNER')) define('APP_OWNER', 'Haneen, Dana, Nedal');
if (!defined('APP_DECRIPTION')) define('APP_DECRIPTION', 'E-College Learning System');
if (!defined('ALLOWED_INACTIVITY_TIME')) define('ALLOWED_INACTIVITY_TIME', time() + 1 * 60);
// db vars
if (!defined('DB_DATABASE')) define('DB_DATABASE', 'ecollege');
if (!defined('DB_HOST')) define('DB_HOST', '127.0.0.1');
if (!defined('DB_USERNAME')) define('DB_USERNAME', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
if (!defined('BD_PORT')) define('BD_PORT', '');
date_default_timezone_set('asia/amman');
//auto sending email