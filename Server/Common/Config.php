<?php
/**
 * This file contains configuration options.
 *
 * Constants are here for speed and ease of usage.
 */

//Constants for speedy array lookup/options
//Database Array

define('CF_DATABASE', 0);
define('CF_DB_HOST', 0);
define('CF_DB_PORT', 1);
define('CF_DB_USER', 2);
define('CF_DB_PASS', 3);
define('CF_DB_BASE', 4);
define('CF_DB_TYPE', 5);
define('CF_OUTPUT', 1);
define('CF_OP_COMPRESSION', 0);

//Database Types
define('DB_MYSQL', 0);

$_CONFIG = Array();
$_CONFIG[CF_DATABASE] = Array();

//Prepending a 'p:' here makes us use persistent connections.
$_CONFIG[CF_DATABASE][CF_DB_HOST] = 'p:localhost';
$_CONFIG[CF_DATABASE][CF_DB_PORT] = 3306;
$_CONFIG[CF_DATABASE][CF_DB_USER] = 'root';
$_CONFIG[CF_DATABASE][CF_DB_PASS] = '';
$_CONFIG[CF_DATABASE][CF_DB_BASE] = 'chrysellia';
$_CONFIG[CF_DATABASE][CF_DB_TYPE] = DB_MYSQL;

//Output Configuration
$_CONFIG[CF_OUTPUT] = array();
$_CONFIG[CF_OUTPUT][CF_OP_COMPRESSION] = true;
?>