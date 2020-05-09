<?php

/*
 * Plugin Name: WP Smart Coupon & Deals
 * Plugin URI: https://pixedplugin.co/
 * Description:
 * Version: 1.0
 * Author: Pixel Plugin
 * Author URI: https://pixedplugin.co/
 * Text Domain: wpsc
 * Domain Path: /languages/
 * License: GNU General Public License v2 or later
 */

if ( !defined( 'ABSPATH' ) ) {
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';
//require_once __DIR__ . '/functions.php';

final class WPSC_Coupon_Deals {

    public function __construct() {
        $this->define_constant();

        register_activation_hook( __FILE__, [$this, 'activate'] );
        add_action( 'plugins_loaded', [$this, 'plugin_init'] );
        add_action( 'admin_enqueue_scripts', [$this, 'wpsc_admin_scripts'] );
    }

    /**
     * @return mixed
     */
    public static function init() {
        /**
         * @var mixed
         */
        static $instance = false;
        if ( !$instance ) {
            $instance = new self();
        }
        return $instance;

    }

    public function plugin_init() {
        new \KAMAL\WPSC\Admin\WPSC_CPT();
        new \KAMAL\WPSC\Admin\Coupon_Metabox();
        new \KAMAL\WPSC\Admin\Coupon_Taxonomy();
        new \KAMAL\WPSC\Admin\WPSC_Notice();
        new \KAMAL\WPSC\Admin\WPSC_Coupon_Columns();

        new \KAMAL\WPSC\Frontend\WPSC_CouponShortcode();
    }

    public function define_constant() {
        define( 'WPSC_VERSION', '1.0' );
        define( 'WPSC_FILE', __FILE__ );
        define( 'WPSC_PATH', __DIR__ );
        define( 'WPSC_URL', plugins_url( '', WPSC_FILE ) );
        define( 'WPSC_ASSETS', WPSC_URL . '/assets' );
        define( 'WPSC_ADMIN', WPSC_URL . '/admin' );
    }

    public function activate() {

    }

    public function deactivate() {

    }
    /**
     * @param $screen
     */
    public function wpsc_admin_scripts( $screen ) {
        if ( 'post.php' == $screen || 'post-new.php' == $screen ) {
            wp_enqueue_style( 'wpsc_coupon_style', WPSC_ADMIN . '/css/wpsc_coupon.css' );

            wp_enqueue_script( 'wpsc_script', WPSC_ADMIN . '/js/wpsc_admin_scripts.js', null, time(), true );
        }
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_style( 'jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true );
    }

} //End class

function run_wpsc_plugin() {
    return WPSC_Coupon_Deals::init();
}

run_wpsc_plugin();
