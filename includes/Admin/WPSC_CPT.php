<?php
namespace KAMAL\WPSC\Admin;

class WPSC_CPT {

    public function __construct() {
        add_action( 'init', [$this, 'create_wpsmartcoupon_cpt'] );
    }
    // Register Custom Post Type WP Smart Coupon
    public function create_wpsmartcoupon_cpt() {

        $labels = array(
            'name'                  => _x( 'WP Smart Coupons', 'Post Type General Name', 'wpsc' ),
            'singular_name'         => _x( 'WP Smart Coupon', 'Post Type Singular Name', 'wpsc' ),
            'menu_name'             => _x( 'WP Smart Coupons', 'Admin Menu text', 'wpsc' ),
            'name_admin_bar'        => _x( 'WP Smart Coupon', 'Add New on Toolbar', 'wpsc' ),
            'archives'              => __( 'WP Smart Coupon Archives', 'wpsc' ),
            'attributes'            => __( 'WP Smart Coupon Attributes', 'wpsc' ),
            'parent_item_colon'     => __( 'Parent WP Smart Coupon:', 'wpsc' ),
            'all_items'             => __( 'Coupons', 'wpsc' ),
            'add_new_item'          => __( 'Add New Coupon/Deals', 'wpsc' ),
            'add_new'               => __( 'Add New Coupon', 'wpsc' ),
            'new_item'              => __( 'New WP Smart Coupon', 'wpsc' ),
            'edit_item'             => __( 'Edit WP Smart Coupon', 'wpsc' ),
            'update_item'           => __( 'Update WP Smart Coupon', 'wpsc' ),
            'view_item'             => __( 'View WP Smart Coupon', 'wpsc' ),
            'view_items'            => __( 'View WP Smart Coupons', 'wpsc' ),
            'search_items'          => __( 'Search WP Smart Coupon', 'wpsc' ),
            'not_found'             => __( 'Not found', 'wpsc' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'wpsc' ),
            'featured_image'        => __( 'Featured Image', 'wpsc' ),
            'set_featured_image'    => __( 'Set featured image', 'wpsc' ),
            'remove_featured_image' => __( 'Remove featured image', 'wpsc' ),
            'use_featured_image'    => __( 'Use as featured image', 'wpsc' ),
            'insert_into_item'      => __( 'Insert into WP Smart Coupon', 'wpsc' ),
            'uploaded_to_this_item' => __( 'Uploaded to this WP Smart Coupon', 'wpsc' ),
            'items_list'            => __( 'WP Smart Coupons list', 'wpsc' ),
            'items_list_navigation' => __( 'WP Smart Coupons list navigation', 'wpsc' ),
            'filter_items_list'     => __( 'Filter WP Smart Coupons list', 'wpsc' ),
        );
        $args = array(
            'label'               => __( 'WP Smart Coupon', 'wpsc' ),
            'description'         => __( 'for coupon ', 'wpsc' ),
            'labels'              => $labels,
            'menu_icon'           => 'dashicons-clipboard',
            'supports'            => array( 'title', 'thumbnail' ),
            'taxonomies'          => array(),
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'hierarchical'        => false,
            'exclude_from_search' => false,
            'show_in_rest'        => true,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
        );
        register_post_type( 'wp_smart_coupon', $args );

    }
}
