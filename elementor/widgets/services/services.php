<?php
namespace Elementor;

use \DROIT_ELEMENTOR_PRO\Module\Query\Posts_Query as Query_Module;
use \DROIT_ELEMENTOR_PRO\Content_Typography;
use \DROIT_ELEMENTOR_PRO\Button;
use \DROIT_ELEMENTOR_PRO\Button_Size;
use \DROIT_ELEMENTOR_PRO\Button_Hover;
use \DROIT_ELEMENTOR_PRO\Image;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Widget_Base;
use WP_Query;

if (!defined('ABSPATH')) {exit;}

class DRTH_ESS_Services extends Widget_Base{

    public function get_name()
    {
        return 'drth-services';
    }

    public function get_title()
    {
        return esc_html__( 'services', 'muffle-core' );
    }

    public function get_icon()
    {
        return 'eicon-image-before-after addons-icon';
    }

    public function get_categories()
    {
        return ['drth_custom_theme'];
    }

    public function get_keywords()
    {
        return [ 'test', ];
    }

    protected function register_controls()
    {
        do_action('dl_widgets/test/register_control/start', $this);

        $this->start_controls_section(
            'muffle_service_list',
            [
                'label' => __('Service Style', 'muffle-core'),
            ]
        );

        $this->add_control(
			'service_style',
			[
				'label' => esc_html__( 'Style', 'muffle-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style One', 'muffle-core' ),
					'2' => esc_html__( 'Style Two', 'muffle-core' ),
                    '3' => esc_html__( 'Style Three', 'muffle-core' ),
				],
			]
		);

        $this->end_controls_section();

        // ---Start Blog Setting
        $this->start_controls_section(
            'Blog_filter', [
                'label' => __( 'Service Settings', 'muffle-core' ),
            ]
        );
        $this->add_control(
            'all_label', [
                'label' => esc_html__( 'All filter label', 'muffle-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'See All'
            ]
        );
        $this->add_control(
            'show_count', [
                'label' => esc_html__( 'Show count', 'muffle-core' ),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'default' => 15
            ]
        );
        $this->add_control(
            'order', [
                'label' => esc_html__( 'Order', 'muffle-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => 'ASC',
                    'DESC' => 'DESC'
                ],
                'default' => 'ASC'
            ]
        );
        $this->end_controls_section();



        // add content 
        $this->_content_control();
        
        //style section
        // $this->_styles_control();
        
        do_action('dl_widgets/test/register_control/end', $this);

        // by default
        do_action('dl_widget/section/style/custom_css', $this);
        
    }

    public function _content_control(){
        //start subscribe layout
        
        //start subscribe layout end

        $this->start_controls_section(
            'feature_service_style', [
                'label' => __( 'Feature Service Style', 'muffle-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'feature_background',
                'label' => __( 'Background', 'muffle-core' ),
                'types' => [ 'classic', 'gradient'],
                'selector' => '{{WRAPPER}} .sub-content-2',
            ]
        );
        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sub-content-2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .sub-content-2',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .fung-2:hover',
			]
		);
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Padding', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .sub-content-2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'feature_title_color', [
                'label' => __( 'Title Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-col .service_title' => 'color: {{VALUE}};', 
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Title Typography',
                'name' => 'feature_typography_title',
                'selector' => '{{WRAPPER}} .single-col .service_title',
                'separator' => 'after',
                
            ]
        );
        $this->add_responsive_control(
            'content_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Content Margin', 'muffle-core' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .single-col p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'feature_content_color', [
                'label' => __( 'Content Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-col p' => 'color: {{VALUE}};', 
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Content Typography',
                'name' => 'feature_typography_content',
                'selector' => '{{WRAPPER}} .single-col p',
                
                
            ]
        );

        $this->add_control(
            'feature_button_color', [
                'label' => __( 'Button Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-col .learn_btn_two' => 'color: {{VALUE}};', 
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Button Typography',
                'name' => 'feature_typography_button',
                'selector' => '{{WRAPPER}} .single-col .learn_btn_two',
                
            ]
        );
        

    $this->end_controls_section();   ///(Style) End The Blog Title Section

    $this->start_controls_section(
        'service_style_3', [
            'label' => __( 'Service Style Three', 'muffle-core' ),
            'tab'   => Controls_Manager::TAB_STYLE,
            'condition' => [
                'service_style' => '3',
            ],
        ]
    );

    $this->add_responsive_control(
        'service_icons_padding',
        [
            'label' => __( 'Padding', 'muffle-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors' => [
                '{{WRAPPER}} .service_icons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'after',
        ]
    );
    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'box_shadow_2',
            'selector' => '{{WRAPPER}} .service_icons',
        ]
    );
    $this->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [   
            'label' => __( 'Hover Box Shadow', 'muffle-core' ),
            'name' => 'box_shadow_3',
            'selector' => '{{WRAPPER}} .service_icons:hover',
        ]
    );
    $this->add_control(
        'border_radius2',
        [
            'label' => __( 'Border Radius', 'muffle-core' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors' => [
                '{{WRAPPER}} .service_icons' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]
    );

    $this->end_controls_section();

    }

    //Html render
    protected function render()
    {   
        $this->load_widget_script();
        $settings = $this->get_settings_for_display();
        $service_style	= !empty($settings['service_style']) ? $settings['service_style'] : '1';

        $style_design = $settings['exclude'] ;

        extract($settings);
        $blogFeature = new WP_Query( array(
            'post_type'      => 'service',
            'posts_per_page' => 1,
            'order'          => 'DESC',
            'post__not_in'   => ! empty( $settings['exclude'] ) ? explode( ',', $settings['exclude'] ) : ''
        ) );


        $blogPost = new WP_Query( array(
            'post_type'      => 'service',
            'posts_per_page' => $settings['show_count'],
            'order'          => $settings['order'],
            'post__not_in'   => ! empty( $settings['exclude'] ) ? explode( ',', $settings['exclude'] ) : ''
        ) );
    ?>

    <?php if( $service_style == 1 ){ ?>
    <div class="all-col">
            <div class="col-lg-12">
                <div class="row">  
                    <?php
                        while ( $blogPost->have_posts() ) {
                        $blogPost->the_post();
                        $service_icon_images     = function_exists( 'get_field' ) ? get_field( 'service_icon_images' ) : '';
                    ?>
                        <div class="col-lg-4 col-md-6 col-sl-12">
                            <div class="fung-2">
                                <div class="single-col">
                                   <?php the_post_thumbnail('full', array('class' => 'service_img')); ?>
                                    <div class="sub-content-2">
                                        <a class="service_title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <div class="service_content"><?php echo the_excerpt(); ?></div>
                                        <a href="<?php the_permalink(); ?>" class="learn_btn_two service_more">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    wp_reset_postdata();
                    ?> 
                </div>
            </div>
    </div>
    <?php } elseif( $service_style == 2 ){ ?>
            <div class="service_two all-col">
                <div class="service_slider">
                    <div class="swiper-wrapper">  
                        <?php
                            while ( $blogPost->have_posts() ) {
                            $blogPost->the_post();
                            $service_icon_images     = function_exists( 'get_field' ) ? get_field( 'service_icon_images' ) : '';
                        ?>
                            <div class="swiper-slide">
                                <div class="fung-2">
                                    <div class="single-col">
                                    <?php the_post_thumbnail('full', array('class' => 'service_img')); ?>
                                        <div class="sub-content-2">
                                            <a class="service_title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            <div class="service_content"><?php echo the_excerpt(); ?></div>
                                            <a href="<?php the_permalink(); ?>" class="learn_btn_two service_more">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        wp_reset_postdata();
                        ?> 
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
    <?php } elseif( $service_style == 3 ){ ?>
        <div class="all-col">
            <div class="col-lg-12">
                <div class="row">  
                    <?php
                        while ( $blogPost->have_posts() ) {
                        $blogPost->the_post();
                        $service_icon_images     = function_exists( 'get_field' ) ? get_field( 'service_icon_images' ) : '';
                    ?>
                        <div class="col-lg-4 col-md-6 col-sl-12">
                            <div class="fung-2">
                                <div class="single-col service_icons">
                                    <div class="icon_box">
                                        <img src="<?php echo $service_icon_images['url']; ?>" alt="">
                                    </div>
                                    <div class="sub-content-2">
                                        <a class="service_title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <div class="service_content"><?php echo the_excerpt(); ?></div>
                                        <a href="<?php the_permalink(); ?>" class="learn_btn_two service_more">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    wp_reset_postdata();
                    ?> 
                </div>
            </div>
        </div>
    <?php }else{ } ?>
    <?php 
    }

    public function load_widget_script(){
        if( \Elementor\Plugin::$instance->editor->is_edit_mode() === true  ) {
            ?>
<script>
(function($) {
    // slider
    var serviceSwiper = new Swiper('.service_slider', {
    speed: 2500,
    slidesPerView: 3,
    centeredSlides: true,
    spaceBetween: 10,
    loop: true,
    loopedSlides: 3,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    },
  })

})(jQuery);
</script>
<?php
        }
    }

protected function content_template()
    {}
}