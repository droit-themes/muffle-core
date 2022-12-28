<?php
namespace Elementor;
use WP_Query;


if (!defined('ABSPATH')) {exit;}

class DRTH_ESS_Video_popup extends Widget_Base{

    public function get_name()
    {
        return 'drth-video-popup';
    }

    public function get_title()
    {
        return esc_html__( 'Video PopUp', 'asset-coro' );
    }

    public function get_icon()
    {
        return 'eicon-video-playlist';
    }

    public function get_categories()
    {
        return ['drth_custom_theme'];
    }

    public function get_keywords()
    {
        return [ 'video', ];
    }


    protected function register_controls() {

    

    ///(Style) Strat The  Section
    $this->start_controls_section(
      'video_popup_section', [
          'label' => __( 'Video Popup', 'muffle-core' ),
      ]
    );

    $this->add_control(
        'video_popup_image',
        [
            'label' => esc_html__( 'Feature Image', 'muffle-core' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ]
    );

    $this->add_control(
        'icon_video',
        [
            'label' => esc_html__( 'Video Icon', 'muffle-core' ),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-circle',
                'library' => 'fa-solid',
            ],
        ]
    );

    $this->add_control(
        'video_url',
        [
            'label' => esc_html__( 'Video URL', 'muffle-core' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__( 'https://www.youtube.com/watch?v=OZRWcCsvOXQ', 'plugin-name' ),
        ]
    );
    
    $this->end_controls_section(); 

    // Style 

    $this->start_controls_section(
        'style_section',
        [
            'label' => esc_html__( 'Style', 'muffle-core' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'section_padding',
        [
            'type' => Controls_Manager::DIMENSIONS,
            'label' => esc_html__( 'Section Padding', 'muffle-core' ),
            'size_units' => [ 'px', 'em', '%' ],
            'selectors' => [
                '{{WRAPPER}} .video_area, .video_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'icon_color',
        [
            'label' => esc_html__( 'Icon Color', 'muffle-core' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .video_inner .video_icon' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'box_shadow',
            'label' => __('Box Shadow', 'muffle-core'),
            'selector' => '{{WRAPPER}} .video_icon',
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
            'name' => 'btn_background',
            'label' => esc_html__( 'Background', 'muffle-core' ),
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .video_inner .video_icon',
        ]
    );

    $this->end_controls_section();

    }    
    //Html render
    protected function render(){
        $settings = $this->get_settings_for_display();
    ?>
    <section class="video_area mt_top mouse_move">
            <div class="video_box">
                <div class="video_inner">
                    <?php if(!empty($settings['video_popup_image']['url'])): ?>
                    <img src="<?php echo esc_url($settings['video_popup_image']['url']); ?>" alt="">
                    <?php endif; ?>
                    <?php if(!empty($settings['video_url'])): ?>
                    <a class="popup-youtube video_icon" data-cursor-text="Watch video" data-magnetic
                        data-cursor="-opaque" href="<?php echo esc_url($settings['video_url']); ?>">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['icon_video'], [ 'aria-hidden' => 'true' ] ); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
    </section>

    <?php
     }

   protected function content_template()
    {}
   
}