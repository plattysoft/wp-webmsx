<?php
    /*
    Plugin Name: WebMSX
    Plugin URI: https://github.com/plattysoft/wp-webmsx
    description: A plugin to embed WebMSX into wordpress
    Version: 1.0
    Author: Raul Portales
    Author URI: https://plattysoft.com
    License: GPL2
    */

    function webmsx($atts = []) {
        if (array_key_exists("rom", $atts)) {
            $cartridgeParam = "WMSX.CARTRIDGE1_URL = \"".$atts["rom"]."\";";
        }

        return "<div id=\"wmsx\" style=\"text-align: center; margin: 20px auto 0;\">
                <div id=\"wmsx-screen\" style=\"box-shadow: 2px 2px 10px rgba(0, 0, 0, .7);\"></div>
            </div>
                <script src=\"".plugin_dir_url( __FILE__ )."wmsx.js\"></script>
                <script language=\"JavaScript\">
                    ".$cartridgeParam."
                    WMSX.MACHINE=\"MSX1E\";
                </script>";
    }
   
    function wp_webmsx_upload_types($existing_mimes = array()) {
        $existing_mimes['rom'] = 'msx/rom';
        return $existing_mimes;
    }

    function wp_webmsx_send_media_to_editor($html, $send_id, $attachment) {
        $post = get_post( $attachment['id'] );

        if ( 'msx/rom' === $post->post_mime_type ) {
            return "[msx rom=\"".$attachment['url']."\" /]";
        }
        else {
            return $html;
        }	
    }

    function wp_webmsx_activate() {
    }

    function wp_webmsx_deactivate() {
    }

    register_activation_hook( __FILE__, 'wp_webmsx_activate' );

    register_deactivation_hook( __FILE__, 'wp_webmsx_deactivate' );

    add_shortcode('msx', 'webmsx');

    add_filter('upload_mimes', 'wp_webmsx_upload_types');

    add_filter('media_send_to_editor', 'wp_webmsx_send_media_to_editor', 10, 3);

?>
       
