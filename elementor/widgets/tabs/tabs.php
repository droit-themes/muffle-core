<?php
namespace Elementor;

use \WP_Query;


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class case-studies
 * @package case-studies\Widgets
 */
class INPUT_ESS_Tabs extends Widget_Base {

    public function get_name() {
        return 'input_tabs';
    }

    public function get_title() {
        return __( 'Input Tabs', 'input-essential' );
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
                'label' => __( 'Filter', 'input-essential' ),
            ]
        );

        $this->add_control(
            'show_count', [
                'label' => esc_html__( 'Show count', 'input-essential' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 3
            ]
        );

        $this->add_control(
            'order', [
                'label' => esc_html__( 'Order', 'input-essential' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC'   => __('ASC', 'input-essential'),
                    'DESC'   => __('DESC', 'input-essential'),
                ],
                'default' => 'ASC'
            ]
        );

        $this->add_control(
            'order_by', [
                'label' => esc_html__( 'Order By', 'input-essential' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'modified'   => __('Modified', 'input-essential'),
                    'date'       => __('Date', 'input-essential'),
                    'rand'       => __('Rand', 'input-essential'),
                    'ID'         => __('ID', 'input-essential'),
                    'title'      => __('Title', 'input-essential'),
                    'author'     => __('Author', 'input-essential'),
                    'name'       => __('Name', 'input-essential'),
                    'parent'     => __('Parent', 'input-essential'),
                    'menu_order' => __('Menu Order', 'input-essential'),
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
                'label' => __( 'Filter Color', 'input-essential' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        //====== Post Title Color
        $this->add_control(
            'item_title_heading', [
                'label' => __( 'Post Title', 'input-essential' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'item_title_color', [
                'label' => __( 'Text Color', 'input-essential' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single_program_list .single_program_list_content h4 a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'item_title_typo',
                'selector' => '{{WRAPPER}} .single_program_list .single_program_list_content h4 a',

            ]
        );

        //====== Post Category Color
        $this->add_control(
            'item_cats_heading', [
                'label' => __( 'Post Category', 'input-essential' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'item_cats_color', [
                'label' => __( 'Text Color', 'input-essential' ),
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

        //====== Post Content Color
        $this->add_control(
            'item_content_heading', [
                'label' => __( 'Tabs Button', 'input-essential' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'item_content_color', [
                'label' => __( 'Text Color', 'input-essential' ),
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

        $programs = new WP_Query(array(
			'post_type'     => 'case-studies',
			'posts_per_page'=> $settings['show_count'],
			'order' => $settings['order'],
		));
		$case_study_cat = get_terms(array(
			'taxonomy' => 'case_study_cat',
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
                    if(is_array($case_study_cat)) {
                    foreach ( $case_study_cat as $case_study_cat ) { ?>
                            <li data-filter=".<?php echo $case_study_cat->slug ?>"><?php echo $case_study_cat->name ?></li>
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
                        if( $programs->have_posts() ){
                            while ( $programs->have_posts() ){
                                $programs->the_post();
                                if( has_post_thumbnail() ) {
                                    $cats = get_the_terms(get_the_ID(), 'case_study_cat');
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
                                <div class="single_program_list_content text-hidden">
                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <p><?php echo $cat->name; ?></p>
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