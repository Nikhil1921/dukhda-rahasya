<?php defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

switch ($_SERVER['SERVER_NAME']) {
    case 'www.dukhdarahasya.co':
    case 'dukhdarahasya.co':
    case 'https://www.dukhdarahasya.co':
    case 'https://dukhdarahasya.co':
        $db['default'] = array(
            'dsn'   => '',
            'hostname' => 'localhost',
            'username' => 'labmajol_dukhdarahasya',
            'password' => 'dukhdarahasya@lm2525',
            'database' => 'labmajol_new_dukhdarahasya',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => (ENVIRONMENT !== 'production'),
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
        break;
    case 'www.test.dukhdarahasya.co':
    case 'test.dukhdarahasya.co':
    case 'https://www.test.dukhdarahasya.co':
    case 'https://test.dukhdarahasya.co':
        $db['default'] = array(
            'dsn'   => '',
            'hostname' => 'localhost',
            'username' => 'labmajol_demo',
            'password' => 'Densetek@2018',
            'database' => 'labmajol_test_dukhdarahasya',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => (ENVIRONMENT !== 'production'),
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
        break;
    
    default:
        $db['default'] = array(
            'dsn'   => '',
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'dukhdarahasya',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => (ENVIRONMENT !== 'production'),
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );
        break;
}