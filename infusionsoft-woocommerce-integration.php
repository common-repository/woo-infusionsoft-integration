<?php
/*
Plugin Name:  Woocommerce infusionsoft integration
Plugin URI:   http://marketingautomationexpert24.com/winfint/
Description:     The infusionsoft woocommerce integratation plugin will allow to integrate your woocommerce store with infusionsoft.
Version:         1.0
Author:         Marketing Automation Expert 24
License:         GPL-2.0+ */
// Special Thanks to Novak Solution

    // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


require plugin_dir_path( __FILE__ ) . 'includes/options.php';
require plugin_dir_path( __FILE__ ) . 'includes/Infusionsoft/infusionsoft.php';


//adding option
add_action("admin_menu", "woocominfusnintrgn_add_option");

//creating panel fields
add_action("admin_init", "woocominfusnintrgn_panel_fields");

//creating connection
add_action('woocommerce_thankyou', 'woocominfusnintrgn_order_ext');



