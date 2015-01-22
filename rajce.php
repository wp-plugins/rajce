<?php

/*
 * Plugin Name:       Rajce
 * Plugin URI:        http://www.venca-x.cz
 * Description:       Plugin pro zobrazení galerií z http://www.rajce.idnes.cz
 * Version:           0.0.1
 * Author:            vEnCa-X
 * Author URI:        http://www.venca-x.cz
 * License:           MIT
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, then abort execution.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Include bootstrap
 */
require_once plugin_dir_path( __FILE__ ) . 'WPFW/bootstrap.php';

require_once plugin_dir_path( __FILE__ ) . 'includes/rajce_widget.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/widget.php';


function run_rajce()
{
    new rajce_widget();
}

run_rajce();

