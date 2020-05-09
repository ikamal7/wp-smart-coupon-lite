<?php
namespace KAMAL\WPSC\Admin;

if ( !class_exists( 'WPSC_Notice' ) ) {
    class WPSC_Notice {
        /**
         * __construct adding action & filter hook
         *
         * @return void
         */
        public function __construct() {
            add_action( 'admin_notices', [$this, 'wpsc_review_notice'], 20 );
            add_filter( 'post_updated_messages', [$this, 'update_message'] );
            add_action( 'wp_ajax_wpscReviewNoticeHide', [$this, 'wpsc_hide_revew_notice'] );
        }

        public static function wpsc_review_notice() {
            $coupon_count  = wp_count_posts( 'wp_smart_coupon' );
            $coupon_number = $coupon_count->publish;
            if ( $coupon_number >= 10 && get_option( 'wpsc_review_notify' ) == "no" ) {
                ?>
                <div class="wpsc-review-notice notice notice-info">
                <p style="font-size: 14px;">
					<?php _e( 'Hey,<br> I noticed you have already created ' . $coupon_number . ' coupons with WP Coupons and Deals plugin - that’s awesome! Could you please do me a BIG favor and <b>give it a 5-star rating on WordPress</b>? Just to help us spread the word and boost our motivation. <br>~ Imtiaz Rayhan', 'wpsc-coupon' );?>
                </p>
                <ul>
                    <li><a style="margin-right: 5px; margin-bottom: 5px;" class="button-primary"
                           href="https://wordpress.org/support/plugin/wp-coupons-and-deals/reviews/#new-post"
                           target="_blank">Sure,
                            you deserve it.</a>
                        <a style="margin-right: 5px;" class="wpsc_HideReview_Notice button" href="javascript:void(0);">
                            I already did.</a>
                        <a class="wpsc_HideReview_Notice button" href="javascript:void(0);">No, not good enough.</a>
                    </li>
                </ul>
            </div>
            <script>
                jQuery(document).ready(function ($) {
                    jQuery('.wpsc_HideReview_Notice').click(function () {
                        var data = {'action': 'wpscReviewNoticeHide'};
                        jQuery.ajax({
                            url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
                            type: "post",
                            data: data,
                            dataType: "json",
                            async: !0,
                            success: function (notice_hide) {
                                if (notice_hide == "success") {
                                    jQuery('.wpsc-review-notice').slideUp('fast');
                                }
                            }
                        });
                    });
                });
            </script>
            <?php
}
        }
        /**
         * wpsc_hide_revew_notice
         *
         * @return void
         */
        public static function wpsc_hide_revew_notice() {
            update_option( 'wpsc_review_notify', 'yes' );
            echo json_encode( array( "success" ) );
            exit;
        }

        /**
         * @param  $message
         * @return mixed
         */
        public static function update_message( $message ) {
            $post                       = get_post();
            $full_coupon                = esc_attr( "[wpsc_coupon id ={$post->ID}]" );
            $only_coupon                = esc_attr( "[wpsc_code id ={$post->ID}]" );
            $only_code                  = '';
            $message['wp_smart_coupon'] = [
                0  => '', // Unused. Messages start at index 1.
                1  => __( 'Coupon updated.', 'text-domain' ),
                2  => '',
                3  => '',
                4  => __( 'Coupon updated.', 'text-domain' ),
                5  => isset( $_GET['revision'] ) ? sprintf( __( 'Coupon restored to revision from %s', 'text-domain' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
                6  => sprintf(
                    __( 'Coupon published. <br><br> Here are the shortcodes for this coupon: %s and %s ', 'text-domain' ),
                    $full_coupon, $only_code
                ),
                7  => __( 'Coupon saved.', 'text-domain' ),
                8  => __( 'Coupon submitted.', 'text-domain' ),
                9  => sprintf(
                    __( 'Coupon scheduled for: <strong>%1$s</strong>.', 'text-domain' ),
                    date_i18n( __( 'M j, Y @ G:i', 'text-domain' ), strtotime( $post->post_date ) )
                ),
                10 => __( 'Coupon draft updated.', 'text-domain' ),
            ];
            //print_r($message);

            return $message;

        }
    }
}

?>