<?php 

$opt = get_option( 'muffle');
$is_service_cpt = isset($opt['is_service_cpt']) ? $opt['is_service_cpt'] : '1';
$is_project_cpt = isset($opt['is_project_cpt']) ? $opt['is_project_cpt'] : '1';
$is_team_cpt = isset($opt['is_team_cpt']) ? $opt['is_team_cpt'] : '1';


$custom_postype = new \Dt_custom_postype\Dt_CustomPosttype;
$taxonomy = new \Dt_custom_postype\Dt_Taxonomies;
if ( $is_service_cpt == '1' ) {
$custom_postype->dt_postype('service', 'Service', 'Services', array('title', 'editor', 'author', 'thumbnail', 'excerpt'));
$taxonomy->dt_taxonomy( 'Type', 'Type', 'Types', 'service');
}

if ( $is_project_cpt == '1' ) {
$custom_postype->dt_postype('project', 'project', 'Our Projects', array('title', 'editor', 'author', 'thumbnail', 'excerpt'));
$taxonomy->dt_taxonomy( 'project_type', 'project Type', 'project Type', 'project');
}

if ( $is_team_cpt == '1' ) {
$custom_postype->dt_postype('Team', 'Team', 'Our Team', array('title', 'editor', 'author', 'thumbnail', 'excerpt'));
}


// Register Menu Page
add_action( 'admin_menu', 'register_admin_page_for_header_footer' );
function register_admin_page_for_header_footer() {
    add_menu_page(
        'Roofy Header Footer',
        'Header Footer',
        'read',
        'roofy-header-footer',
        '', // Callback, leave empty
        'dashicons-feedback',
        14 // Position
    );
}

$custom_postype->dt_postype('header', 'Header', 'Headers', array( 'elementor'), 'roofy-header-footer');
$custom_postype->dt_postype('footer', 'Footer', 'Footers', array( 'elementor'), 'roofy-header-footer');

//  Get header footer id

function header_footer_template_id($postype, $post_id) {

    $template_id = '';
    $header_arg = [
        'post_type' => $postype,
        'numberposts' => -1,
        'post_status' => 'publish',
        'order' => 'ASC'
    ];

    $headers = get_posts($header_arg);

    foreach ($headers as $header) {

        if ( !get_post_meta( $header->ID, 'active_header', true  ) ) {
            continue;
        }

        if ( get_post_meta($header->ID, 'entry_site', true) ) {
            $template_id = $header->ID;

        } elseif (get_post_meta($header->ID, 'select_page_menu', true)) {

            if(in_array($post_id, get_post_meta($header->ID, 'select_page_menu', true))){
                $template_id = $header->ID;
            }

        } else {
            $template_id = '';
        }
    }
    return $template_id;
}
//  add by default postype

function roofy_header_footer_add_cpt_support() {

	//if exists, assign to $cpt_support var
	$cpt_support = get_option( 'elementor_cpt_support' );

	//check if option DOESN'T exist in db
	if( ! $cpt_support ) {
		$cpt_support = [ 'header', 'footer']; //create array of our default supported post types
		update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
	}
	
}
add_action( 'after_switch_theme', 'roofy_header_footer_add_cpt_support' );

