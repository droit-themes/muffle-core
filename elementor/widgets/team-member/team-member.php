<?php
namespace Elementor;
use WP_Query;

if (!defined('ABSPATH')) {exit;}

class DRTH_ESS_Team_Member extends Widget_Base{

    public function get_name()
    {
        return 'drth-team-member';
    }

    public function get_title()
    {
        return esc_html__( 'Muffle Team', 'muffle-coro' );
    }

    public function get_icon()
    {
        return 'dlicons-Team addons-icon';
    }

    public function get_categories()
    {
        return ['drth_custom_theme'];
    }

    public function get_keywords()
    {
        return [ 'Team', ];
    }


    protected function register_controls() {

        $team_repeater = new \Elementor\Repeater();
        $this->start_controls_section(
			'team_sec', [
				'label' => __( 'Team Style', 'muffle-core' ),
			]
		);
	
		$this->add_control(
			'team_style', [
				'label' => esc_html__( 'Select Style', 'muffle-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'1' => [
						'title' => __( 'Team One', 'muffle-core' ),
						'icon' => 'team_01',
					],
					'2' => [
						'title' => __( 'Team Two', 'muffle-core' ),
						'icon' => 'team_02',
					],
                    '3' => [
						'title' => __( 'Team Three', 'muffle-core' ),
						'icon' => 'team_03',
					],
				],
				'default' => '1'
			]
		);
	
		$this->end_controls_section();

        // ---Start Team Setting
        $this->start_controls_section(
            'team_filter', [
                'label' => __( 'Team Member Settings', 'muffle-core' ),
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
                'default' => 8
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


        ///(Style) Strat The  Section
        $this->start_controls_section(
            'Team_member_style', [
                'label' => __( 'Member List Style', 'muffle-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .team_style_two .team_item',
			]
		);
        $this->add_responsive_control(
            'sec_team_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Section Margin', 'muffle-core' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .author-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'items-border-radius',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Item Border Radius', 'muffle-core' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .team_style_one .team_item, .team_style_two .team_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnail-border-radius',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Border Radius', 'muffle-core' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .author-content .team-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'name_color', [
                'label' => __( 'Member Name Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .author-name' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        $this->add_control(
            'name_color_hover', [
                'label' => __( 'Name Color Hover', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .author-content:hover a .author-name' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Typography',
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .author-name',  
            ]
        );
        $this->add_responsive_control(
			'margin_name',
			[
				'label' => esc_html__( 'Title Name', 'muffle-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .author-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'designnation_color', [
                'label' => __( 'Designation Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .author-designation' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Typography',
                'name' => 'designation_typography',
                'selector' => '{{WRAPPER}} .author-designation',  
            ]
        );
        $this->add_responsive_control(
			'margin_designation',
			[
				'label' => esc_html__( 'Designation', 'muffle-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .author-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section(); 
    //---------------- Style Section --------------- // 

    }
    
    protected function render() {
        $this->load_widget_script();
        $settings = $this->get_settings_for_display();
        $team_style	= !empty($settings['team_style']) ? $settings['team_style'] : '1';

        $team_member = new WP_Query( array(
		    'post_type'      => 'team',
		    'posts_per_page' => $settings['show_count'],
		    'order'          => $settings['order'],
		    'post__not_in'   => ! empty( $settings['exclude'] ) ? explode( ',', $settings['exclude'] ) : ''
	    ) );
    ?>

<?php if( $team_style == 1 ){ ?>

<section class="team team_style_one">
    <div class="team-section">
        <div class="row">
            <?php
                    while( $team_member->have_posts()):
                        $team_member->the_post();
                        $designation = function_exists( 'get_field' ) ? get_field( 'designation' ) : '';
                ?>
            <div class="col-lg-4 col-md-6 author-content">
                <div class="team_item">
                    <?php if(has_post_thumbnail()): ?>
                    <div class="team-thumbnail">
                        <?php the_post_thumbnail('full', array( 'class' => 'author-img img-fluid' )); ?>
                    </div>
                    <?php endif; ?>
                    <div class="team_content">
                        <a href="<?php the_permalink(); ?>" class="author-name">
                            <h3 class="author-name"><?php the_title(); ?></h3>
                        </a>
                        <h4 class="author-designation"><?php echo $designation; ?></h4>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php } elseif( $team_style == 2 ){ ?>

<section class="team team_style_two">
    <div class="team-section">
        <div class="row">
            <?php
                    while( $team_member->have_posts()):
                        $team_member->the_post();
                        $designation = function_exists( 'get_field' ) ? get_field( 'designation' ) : '';
                ?>
            <div class="col-lg-4 col-md-6 author-content">
                <div class="team_item">
                    <?php if(has_post_thumbnail()): ?>
                    <div class="team-thumbnail">
                        <?php the_post_thumbnail('full', array( 'class' => 'author-img img-fluid' )); ?>
                    </div>
                    <?php endif; ?>
                    <div class="team_content">
                        <a href="<?php the_permalink(); ?>" class="author-name">
                            <h3 class="author-name"><?php the_title(); ?></h3>
                        </a>
                        <h4 class="author-designation"><?php echo $designation; ?></h4>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php } elseif( $team_style == 3 ){ ?>
    <section class="team_three team team_style_two">
        <div class="team-section">
            <div class="swiper-wrapper">
                <?php
                        while( $team_member->have_posts()):
                            $team_member->the_post();
                            $designation = function_exists( 'get_field' ) ? get_field( 'designation' ) : '';
                    ?>

                <div class="swiper-slide author-content">
                    <div class="team_item">
                        <?php if(has_post_thumbnail()): ?>
                        <div class="team-thumbnail">
                            <?php the_post_thumbnail('full', array( 'class' => 'author-img img-fluid' )); ?>
                        </div>
                        <?php endif; ?>
                        <div class="team_content">
                            <a href="<?php the_permalink(); ?>" class="author-name">
                                <h3 class="author-name"><?php the_title(); ?></h3>
                            </a>
                            <h4 class="author-designation"><?php echo $designation; ?></h4>
                        </div>
                    </div>
                </div>

                <?php endwhile; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
<?php }else{ } ?>
<?php 
    }

    public function load_widget_script(){
        if( \Elementor\Plugin::$instance->editor->is_edit_mode() === true  ) {
            ?>
<script>
(function($) {
    // team slider
    var teamswiper = new Swiper(".team-section", {
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
            el: ".swiper-pagination",
            clickable: true,
            },
            breakpoints: {
            340: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            },
    });

    //popular courses js
    document.addEventListener("mouseover", parallax);

    function parallax(e) {
        document.querySelectorAll(".object").forEach(function(move) {
            var moving_value = move.getAttribute("data-value");
            var x = (e.clientX * moving_value) / 150;
            var y = (e.clientY * moving_value) / 50;

            move.style.transform = "translateX(" + x + "px) translateY(" + y + "px)";
        });
    }

})(jQuery);
</script>
<?php
        }
    }

    protected function content_template()
    {}
}