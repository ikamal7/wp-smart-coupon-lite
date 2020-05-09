<?php
namespace KAMAL\WPSC\Admin;

class Coupon_Taxonomy {

    public function __construct() {
        add_action( 'init', [$this, 'create_category_tax'] );
        add_action( 'init', [$this, 'create_vendor_tax'] );
    }
    // Register Taxonomy Vendor
    public function create_vendor_tax() {

        $labels = array(
            'name'              => _x( 'Coupon Vendors', 'taxonomy general name', 'wpsc' ),
            'singular_name'     => _x( 'Coupon Vendor', 'taxonomy singular name', 'wpsc' ),
            'search_items'      => __( 'Search Vendors', 'wpsc' ),
            'all_items'         => __( 'All Vendors', 'wpsc' ),
            'parent_item'       => __( 'Parent Vendor', 'wpsc' ),
            'parent_item_colon' => __( 'Parent Vendor:', 'wpsc' ),
            'edit_item'         => __( 'Edit Vendor', 'wpsc' ),
            'update_item'       => __( 'Update Vendor', 'wpsc' ),
            'add_new_item'      => __( 'Add New Vendor', 'wpsc' ),
            'new_item_name'     => __( 'New Vendor Name', 'wpsc' ),
            'menu_name'         => __( 'Vendor', 'wpsc' ),
        );
        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Coupon Vendor', 'wpsc' ),
            'hierarchical'       => true,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_nav_menus'  => true,
            'show_tagcloud'      => true,
            'show_in_quick_edit' => true,
            'show_admin_column'  => false,
            'show_in_rest'       => true,
        );
        register_taxonomy( 'coupon_vendor', array( 'wp_smart_coupon' ), $args );

    }
    // Register Taxonomy Category
    function create_category_tax() {

        $labels = array(
            'name'              => _x( 'Coupon Categories', 'taxonomy general name', 'wpsc' ),
            'singular_name'     => _x( 'Coupon Category', 'taxonomy singular name', 'wpsc' ),
            'search_items'      => __( 'Search Categories', 'wpsc' ),
            'all_items'         => __( 'All Categories', 'wpsc' ),
            'parent_item'       => __( 'Parent Category', 'wpsc' ),
            'parent_item_colon' => __( 'Parent Category:', 'wpsc' ),
            'edit_item'         => __( 'Edit Category', 'wpsc' ),
            'update_item'       => __( 'Update Category', 'wpsc' ),
            'add_new_item'      => __( 'Add New Category', 'wpsc' ),
            'new_item_name'     => __( 'New Category Name', 'wpsc' ),
            'menu_name'         => __( 'Category', 'wpsc' ),
        );
        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Coupon Category', 'wpsc' ),
            'hierarchical'       => true,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_nav_menus'  => true,
            'show_tagcloud'      => true,
            'show_in_quick_edit' => true,
            'show_admin_column'  => false,
            'show_in_rest'       => true,
        );
        register_taxonomy( 'coupon_category', array( 'wp_smart_coupon' ), $args );

    }

}