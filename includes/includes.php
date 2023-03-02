<?php

if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

foreach ( glob( (__DIR__) . '/hooks/*.php' ) as $filename ) {
    require_once $filename;
}

foreach ( glob( (__DIR__) . '/functions/*.php' ) as $filename ) {
    require_once $filename;
}

// require views
foreach ( glob( (__DIR__) . '/views/*.php' ) as $filename ) {
    require_once $filename;
}
