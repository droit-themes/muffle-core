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
       
        do_action('dlTheEss/admin/enqueue/after');

    }

    public function public_enqueue(){

        do_action('dlTheEss/public/enqueue/before');

        do_action('dlTheEss/public/enqueue/end'); 
    }

    
    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }
}

