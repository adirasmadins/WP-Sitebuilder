<?php

class WPSB_Ajax{

    public static function init(){
        add_action( 'wp_ajax_wpsb_grab_element_data', function(){

            $nonce = $_POST['nonce'];
            if( !wp_verify_nonce( $nonce, 'wpsb_builder_nonce' ) ) return;

            if( $_POST['type'] == 'widget' ) {
                /**
                 * process instance
                 */
                $id_base = sanitize_text_field($_POST['id_base']);
                $id = sanitize_text_field($_POST['id']);
                $widget_name = sanitize_text_field($_POST['name']);

                //pri(unserialize($_POST['instance']));
                parse_str( $_POST['instance'], $i );
                $instance = $i[ 'widget-'.$id_base ][$id];
                /**
                 * something to modify
                 */
                $widget_object = new $widget_name;
                $widget_object->number = $id;
                $widget_object->form($instance);
            }
            exit;
        } );

        /**
         * Update preview of given element id and element data
         */
        add_action( 'wp_ajax_wpsb_update_preview', function (){
            $nonce = $_POST['nonce'];
            if( !wp_verify_nonce( $nonce, 'wpsb_builder_nonce' ) ) return;

            if( $_POST['type'] == 'widget' ) {
                $id = sanitize_text_field($_POST['id']);
                wpsb_preview( $id, $_POST['lego_layout'] );
            }
            exit;
        } );
    }
}

WPSB_Ajax::init();