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


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class case-studies
 * @package case-studies\Widgets
 */
class DRTH_ESS_Muffle_Project extends Widget_Base {

    public function get_name() {
        return 'muffle-project';
    }

    public function get_title() {
        return __( 'Muffle Project', 'muffle_core' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'drth_custom_theme' ];
    }

    protected function register_controls() {
        $this-> elementor_content_control();
        $this-> elementor_style_control();
    }

    public function elementor_content_control() {

        $this->start_controls_section(
            'muffle_project_list',
            [
                'label' => __('Project Style', 'muffle-core'),
            ]
        );

        $this->add_control(
			'project_style',
			[
				'label' => esc_html__( 'Project Style', 'muffle-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'one',
				'options' => [
					'one' => esc_html__( 'Style One [ 02 Column ] ', 'muffle-core' ),
					'two' => esc_html__( 'Style Two [ 03 Column ]', 'muffle-core' ),
                    'three' => esc_html__( 'Style Two [ Masonry ]', 'muffle-core' ),
				],
			]
		);

        $this->end_controls_section();




        // ---Start portfolio Setting
        $this->start_controls_section(
            'filter_sec', [
                'label' => __( 'Filter', 'muffle_core' ),
            ]
        );

        $this->add_control(
            'show_count', [
                'label' => esc_html__( 'Show count', 'muffle_core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 3
            ]
        );

        $this->add_control(
            'order', [
                'label' => esc_html__( 'Order', 'muffle_core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC'   => __('ASC', 'muffle_core'),
                    'DESC'   => __('DESC', 'muffle_core'),
                ],
                'default' => 'ASC'
            ]
        );

        $this->add_control(
            'order_by', [
                'label' => esc_html__( 'Order By', 'muffle_core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'modified'   => __('Modified', 'muffle_core'),
                    'date'       => __('Date', 'muffle_core'),
                    'rand'       => __('Rand', 'muffle_core'),
                    'ID'         => __('ID', 'muffle_core'),
                    'title'      => __('Title', 'muffle_core'),
                    'author'     => __('Author', 'muffle_core'),
                    'name'       => __('Name', 'muffle_core'),
                    'parent'     => __('Parent', 'muffle_core'),
                    'menu_order' => __('Menu Order', 'muffle_core'),
                ],
                'default' => 'ID'
            ]
        );
        $this->end_controls_section(); // End Filter

    }

    public function elementor_style_control() {

        //---------------- Style Section --------------- //
        $this->start_controls_section(
            'portfolio_style', [
                'label' => __( 'Filter Color', 'muffle_core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        //====== Post Title Color
        $this->add_control(
            'item_title_heading', [
                'label' => __( 'Post Title', 'muffle_core' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'item_title_color', [
                'label' => __( 'Text Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .__title',

            ]
        );

        $this->add_responsive_control(
			'margin-title',
			[
				'label' => esc_html__( 'Margin', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_program_list_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		        
    //====== Post Category Color
        $this->add_control(
            'item_category', [
                'label' => __( 'Post Category', 'muffle_core' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'item_category_color', [
                'label' => __( 'Text Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single_program_list_content .category' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'item_category_typo',
                'selector' => '{{WRAPPER}} .single_program_list_content .category',

            ]
        );
        //====== Post Content Color
        $this->add_control(
            'item_cats_heading', [
                'label' => __( 'Content', 'muffle_core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
		
        $this->add_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'plugin-name' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'plugin-name' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'plugin-name' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
			]
		);
        
        $this->add_control(
            'item_cats_color', [
                'label' => __( 'Text Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single_program_list .single_program_list_content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'item_cats_typo',
                'selector' => '{{WRAPPER}} .single_program_list .single_program_list_content p',

            ]
        );

        //====== Post Tabs Color
        $this->add_control(
            'item_content_heading', [
                'label' => __( 'Tabs Button', 'muffle_core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        
        $this->add_responsive_control(
			'margin-tabs',
			[
				'label' => esc_html__( 'Margin', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'item_content_color', [
                'label' => __( 'Text Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .program_list_page .filters ul li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'item_content_typo',
                'selector' => '{{WRAPPER}} .program_list_page .filters ul li',
            ]
        );

        //
        $this->add_control(
			'row_item_options',
			[
				'label' => esc_html__( 'Row and Item Margin Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
            'service_row_padding',
            [
                'label' => __( 'Padding', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .program_list_filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'service_row_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Margin', 'muffle-core' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .program_list_filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'service_item_padding',
            [
                'label' => __( 'Padding', 'droit-addons-pro' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'service_item_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Margin', 'muffle-core' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .grid-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

         //
         $this->add_control(
			'image_border_radius_options',
			[
				'label' => esc_html__( 'Image Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .program_list_page .img-fluid.wp-post-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius_before',
            [
                'label' => __( 'Border Radius Before', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .program_list_page .project_item .project-thumbnail::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        

        $this->end_controls_section();
    }

    // HTML Render Function --------------------------------
    protected function render() {
        $this->load_widget_script();
        $settings = $this->get_settings_for_display();
        extract($settings); // Array to variable conversation
        $style_design = $settings['project_style'] ;

        $gallery = new WP_Query(array(
			'post_type'     => 'project',
			'posts_per_page'=> $settings['show_count'],
			'order' => $settings['order'],
		));
		$gallery_cat = get_terms(array(
			'taxonomy' => 'project_type',
			'hide_empty' => true
		));

    ?>
     <?php
        if($style_design == 'one'){
    ?>
    <section class="program_list program_list_page section_padding" id="program_list">
        <div class="row">
            <div class="col-md-12">
                <div class="filters">
                    <ul>
                    <li class="is-checked" data-filter="*">All Projects</li>
                    <?php 
                    if(is_array($gallery_cat)) {
                    foreach ( $gallery_cat as $gallery_cat ) { ?>
                            <li data-filter=".<?php echo $gallery_cat->slug ?>"><?php echo $gallery_cat->name ?></li>
                    <?php
                        }
                        } 
                    ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row grid program_list_filter">
                    <?php
                        if( $gallery->have_posts() ){
                            while ( $gallery->have_posts() ){
                                $gallery->the_post();
                                if( has_post_thumbnail() ) {
                                    $cats = get_the_terms(get_the_ID(), 'project_type');
                                    $cat_slug = '';
                                    if(is_array($cats)) {
                                        foreach ($cats as $cat) {
                                            $cat_slug .= $cat->slug.' ';
                                        }
                                    }
                            ?>
                            <div class="col-lg-6 col-md-6 author-content grid-item <?php echo esc_attr($cat_slug);?>">
                                <div class="project_item">
                                <?php  if( has_post_thumbnail() ){ ?>
                                    <div class="project-thumbnail">
                                    <?php the_post_thumbnail('full', array('class' => 'img-fluid')) ?>
                                    <a href="<?php the_permalink(); ?>"><span class="plus_icons"><i class="fas fa-plus"></i></span></a>
                                    </div>
                                    <?php } ?>
                                    <div class="project_content">
                                    <div class="single_program_list_content">
                                        <a class="__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <div class="category"><?php echo $cat->name; ?></div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        wp_reset_postdata();
                        }
                    ?>                       
                </div>
            </div>
        </div>
    </section>
  <?php }elseif($style_design == 'two'){ ?>
    <section class="program_list program_list_page section_padding" id="program_list">
        <div class="row">
            <div class="col-md-12">
                <div class="filters">
                    <ul>
                    <li class="is-checked" data-filter="*">All Projects</li>
                    <?php 
                    if(is_array($gallery_cat)) {
                    foreach ( $gallery_cat as $gallery_cat ) { ?>
                            <li data-filter=".<?php echo $gallery_cat->slug ?>"><?php echo $gallery_cat->name ?></li>
                    <?php
                        }
                        } 
                    ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row grid program_list_filter">
                    <?php
                        if( $gallery->have_posts() ){
                            while ( $gallery->have_posts() ){
                                $gallery->the_post();
                                if( has_post_thumbnail() ) {
                                    $cats = get_the_terms(get_the_ID(), 'project_type');
                                    $cat_slug = '';
                                    if(is_array($cats)) {
                                        foreach ($cats as $cat) {
                                            $cat_slug .= $cat->slug.' ';
                                        }
                                    }
                        ?>
                        <div class="col-lg-4 col-md-6 author-content grid-item <?php echo esc_attr($cat_slug);?>">
                                <div class="project_item">
                                <?php  if( has_post_thumbnail() ){ ?>
                                    <div class="project-thumbnail">
                                    <?php the_post_thumbnail('full', array('class' => 'img-fluid')) ?>
                                    <a href="<?php the_permalink(); ?>"><span class="plus_icons"><i class="fas fa-plus"></i></span></a>
                                    </div>
                                    <?php } ?>
                                    <div class="project_content">
                                    <div class="single_program_list_content">
                                        <a class="__title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        <div class="category"><?php echo $cat->name; ?></div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        }
                        wp_reset_postdata();
                        }
                    ?>                       
                </div>
            </div>
        </div>
    </section>
    <?php }else{ ?>

    <section class="program_list program_list_page section_padding" id="program_list">
        <div class="row">
            <div class="col-md-12">
                <div class="filters">
                    <ul>
                    <li class="is-checked" data-filter="*">All Projects</li>
                    <?php 
                    if(is_array($gallery_cat)) {
                    foreach ( $gallery_cat as $gallery_cat ) { ?>
                            <li data-filter=".<?php echo $gallery_cat->slug ?>"><?php echo $gallery_cat->name ?></li>
                    <?php
                        }
                        } 
                    ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row grid program_list_filter">
                    <?php
                        if( $gallery->have_posts() ){
                            while ( $gallery->have_posts() ){
                                $gallery->the_post();
                                if( has_post_thumbnail() ) {
                                    $cats = get_the_terms(get_the_ID(), 'project_type');
                                    $cat_slug = '';
                                    if(is_array($cats)) {
                                        foreach ($cats as $cat) {
                                            $cat_slug .= $cat->slug.' ';
                                        }
                                    }
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 grid-item <?php echo esc_attr($cat_slug);?>">
                             <div class="single_program_list wow fadeInUp" data-wow-delay=".4s">
                               <?php  if( has_post_thumbnail() ){ ?>
                               <div class="img-tabs">
                                    <?php the_post_thumbnail('full', array('class' => 'img-fluid')) ?>
                                </div>
                                <?php } ?>
                                <div class="content_box">
                                    <div class="single_program_list_content text-hidden">
                                        <div class="category"><?php echo $cat->name; ?></div>
                                        <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        wp_reset_postdata();
                        }
                    ?>                       
                </div>
            </div>
        </div>
    </section>

   <?php } ?>
    <?php
  }


  public function load_widget_script(){
    if( \Elementor\Plugin::$instance->editor->is_edit_mode() === true  ) {
        ?>
        <script>
            (function ($) {
                "use strict";
                // //wow js
                // var wow = new WOW({
                //     animateClass: 'animated',
                //     offset: 100,
                //     mobile: false,
                //     duration: 1000,
                // });
                // wow.init();


                // tabs
                var gallery = $('.gallery_iner');
                if (gallery.length) {
                    gallery.imagesLoaded(function () {
                        gallery.isotope({
                            itemSelector: '.grid-item',
                            percentPosition: true,
                            masonry: {
                                columnWidth: '.grid-sizer'
                            }
                        });
                    })
                }

                var program = document.getElementById("program_list");

                if (program) {
                    $(document).ready(function () {
                        var $grid = $('.program_list_filter').isotope({
                            itemSelector: '.grid-item',
                            layoutMode: 'fitRows',
                        });
                        var $buttonGroup = $('.filters');
                        $buttonGroup.on('click', 'li', function (event) {
                            $buttonGroup.find('.is-checked').removeClass('is-checked');
                            var $button = $(event.currentTarget);
                            $button.addClass('is-checked');
                            var filterValue = $button.attr('data-filter');
                            $grid.isotope({
                                filter: filterValue
                            });
                        });
                    });
                }


                }(jQuery));
        </script>
        <?php
    }
}


}