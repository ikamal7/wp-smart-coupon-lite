<?php

namespace KAMAL\WPSC\Frontend;

use WP_Query;

if ( !class_exists( 'WPSC_CouponShortcode' ) ) {
    class WPSC_CouponShortcode {
        public function __construct() {
            add_shortcode( 'wpsc_coupon', [$this, 'wpsc_coupon_shortcode'] );
            add_action( 'wp_enqueue_scripts', [$this, 'wpsc_assets'] );
        }

        /**
         * wpsc_assets
         *
         * @return void
         */
        public function wpsc_assets() {
            wp_enqueue_style( 'wpsc_coupon_style', WPSC_ASSETS . '/css/wpsc_coupon.css', null, time() );

        }

        /**
         * @param $atts
         * @param $content
         */
        public static function wpsc_coupon_shortcode( $atts, $content = null ) {
            extract(
                shortcode_atts( [
                    'id' => '',
                ], $atts )
            );

            ob_start();

            $args = [
                'post_type'      => 'wp_smart_coupon',
                'posts_per_page' => 1,
                'p'              => intval( $id ),
            ];
            $the_coupon = new WP_Query( $args );

            if ( $the_coupon->have_posts() ):

                while ( $the_coupon->have_posts() ): $the_coupon->the_post();
                    $coupon_type     = get_post_meta( get_the_ID(), 'coupon_type', true );
                    $coupon          = get_post_meta( get_the_ID(), 'coupon', true );
                    $coupon_url      = get_post_meta( get_the_ID(), 'coupon_url', true );
                    $discount_am     = get_post_meta( get_the_ID(), 'discount_am', true );
                    $description     = get_post_meta( get_the_ID(), 'description', true );
                    $coupon_exp      = get_post_meta( get_the_ID(), 'coupon_exp', true );
                    $exp_date        = get_post_meta( get_the_ID(), 'exp_date', true );
                    $hide_coupon     = get_post_meta( get_the_ID(), 'hide_coupon', true );
                    $coupon_template = get_post_meta( get_the_ID(), 'coupon_template', true );

                    echo pp_get_template_part( 'templates/template-1' );
                    ?>
								<?php
    endwhile;
                wp_reset_postdata();
            endif;
            return ob_get_clean();

        }
    }
}