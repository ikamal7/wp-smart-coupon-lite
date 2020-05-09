<?php

namespace KAMAL\WPSC\Admin;
if ( !class_exists( 'Coupon_Metabox' ) ) {
    class Coupon_Metabox {

        public function __construct() {

            if ( is_admin() ) {
                add_action( 'load-post.php', [$this, 'init_metabox'] );
                add_action( 'load-post-new.php', [$this, 'init_metabox'] );
            }

        }

        public function init_metabox() {

            add_action( 'add_meta_boxes', [$this, 'add_metabox'] );
            add_action( 'save_post', [$this, 'save_metabox'], 10, 2 );

        }

        /**
         * add_metabox
         *
         * @return void
         */
        public function add_metabox() {

            add_meta_box(
                'coupon_info',
                __( 'Coupon Info', 'text_domain' ),
                array( $this, 'render_metabox' ),
                'wp_smart_coupon',
                'advanced',
                'default'
            );

            add_meta_box(
                'coupon_preview',
                __( 'Coupon Preview' ),
                array( $this, 'render_preview' ),
                'wp_smart_coupon',
                'advanced',
                'default'
            );
            add_meta_box(
                'coupon_shortcode',
                __( 'Coupon Shortcode' ),
                array( $this, 'render_shortcode' ),
                'wp_smart_coupon',
                'side',
                'high'
            );
            add_meta_box(
                'coupon_help',
                __( 'Help' ),
                array( $this, 'render_help' ),
                'wp_smart_coupon',
                'side',
                'high'
            );

        }

        /**
         * render_metabox
         *
         * @param  mixed  $post
         * @return void
         */
        public function render_metabox( $post ) {

            // Add nonce for security and authentication.
            wp_nonce_field( 'coupon_nonce_action', 'coupon_nonce' );
            // Retrieve an existing value from the database.
            $coupon_type     = get_post_meta( $post->ID, 'coupon_type', true );
            $coupon          = get_post_meta( $post->ID, 'coupon', true );
            $coupon_url      = get_post_meta( $post->ID, 'coupon_url', true );
            $discount_am     = get_post_meta( $post->ID, 'discount_am', true );
            $description     = get_post_meta( $post->ID, 'description', true );
            $coupon_exp      = get_post_meta( $post->ID, 'coupon_exp', true );
            $exp_date        = get_post_meta( $post->ID, 'exp_date', true );
            $hide_coupon     = get_post_meta( $post->ID, 'hide_coupon', true );
            $coupon_template = get_post_meta( $post->ID, 'coupon_template', true );

            // Set default values.
            if ( empty( $coupon_type ) ) {
                $coupon_type = '';
            }
            if ( empty( $coupon ) ) {
                $coupon = '';
            }
            if ( empty( $coupon ) ) {
                $coupon = '';
            }
            if ( empty( $coupon_url ) ) {
                $coupon_url = '';
            }
            if ( empty( $discount_am ) ) {
                $discount_am = '';
            }
            if ( empty( $description ) ) {
                $description = '';
            }
            if ( empty( $coupon_exp ) ) {
                $coupon_exp = '';
            }
            if ( empty( $exp_date ) ) {
                $exp_date = '';
            }
            if ( empty( $hide_coupon ) ) {
                $hide_coupon = '';
            }
            if ( empty( $coupon_template ) ) {
                $coupon_template = '';
            }
            ?>
            <!-- Form fields. -->
            <table class="form-table">
                <!-- Coupon type -->
                <tr>
                    <th>
                        <label for="coupon_type" class=""><?php echo __( 'Coupon type', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Coupon Type">?</span>
                        </label>
                    </th>
                    <td>
                        <select name="coupon_type" id="coupon_type">
                            <option value="Coupon" <?php selected( $coupon_type, 'Coupon', true );?>>Coupon</option>
                            <option value="Deals" <?php selected( $coupon_type, 'Deals', true );?>>Deals</option>
                        </select>
                    </td>
                </tr>
                <!-- Coupon Code field -->
                <tr>
                    <th><label for="coupon" class="coupon_deals"><?php echo __( 'Coupon Code', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Coupon Code">?</span>
                        </label></th>
                    <td>
                        <input type="text" id="coupon" name="coupon"
                            placeholder="<?php echo esc_attr__( 'Coupon Code', 'text_domain' ) ?>"
                            value="<?php echo esc_attr__( $coupon, 'text-domain' ); ?>">
                    </td>
                </tr>
                <!-- Coupon URL field -->
                <tr>
                    <th><label for="coupon_url" class=""><?php echo __( 'Coupon Link', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Coupon Link">?</span>
                        </label></th>
                    <td>
                        <input type="url" id="coupon_url" name="coupon_url" class="regular-text"
                            placeholder="<?php echo esc_attr__( 'Coupon Link', 'text_domain' ) ?>"
                            value="<?php echo esc_attr__( $coupon_url, 'text-domain' ); ?>">
                    </td>
                </tr>
                <!-- Discount Amount field -->
                <tr>
                    <th><label for="discount_am" class=""><?php echo __( 'Discount Amount', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Discount Amount">?</span>
                        </label></th>
                    <td>
                        <input type="text" id="discount_am" name="discount_am" class="regular-text"
                            placeholder="<?php echo esc_attr__( 'Discount Amount', 'text_domain' ) ?>"
                            value="<?php echo esc_attr__( $discount_am, 'text-domain' ); ?>">
                    </td>
                </tr>
                <!-- Description field -->
                <tr>
                    <th><label for="description" class=""><?php echo __( 'Description', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Description">?</span>
                        </label></th>
                    <td>
                        <?php wp_editor( $description, 'description',
                [
                    'media_buttons' => false,
                    'textarea_name' => 'description',
                    'textarea_rows' => 5,
                    'teeny'         => true,
                ]
            );?>
                    </td>
                </tr>
                <!-- Coupon Expiration -->
                <tr>
                    <th>
                        <label for="coupon_exp" class=""><?php echo __( 'Coupon Expiration', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Coupon Expiration">?</span>
                        </label>
                    </th>
                    <td>
                        <select name="coupon_exp" id="coupon_exp">
                            <option value="1" <?php selected( $coupon_exp, '1', true );?>>Yes</option>
                            <option value="0" <?php selected( $coupon_exp, '0', true );?>>No</option>
                        </select>
                    </td>
                </tr>
                <!-- Expire Date field -->
                <tr>
                    <th><label for="exp_date" class=""><?php echo __( 'Expire Date', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Expire Date">?</span>
                        </label></th>
                    <td>
                        <input type="text" id="exp_date" name="exp_date" class="exp_date"
                            placeholder="<?php echo esc_attr__( 'Expire Date', 'text_domain' ) ?>"
                            value="<?php echo esc_attr__( $exp_date, 'text-domain' ); ?>">
                    </td>
                </tr>
                <!-- Hide Coupon -->
                <tr>
                    <th><label for="hide_coupon" class=""><?php echo __( 'Hide Coupon', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Hide Coupon">?</span>
                        </label></th>
                    <td>
                        <input type="checkbox" id="hide_coupon" name="hide_coupon" class="hide_coupon"
                            placeholder="<?php echo esc_attr__( 'Hide Coupon', 'text_domain' ) ?>" <?php checked( $hide_coupon, 'checked', true );?>>
                        <label for="hide_coupon">Yes</label>
                    </td>
                </tr>
                <!-- Coupon Templates -->
                <tr>
                    <th>
                        <label for="coupon_template" class=""><?php echo __( 'Coupon Templates', 'text_domain' ); ?>
                            <span class="tooltip" data-tooltip="Coupon Templates">?</span>
                        </label>
                    </th>
                    <td>
                        <select name="coupon_template" id="coupon_template">
                            <?php

            for ( $i = 1; $i < 10; $i++ ) {
                printf( '<option value="%s" %s>%s %s</option>',
                    esc_attr__( $i ),
                    esc_attr( selected( $coupon_template, $i, true ) ),
                    esc_attr( 'Template', 'text-domain' ),
                    esc_attr__( $i )
                );
            }
            ?>
                        </select>
                    </td>
                </tr>
            </table>

<?php

        }

        /**
         * @param  $post_id
         * @param  $post
         * @return mixed
         */
        public function save_metabox( $post_id, $post ) {

            // Add nonce for security and authentication.
            $nonce_name   = isset( $_POST['coupon_nonce'] ) ? $_POST['coupon_nonce'] : '';
            $nonce_action = 'coupon_nonce_action';

            // Check if a nonce is set.
            if ( !isset( $nonce_name ) ) {
                return;
            }

            // Check if a nonce is valid.
            if ( !wp_verify_nonce( $nonce_name, $nonce_action ) ) {
                return;
            }

            // Check if the user has permissions to save data.
            if ( !current_user_can( 'edit_post', $post_id ) ) {
                return;
            }

            // Check if it's not an autosave.
            if ( wp_is_post_autosave( $post_id ) ) {
                return;
            }

            // Check if it's not a revision.
            if ( wp_is_post_revision( $post_id ) ) {
                return;
            }

            // Sanitize user input.
            $coupon_type     = isset( $_POST['coupon_type'] ) ? sanitize_text_field( $_POST['coupon_type'] ) : '';
            $coupon          = isset( $_POST['coupon'] ) ? sanitize_text_field( $_POST['coupon'] ) : '';
            $coupon_url      = isset( $_POST['coupon_url'] ) ? esc_url( $_POST['coupon_url'] ) : '';
            $discount_am     = isset( $_POST['discount_am'] ) ? sanitize_text_field( $_POST['discount_am'] ) : '';
            $description     = isset( $_POST['description'] ) ? sanitize_textarea_field( $_POST['description'] ) : '';
            $coupon_exp      = isset( $_POST['coupon_exp'] ) ? intval( $_POST['coupon_exp'] ) : '';
            $exp_date        = isset( $_POST['exp_date'] ) ? sanitize_text_field( $_POST['exp_date'] ) : '';
            $hide_coupon     = isset( $_POST['hide_coupon'] ) ? sanitize_key( 'checked' ) : '';
            $coupon_template = isset( $_POST['coupon_template'] ) ? intval( $_POST['coupon_template'] ) : '';

            // Update the meta field in the database.
            update_post_meta( $post_id, 'coupon_type', $coupon_type );
            update_post_meta( $post_id, 'coupon', $coupon );
            update_post_meta( $post_id, 'coupon_url', $coupon_url );
            update_post_meta( $post_id, 'discount_am', $discount_am );
            update_post_meta( $post_id, 'description', $description );
            update_post_meta( $post_id, 'coupon_exp', $coupon_exp );
            update_post_meta( $post_id, 'exp_date', $exp_date );
            update_post_meta( $post_id, 'hide_coupon', $hide_coupon );
            update_post_meta( $post_id, 'coupon_template', $coupon_template );

        }

        /**
         * render_preview
         *
         * @return void
         */
        public function render_preview() {

        }

        /**
         * render_shortcode
         *
         * @return void
         */
        public function render_shortcode() {
            $post        = get_post();
            $title_full  = __( 'Full Coupon Template', 'text-domain' );
            $title_      = __( 'Only Coupon Code', 'text-domain' );
            $full_coupon = esc_attr( "[wpsc_coupon id={$post->ID}]" );
            $only_coupon = esc_attr( "[wpsc_code id={$post->ID}]" );

            if ( !empty( $post->ID ) ) {
                $input = <<<COPY
        <div class="shortcode_input">
            <label for="copy_coupon">{$title_}</label>
            <input type='text' id='copy_coupon' class='all_options' disabled value='{$only_coupon}'><button class="copy-button button-primary">copy</button><br/>
        </div>
        <div class="shortcode_input">
            <label for="copy_coupon">{$title_full}</label>
            <input type='text' id='copy_coupon' class='all_options' disabled value='{$full_coupon}'><button class="copy-button button-primary">copy</button>
        </div>
COPY;

                echo $input;
            }

        }
        /**
         * render_help
         *
         * @return void
         */
        public function render_help() {
            echo "help";
        }
    }
}