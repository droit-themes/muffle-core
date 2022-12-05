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
        $this->_styles_control();
        
        do_action('dl_widgets/test/register_control/end', $this);

        // by default
        do_action('dl_widget/section/style/custom_css', $this);
        
    }

    public function _content_control(){
        //start subscribe layout
        $this->start_controls_section(
            '_dl_pr_test_layout_section',
            [
                'label' => __('Layout', 'muffle-core'),
            ]
        );

        $this->end_controls_section();
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
                'selector' => '{{WRAPPER}} .sub-content',
            ]
        );

        $this->add_control(
            'feature_title_color', [
                'label' => __( 'Title Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-col-min h3' => 'color: {{VALUE}};', 
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Title Typography',
                'name' => 'feature_typography_title',
                'selector' => '{{WRAPPER}} .single-col-min h3',
                
            ]
        );

        $this->add_control(
            'feature_content_color', [
                'label' => __( 'Content Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-col-min p' => 'color: {{VALUE}};', 
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Content Typography',
                'name' => 'feature_typography_content',
                'selector' => '{{WRAPPER}} .single-col-min p',
                
            ]
        );

        $this->add_control(
            'feature_button_color', [
                'label' => __( 'Button Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-col-min a.btn' => 'color: {{VALUE}};', 
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Button Typography',
                'name' => 'feature_typography_button',
                'selector' => '{{WRAPPER}} .single-col-min a.btn',
                
            ]
        );

    $this->end_controls_section();   ///(Style) End The Blog Title Section

    $this->start_controls_section(
        'service_style', [
            'label' => __( 'Service Style', 'muffle-core' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );
	
    
    $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'label' => __( 'Content Background', 'muffle-core' ),
                'types' => [ 'classic', 'gradient'],
                'selector' => '{{WRAPPER}} .sub-content-2',
            ]
        );
    
    $this->add_control(
        'title_color', [
            'label' => __( 'Title Text Color', 'muffle-core' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .sub-content-2 a' => 'color: {{VALUE}};', 
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(), [
            'label' => 'Title Typography',
            'name' => 'typography_title',
            'selector' => '{{WRAPPER}} .sub-content-2 a',
            
        ]
    );

    $this->add_control(
        'content_color', [
            'label' => __( 'Content Text Color', 'muffle-core' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .sub-content-2 p' => 'color: {{VALUE}};', 
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(), [
            'label' => 'Content Typography',
            'name' => 'typography_content',
            'selector' => '{{WRAPPER}} .sub-content-2 p',
            
        ]
    );

    $this->add_control(
        'button_color', [
            'label' => __( 'Button Text Color', 'muffle-core' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .sub-content-2 a.btn' => 'color: {{VALUE}};', 
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(), [
            'label' => 'Button Typography',
            'name' => 'typography_content',
            'selector' => '{{WRAPPER}} .sub-content-2 a.btn',
            
        ]
    );

    $this->end_controls_section();   ///(Style) End The Blog Title Section

    }

    public function _styles_control(){

        $this->start_controls_section(
            '_dl_pr_test_style_section',
            [
                'label' => esc_html__('Style', 'text-domain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,

            ]
        );



        $this->end_controls_section();
    }

    //Html render
    protected function render()
    {   
        $settings = $this->get_settings_for_display();
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
                                        <a href="<?php the_permalink(); ?>"><?php echo  wp_trim_words( get_the_title(), 5, false ); ?></a>
                                        <p><?php echo  wp_trim_words( get_the_content(), 15, false ); ?></p>
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
    
<?php 
  }

protected function content_template()
    {}
}