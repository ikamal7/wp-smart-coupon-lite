<?php
namespace KAMAL\WPSC\Admin;

if ( !class_exists( 'WPSC_Coupon_Columns' ) ) {
    class WPSC_Coupon_Columns {
        public function __construct() {
            add_filter( 'manage_wp_smart_coupon_posts_columns', [$this, 'wpsc_coupon_columns'] );
            add_filter( 'manage_wp_smart_coupon_posts_custom_column', [$this, 'wpsc_coupon_column'], 10, 2 );
            add_filter( 'manage_edit-wp_smart_coupon_sortable_columns', [$this, 'wpsc_sortable_columns'], 10, 2 );
            add_action( 'pre_get_posts', [$this, 'wpsc_coupon_orderby'] );
        }
        /**
         * @param  $query
         * @return null
         */
        public static function wpsc_coupon_orderby( $query ) {
            if ( !is_admin() || !$query->is_main_query() ) {
                return;
            }

            if ( 'coupon_type' === $query->get( 'orderby' ) ) {
                $query->set( 'orderby', 'meta_value' );
                $query->set( 'meta_key', 'coupon_type' );
            }
        }

        /**
         * wpsc_coupon_columns
         *
         * @param  mixed  $columns
         * @return void
         */
        public static function wpsc_coupon_columns( $columns ) {

            unset( $columns['date'] );
            $columns['coupon_type']       = __( 'Coupon Type', 'wpsc' );
            $columns['coupon_cat']        = __( 'Category', 'wpsc' );
            $columns['coupon_ven']        = __( 'Vendor', 'wpsc' );
            $columns['coupon_id']         = __( 'ID', 'wpsc' );
            $columns['coupon_shortcodes'] = __( 'Shortcodes', 'wpsc' );
            $columns['coupon_exp']        = __( 'Expires', 'wpsc' );

            return $columns;
        }
        /**
         * @param  $columns
         * @return mixed
         */
        public function wpsc_sortable_columns( $columns ) {
            $columns['coupon_type'] = 'coupon_type';
            return $columns;
        }

        /**
         * wpsc_coupon_column
         *
         * @param  mixed  $column
         * @param  mixed  $post_id
         * @return void
         */
        public static function wpsc_coupon_column( $column, $post_id ) {
            switch ( $column ) {
            case 'coupon_type':
                echo get_post_meta( $post_id, 'coupon_type', true );
                break;
            case 'coupon_cat':
                $terms = get_the_term_list( $post_id, 'coupon_category', '', ',', '' );
                if ( is_string( $terms ) ) {
                    echo $terms;
                } else {
                    _e( 'Didn\'t set Category', 'wpsc' );
                }
                break;
            case 'coupon_ven':
                $terms = get_the_term_list( $post_id, 'coupon_vendor', '', ',', '' );
                if ( is_string( $terms ) ) {
                    echo $terms;
                } else {
                    _e( 'Didn\'t set Vendor', 'wpsc' );
                }
                break;
            case 'coupon_id':
                echo (int) $post_id;
                break;
            case 'coupon_shortcodes':
                echo "[wpsc_coupon id ={$post_id}]";
                echo "[wpsc_code id ={$post_id}]";
                break;
            case 'coupon_exp':
                $coupon_exp = get_post_meta( $post_id, 'coupon_exp', true );
                $exp_date   = get_post_meta( $post_id, 'exp_date', true );
                if ( true == $coupon_exp && !empty( $exp_date ) ) {
                    echo $exp_date;
                }
                break;
            }

        }

    }
}