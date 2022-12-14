<?php
namespace Roofycore\Manager;
defined( 'ABSPATH' ) || exit;

class Enqueue{

    private static $instance;

    public function register(){
        
        if(current_user_can('manage_options')){
            // admin script
            add_action( 'admin_enqueue_scripts', [ $this , 'admin_enqueue'] );
        }

        // public script
        add_action( 'wp_enqueue_scripts', [ $this , 'public_enqueue'], 9999);
        if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( '\Elementor\Plugin::instance' ) ) {
            add_action('elementor/frontend/before_register_scripts', [$this, 'public_enqueue'], 9999);
        }
    }

    public function admin_enqueue(){
        
        do_action('dlTheEss/admin/enqueue/before');

        $screen = get_current_screen();
       /* 
        if( in_array($screen->id, [ 'toplevel_page_droit-addons', 'droit-addons_page_droit-pro', 'droit-addons_page_droit-addons-upgrade']) ){

            wp_enqueue_style( 'dlAddonsPro-active', drdt_th_core()->css . 'active.min.css', [], drdt_th_core()->version );

            wp_register_script( 'dlAddonsPro-active', drdt_th_core()->js . 'active.min.js', ['jquery'], drdt_th_core()->version, true ); 
            wp_localize_script(
                'dlAddonsPro-active',
                'dlAddonsPro',
                array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'admin_url' => admin_url('post.php'),
                )
            );

            wp_enqueue_script('dlAddonsPro-active');
        }*/

        do_action('dlTheEss/admin/enqueue/after');

    }

    public function public_enqueue(){

        do_action('dlTheEss/public/enqueue/before');
/*
        // load css
        wp_register_style( 'compare_style', drdt_th_core()->vendor . 'compare/css/twentytwenty.css', [], drdt_th_core()->version );
        
        // load js
        wp_register_script( 'compare_imagesloaded', drdt_th_core()->vendor . 'compare/js/imagesloaded.js', ['jquery'], drdt_th_core()->version, true ); 
        wp_register_script( 'compare_move', drdt_th_core()->vendor . 'compare/js/jquery.event.move.js', ['jquery'], drdt_th_core()->version, true ); 
        wp_register_script( 'compare_script', drdt_th_core()->vendor . 'compare/js/jquery.twentytwenty.js', ['jquery'], drdt_th_core()->version, true ); 
        wp_register_script( 'waypoints-jquery', drdt_th_core()->vendor . 'waypoints/waypoints.min.js', ['jquery'], drdt_th_core()->version, true ); 
        wp_register_script( 'counterup-jquery', drdt_th_core()->vendor . 'counterup/jquery.counterup.min.js', ['jquery'], drdt_th_core()->version, true ); 
        wp_register_script( 'magnific', drdt_th_core()->vendor . 'magnific-popup/magnific.js', ['jquery'], drdt_th_core()->version, true ); 
        wp_register_script( 'droit-addons-nested', drdt_th_core()->vendor . 'nested/nested.js', ['jquery'], drdt_th_core()->version, true ); 
        
        do_action('dlTheEss/public/enqueue/after');

        //common css
        wp_enqueue_style( 'dlAddonsPro-common', drdt_th_core()->css . 'common.min.css', [], drdt_th_core()->version );

        // widgets js
        wp_register_script( 'dlAddonsPro-common', drdt_th_core()->js . 'common.min.js', ['jquery'], drdt_th_core()->version, true ); 
        wp_localize_script(
            'dlPro-common',
            'dlAddonsPro',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'admin_url' => admin_url('post.php'),
                'wp_nonce' => wp_create_nonce('dlAddons_widget_nonce'),
            )
        );
*/
        do_action('dlTheEss/public/enqueue/end'); 
    }

    
    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }
}

