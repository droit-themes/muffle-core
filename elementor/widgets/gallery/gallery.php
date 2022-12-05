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
class DRTH_ESS_gallery extends Widget_Base {

    public function get_name() {
        return 'roofy-gallery';
    }

    public function get_title() {
        return __( 'Roofy Gallery', 'roofy_core' );
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

        // ---Start portfolio Setting
        $this->start_controls_section(
            'filter_sec', [
                'label' => __( 'Filter', 'roofy_core' ),
            ]
        );

        $this->add_control(
            'show_count', [
                'label' => esc_html__( 'Show count', 'roofy_core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 3
            ]
        );

        $this->add_control(
            'order', [
                'label' => esc_html__( 'Order', 'roofy_core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC'   => __('ASC', 'roofy_core'),
                    'DESC'   => __('DESC', 'roofy_core'),
                ],
                'default' => 'ASC'
            ]
        );

        $this->add_control(
            'order_by', [
                'label' => esc_html__( 'Order By', 'roofy_core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'modified'   => __('Modified', 'roofy_core'),
                    'date'       => __('Date', 'roofy_core'),
                    'rand'       => __('Rand', 'roofy_core'),
                    'ID'         => __('ID', 'roofy_core'),
                    'title'      => __('Title', 'roofy_core'),
                    'author'     => __('Author', 'roofy_core'),
                    'name'       => __('Name', 'roofy_core'),
                    'parent'     => __('Parent', 'roofy_core'),
                    'menu_order' => __('Menu Order', 'roofy_core'),
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
                'label' => __( 'Filter Color', 'roofy_core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        //====== Post Title Color
        $this->add_control(
            'item_title_heading', [
                'label' => __( 'Post Title', 'roofy_core' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'item_title_color', [
                'label' => __( 'Text Color', 'roofy_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single_program_list .single_program_list_content h4' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .single_program_list .single_program_list_content h4',

            ]
        );

        $this->add_responsive_control(
			'margin-title',
			[
				'label' => esc_html__( 'Margin', 'roofy_core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_program_list .single_program_list_content h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		        
    //====== Post Category Color
        $this->add_control(
            'item_category', [
                'label' => __( 'Post Category', 'roofy_core' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'item_category_color', [
                'label' => __( 'Text Color', 'roofy_core' ),
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
                'label' => __( 'Content', 'roofy_core' ),
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
                'label' => __( 'Text Color', 'roofy_core' ),
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
                'label' => __( 'Tabs Button', 'roofy_core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        
        $this->add_responsive_control(
			'margin-tabs',
			[
				'label' => esc_html__( 'Margin', 'roofy_core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'item_content_color', [
                'label' => __( 'Text Color', 'roofy_core' ),
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

        

        $this->end_controls_section();
    }

    // HTML Render Function --------------------------------
    protected function render() {
        $this->load_widget_script();
        $settings = $this->get_settings_for_display();
        extract($settings); // Array to variable conversation

        $gallery = new WP_Query(array(
			'post_type'     => 'gallery',
			'posts_per_page'=> $settings['show_count'],
			'order' => $settings['order'],
		));
		$gallery_cat = get_terms(array(
			'taxonomy' => 'gallery_type',
			'hide_empty' => true
		));

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
                                    $cats = get_the_terms(get_the_ID(), 'gallery_type');
                                    $cat_slug = '';
                                    if(is_array($cats)) {
                                        foreach ($cats as $cat) {
                                            $cat_slug .= $cat->slug.' ';
                                        }
                                    }
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 grid-item <?php echo esc_attr($cat_slug);?>">
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
                                        <div class="content" style="text-align: <?php echo esc_attr( $settings['text_align'] ); ?>;"><?php echo  the_excerpt();?></div>
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
    <?php
  }


  public function load_widget_script(){
    if( \Elementor\Plugin::$instance->editor->is_edit_mode() === true  ) {
        ?>
        <script>
            ( function( $ ){
            //banner slider js
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
           
            })(jQuery);
        </script>
        <?php
    }
}


}