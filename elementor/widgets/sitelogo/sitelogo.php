<?php
namespace Elementor;

use \WP_Query;


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class droit_portfolio_sitelogo
 * @package droit_portfolioCore\Widgets
 */
class DRTH_ESS_sitelogo extends Widget_Base {

    public function get_name() {
        return 'droit-sitelogo-theme';
    }

    public function get_title() {
        return __( 'roofy Site logo', 'muffle-core' );
    }

    public function get_icon() {
        return 'dlicons-blog-post';
    }

    public function get_categories() {
        return [ 'drth_custom_theme' ];
    }


    public function get_style_depends() {
        return ['droit-partner-style'];
    }

	public function get_script_depends(){
		return ['droit-sitelogo-script'];
	}


    protected function register_controls() {


    $pricing_repeater = new \Elementor\Repeater();
    $this->start_controls_section(
        'drdt_site_logo_sections',
        [
            'label' => __( 'Logo', 'muffle-core' ),
        ]
    );

    $this->add_control(
        'main_logo',
        [
            'label'     => __( 'Main Logo', 'muffle-core' ),
            'type'      => Controls_Manager::MEDIA,
            'dynamic'   => [
                'active' => true,
            ],
            'default'   => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]
    );

    $this->add_control(
        'sticky_logo',
        [
            'label'     => __( 'Sticky Logo', 'muffle-core' ),
            'type'      => Controls_Manager::MEDIA,
            'dynamic'   => [
                'active' => true,
            ],
            'default'   => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]
    );

    $this->add_responsive_control(
        'logo_max_width',
        [
            'label' => __( 'Max Width', 'muffle-core' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'rem' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .drdt_custom_site_logo img' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]
    );

    $this->add_responsive_control(
        'main_logo_alignment',
        [
            'label' => __( 'Alignment', 'muffle-core' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => __( 'Left', 'muffle-core' ),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __( 'Center', 'muffle-core' ),
                    'icon' => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => __( 'Right', 'muffle-core' ),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'left',
            'selectors' => [
                '{{WRAPPER}}  .drdt_site_logo' => 'justify-content: {{VALUE}};',
            ],
            'separator' => 'before',
        ]
    );

    $this->end_controls_section();


    /**
     * @@
     * Retina Logo
     * @@
     */
    $this->start_controls_section(
        'drdt_site_retina_logo_sections',
        [
            'label' => __( 'Retina Logo', 'droithead' ),
        ]
    );

    $this->add_control(
        'retina_logo',
        [
            'label'     => __( 'Main Logo', 'droithead' ),
            'type'      => Controls_Manager::MEDIA,
            'dynamic'   => [
                'active' => true,
            ],
            'default'   => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]
    );

    $this->add_control(
        'retina_sticky_logo',
        [
            'label'     => __( 'Sticky Logo', 'droithead' ),
            'type'      => Controls_Manager::MEDIA,
            'dynamic'   => [
                'active' => true,
            ],
            'default'   => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ]
    );

    $this->add_responsive_control(
        'retina_logo_max_width',
        [
            'label' => __( 'Max Width', 'muffle-core' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'rem' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .drdt_custom_site_logo img' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]
    );

    $this->end_controls_section();

    }
    
    // HTML Render Function --------------------------------
    protected function render() {
    $settings = $this->get_settings(); 
    extract($settings);

  
    $allow_html = array(
        'img' => array(
            'srcset' => array()
        )
    );

    // Retina Logo
    $retina_logo = !empty($settings['retina_logo']['url']) ? "srcset='{$settings['retina_logo']['url']} 2x'" : '';
    $retina_sticky_logo = !empty($settings['retina_sticky_logo']['url']) ? "srcset='{$settings['retina_sticky_logo']['url']} 2x'" : '';
    ?>
    <div class="drdt_site_logo">
        <a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="drdt_custom_site_logo">
            <img class="drdt_main_logo" src="<?php echo esc_url($main_logo['url']); ?>" <?php echo wp_kses( $retina_logo, $allow_html ); ?> alt="<?php bloginfo( 'name' ); ?>">
            <img class="drdt_sticky_logo" src="<?php echo esc_url($sticky_logo['url']); ?>" <?php echo wp_kses( $retina_sticky_logo, $allow_html ); ?> alt="<?php bloginfo( 'name' ); ?>">
        </a>
    </div>
   
<?php
    }

}