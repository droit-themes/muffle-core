<?php
// public function core
function drdt_th_core(){
    $obj = new \stdClass();
    $obj->self = \Roofycore\DRTH_Plugin::instance();
    $obj->version = \Roofycore\DRTH_Plugin::version();
    $obj->url = \Roofycore\DRTH_Plugin::dtdr_th_url();
    $obj->dir = \Roofycore\DRTH_Plugin::dtdr_th_dir();
    $obj->assets = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'assets/';
    $obj->js = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'assets/js/';
    $obj->css = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'assets/css/';
    $obj->vendor = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'assets/vendor/';
    $obj->images = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'assets/images/';
    $obj->elementor = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'elementor/';
    $obj->elementor_dir = \Roofycore\DRTH_Plugin::dtdr_th_dir() . 'elementor/';
    $obj->framework = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'framework/';
    $obj->framework_dir = \Roofycore\DRTH_Plugin::dtdr_th_dir() . 'framework/';
    $obj->posttype = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'posttype/';
    $obj->posttype_dir = \Roofycore\DRTH_Plugin::dtdr_th_dir() . 'posttype/';
    $obj->core = \Roofycore\DRTH_Plugin::dtdr_th_url() . 'core/';
    $obj->core_dir = \Roofycore\DRTH_Plugin::dtdr_th_dir() . 'core/';

    $obj->suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $obj->minify = '.min';
    
    return $obj;
}