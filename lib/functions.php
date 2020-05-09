<?php
/**
 * The below function will help to load template file from plugin directory of wordpress
 *  Extracted from : http://wordpress.stackexchange.com/questions/94343/get-template-part-from-plugin
 */
define( 'PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

function pp_get_template_part( $slug, $name = null ) {

    do_action( "ccm_get_template_part_{$slug}", $slug, $name );

    $templates = array();
    if ( isset( $name ) ) {
        $templates[] = "{$slug}-{$name}.php";
    }

    $templates[] = "{$slug}.php";

    pp_get_template_path( $templates, true, false );
}

/* Extend locate_template from WP Core
 * Define a location of your plugin file dir to a constant in this case = PLUGIN_DIR_PATH
 * Note: PLUGIN_DIR_PATH - can be any folder/subdirectory within your plugin files
 */

/**
 * @param  $template_names
 * @param  $load
 * @param  false             $require_once
 * @return mixed
 */
function pp_get_template_path( $template_names, $load = false, $require_once = true ) {
    $located = '';
    foreach ( (array) $template_names as $template_name ) {
        if ( !$template_name ) {
            continue;
        }

        /* search file within the PLUGIN_DIR_PATH only */
        if ( file_exists( PLUGIN_DIR_PATH . $template_name ) ) {
            $located = PLUGIN_DIR_PATH . $template_name;
            break;
        }
    }

    if ( $load && '' != $located ) {
        load_template( $located, $require_once );
    }

    return $located;
}
