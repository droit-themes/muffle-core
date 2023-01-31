<?php
namespace Elementor;

use \WP_Query;


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class droit_portfolio_slider
 * @package droit_portfolioCore\Widgets
 */
class DRTH_ESS_Muffly_Pricing_Table extends Widget_Base {

    public function get_name() {
        return 'muffly_pricing_table';
    }

    public function get_title() {
        return __( 'Muffly Pricing Table', 'muffle_core' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return ['drth_custom_theme'];
    }

    public function get_style_depends() {
        return ['droit-partner-style'];
    }

	public function get_script_depends(){
		return ['droit-portfolio-script'];
	}
    protected function register_controls() {

        $this->start_controls_section(
			'terra_price_select_sec', [
				'label' => __( 'Price Style', 'muffle_core' ),
			]
		);
	
		$this->add_control(
			'price_style', [
				'label' => esc_html__( 'Select Style', 'muffle_core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'1' => [
						'title' => __( 'Flat Pricing', 'muffle_core' ),
						'icon' => 'price_01',
					],
				],
				'default' => '1'
			]
		);
	
		$this->end_controls_section();

		// General style controlls 

		$this->start_controls_section(
            'price_general_sec', [
                'label' => __('Price Table Heading', 'muffle_core'),
				'condition' => array(
					'price_style' => '1',
				),
            ]
        );

		$price_general = new \Elementor\Repeater();

		$price_general->add_control(
		    'te_price_per', [
			    'label' => esc_html__( 'Per Hour', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'default' => 'Per Hour'
		    ]
	    );
		$price_general->add_control(
		    'te_price', [
			    'label' => esc_html__( 'Price', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'default' => '$0'
		    ]
	    );
		$price_general->add_control(
		    'te_price_head', [
			    'label' => esc_html__( 'Pacakge Title', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'default' => 'Pacakge Title'
		    ]
	    );

		$price_general->add_control(
		    'te_price_sub_head', [
			    'label' => esc_html__( 'Package Sub Title', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'default' => 'I just worked hard'
		    ]
	    );

		
		$price_general->add_control(
			'te_price_head_img',
			[
				'label' => esc_html__( 'Feature Image', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
		$price_general->add_control(
			'show_title',
			[
				'label' => esc_html__( 'Features', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'muffle_core' ),
				'label_off' => esc_html__( 'Hide', 'muffle_core' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$price_general->add_control(
		    'te_price_features', [
			    'label' => esc_html__( 'Features', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'default' => 'Most Recommended',
		    ]
	    );
		

		$this->add_control(
		    'general_price_header', [
			    'label' => esc_html__( 'Heading Section', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::REPEATER,
			    'fields' => $price_general->get_controls(),
			    'title_field' => '{{{ te_price_head }}}',
			    'prevent_empty' => false
		    ]
	    );

		$this->end_controls_section();

		// price table Content

		$this->start_controls_section(
            'price_general_sec_content', [
                'label' => __('Price Table Content', 'muffle_core'),
				'condition' => array(
					'price_style' => '1',
				),
            ]
        );

		$price_general_content = new \Elementor\Repeater();
		$price_general_content->add_control(
		    'te_price_content_title', [
			    'label' => esc_html__( 'Price Title', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
                'default' => 'Guarenteed quality control'
		    ]
	    );
		

		$price_general_content->add_control(
			'te_price_content_icon1',
			[
				'label' => esc_html__( 'Tab 01 Icon', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$price_general_content->add_control(
			'te_price_content_icon2',
			[
				'label' => esc_html__( 'Tab 02 Icon', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$price_general_content->add_control(
			'te_price_content_icon3',
			[
				'label' => esc_html__( 'Tab 03 Icon', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
		    'general_price_content', [
			    'label' => esc_html__( 'Table Content', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::REPEATER,
			    'fields' => $price_general_content->get_controls(),
			    'title_field' => '{{{ te_price_content_title }}}',
			    'prevent_empty' => false
		    ]
	    );

		$this->end_controls_section();


		$this->start_controls_section(
            'price_general_button', [
                'label' => __('Price Button', 'muffle_core'),
				'condition' => array(
					'price_style' => '1',
				),
            ]
        );

		$price_button = new \Elementor\Repeater();

		$price_button->add_control(
		    'price_button_text',
		    [
			    'label' => esc_html__( 'Button Text', 'muffle_core' ),
			    'type' => Controls_Manager::TEXT,
			    'label_block' => true,
			    'default' => 'Get Started',
		    ]
	    );

		$price_button->add_control(
		    'price_button_url',
		    [
			    'label' => esc_html__( 'Button URL', 'muffle_core' ),
			    'type' => Controls_Manager::TEXT,
			    'label_block' => true,
			    'default' => '#',
		    ]
	    );

		$price_button->add_control(
			'te_price_button_img',
			[
				'label' => esc_html__( 'Icon', 'muffle_core' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
			]
		);


		$this->add_control(
		    'general_price_buttons', [
			    'label' => esc_html__( 'Price Button', 'muffle_core' ),
			    'type' => \Elementor\Controls_Manager::REPEATER,
			    'fields' => $price_button->get_controls(),
			    'title_field' => '{{{ price_button_text }}}',
			    'prevent_empty' => false
		    ]
	    );

		$this->end_controls_section();


		/// Price 01 Style Section /////

        $this->start_controls_section(
            'price_hading_style_sec',
            [
                'label' => __( 'Heading Style', 'muffle_core' ),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'price_style' => '1',
				),
            ]
        );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'price_1_heading_bg',
			    'label' => __( 'Section Background', 'muffle_core' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '
			        {{WRAPPER}} .table_price_info .price_head'
		    ]
	    );
		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__( 'Title', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
            'price_1_heading_color', [
                'label' => __( 'Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .__title' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Typography',
                'name' => 'heading_typography',
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
					'{{WRAPPER}} .__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'heading_sub',
			[
				'label' => esc_html__( 'Sub Title', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
            'price_1_heading_sub_color', [
                'label' => __( 'Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .__subtitle' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Typography',
                'name' => 'heading_sub_typography',
                'selector' => '{{WRAPPER}} .__subtitle',  
            ]
        );
		$this->add_responsive_control(
			'margin-subtitle',
			[
				'label' => esc_html__( 'Margin', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'heading_price',
			[
				'label' => esc_html__( 'Price', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
            'price_1_price', [
                'label' => __( 'Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .__price' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Typography',
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .__price',  
            ]
        );
		$this->add_control(
			'heading_per',
			[
				'label' => esc_html__( 'Per Hour', 'muffle_core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
            'price_1_per', [
                'label' => __( 'Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .__per' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Typography',
                'name' => 'per_typography',
                'selector' => '{{WRAPPER}} .__per',  
            ]
        );
		$this->add_responsive_control(
            'per_padding',
            [
                'label' => __( 'Padding', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .__per' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();


		/// Price 01 Style Section /////

        $this->start_controls_section(
            'price1_content_style_sec',
            [
                'label' => __( 'Content Style', 'muffle_core' ),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'price_style' => '1',
				),
            ]
        );

		$this->add_control(
            'price_1_content_color', [
                'label' => __( 'Content Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .table_price_info h5' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Content Typography',
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .table_price_info h5',  
            ]
        );

		$this->add_control(
            'price_1_price_color', [
                'label' => __( 'Price Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .table_price_info h5' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Price Typography',
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .table_price_info h5',  
            ]
        );

        $this->end_controls_section();


		/// Price 01 button Style Section /////

        $this->start_controls_section(
            'price1_button_style_sec',
            [
                'label' => __( 'Button Style', 'muffle_core' ),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'price_style' => '1',
				),
            ]
        );

		$this->add_control(
            'price_1_button_color', [
                'label' => __( 'Button Color', 'muffle_core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .theme_btn_text' => 'color: {{VALUE}};', 
                ],  
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'label' => 'Button Typography',
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .theme_btn_text',  
            ]
        );

        $this->end_controls_section();
		$this->end_controls_tabs();
		$this->end_controls_section();
        // End Border Section


    }
    
    // HTML Render Function --------------------------------
    protected function render() {
        $settings = $this->get_settings();
		$price_header   = !empty($settings['general_price_header']) ? $settings['general_price_header'] : '';
		$price_content  = !empty($settings['general_price_content']) ? $settings['general_price_content'] : '';
		$price_buttons  = !empty($settings['general_price_buttons']) ? $settings['general_price_buttons'] : '';
		
	?>
<section class="mr_price_area">
    <div class="table_price_info">
        <div class="price_head">
            <div class="p_head"></div>
            <?php 
					   $i=1;
					   if(is_array( $price_header ) && count ($price_header) > 0){
					   foreach( $price_header as $headline ):
						$price_show  = !empty($headline['show_title']) ? $headline['show_title'] : '';
					?>

            <div class="p_head <?php if($i=='1'){ echo 'head_title'; }else{ } ?>">
                <?php
					if($price_show =='yes' ): 
					?>
                <h3 class="__features"><?php echo $headline['te_price_features']; ?></h3>
                <?php endif; ?>

                <h4 class="__per"><?php echo $headline['te_price_per']; ?></h4>
                <h2 class="__price"><?php echo $headline['te_price']; ?></h2>
                <h2 class="__title"><?php echo $headline['te_price_head']; ?></h2>
                <p class="__subtitle"><?php echo $headline['te_price_sub_head']; ?></p>
            </div>
            <?php
					$i++;
					endforeach;
					}
					?>
        </div>
        <div class="price_body">
            <?php 
					   $i=1;
					   if(is_array( $price_content ) && count ($price_content) > 0){
					   foreach( $price_content as $priceContent ):
						
					?>
            <div class="pr_list">
                <?php if($priceContent['te_price_content_title']): ?>
                <div class="price_item">
                    <h5 class="pr_title"><?php echo $priceContent['te_price_content_title']; ?></h5>
                </div>
                <?php endif; ?>
                <div class="price_item" data-title="Muffle">
                    <h5 class="check">
                        <?php \Elementor\Icons_Manager::render_icon( $priceContent['te_price_content_icon1'], [ 'aria-hidden' => 'true' ] ); ?>
                    </h5>
                </div>
                <div class="price_item" data-title="Other Agency #1">
                    <h5 class="crose">
                        <?php \Elementor\Icons_Manager::render_icon( $priceContent['te_price_content_icon2'], [ 'aria-hidden' => 'true' ] ); ?>
                    </h5>
                </div>
                <div class="price_item" data-title="Other Agency #2">
                    <h5 class="check">
                        <?php \Elementor\Icons_Manager::render_icon( $priceContent['te_price_content_icon3'], [ 'aria-hidden' => 'true' ] ); ?>
                    </h5>
                </div>
            </div>
            <?php 
					$i++;
					endforeach;
					}
					?>
            <div class="pr_list">
                <div class="price_item">
                </div>
                <?php 
							$i=1;
							if(is_array( $price_buttons ) && count ($price_buttons) > 0){
							foreach( $price_buttons as $button_price ):
						?>
                <div class="price_item">
                    <a href="<?php echo esc_url($button_price['price_button_url']); ?>"
                        class="<?php if($i==2){ echo 'price_btn btn_hover'; }else{ echo 'theme_btn_text'; } ?> ">
                        <?php echo $button_price['price_button_text']; ?>
                        <?php if(!empty($button_price['te_price_button_img'])): ?>
                        <!-- <img src="<?php //echo esc_url($button_price['te_price_button_img']['url']); ?>" alt=""> -->
                        <!-- <i class="fa-solid fa-arrow-right"></i> -->
                        <?php Icons_Manager::render_icon( $button_price['te_price_button_img'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php endif; ?>
                    </a>
                </div>
                <?php 
							$i++;
							endforeach;
							}
						?>
            </div>
        </div>
    </div>
</section>
<?php
    }


}