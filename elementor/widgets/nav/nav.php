<?php
namespace Elementor;

use \WP_Query;


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class droit_portfolio_nav
 * @package droit_portfolioCore\Widgets
 */
class DRTH_ESS_nav extends Widget_Base {

    public function get_name() {
        return 'droit-nav-theme';
    }

    public function get_title() {
        return __( 'Roofy Menu', 'muffle-core' );
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
		return ['droit-nav-script'];
	}

   
    protected function register_controls() {

        $this->start_controls_section(
			'drdt_menu_sections',
			[
				'label' => __( 'Menu', 'muffle-core' ),
			]
		);
        
        $menus = $this->get_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'drdt_menus',
				[
					'label'        => __( 'Select Menu', 'muffle-core' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					'separator'    => 'after',
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'muffle-core' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'drdt_menus_alert',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'muffle-core' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
        }

        $this->add_control(
            'drdt_layout',
            [
                'label'   => __( 'Layout', 'muffle-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __( 'Horizontal', 'muffle-core' ),
                    'vertical'   => __( 'Vertical', 'muffle-core' ),
                    'expandible' => __( 'Expanded', 'muffle-core' ),
                    'flyout'     => __( 'Flyout', 'muffle-core' ),
                ],
            ]
        );
        
        $this->add_control(
            'submenu_icon',
            [
                'label'        => __( 'Submenu Icon', 'muffle-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'arrow',
                'options'      => [
                    'ti-angle-down'   => __( 'Arrows', 'muffle-core' ),
                    'ti-plus'    => __( 'Plus Sign', 'muffle-core' ),
                    'none' => __( 'None', 'muffle-core' ),
                ],
            ]
        );


        $this->add_responsive_control(
            'menu_alignment',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu' => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} .drdt-nav-menu__toggle' => 'justify-content: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'show_sticky_menu',
            [
                'label' => __( 'Enable Sticky Menu', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Enable', 'muffle-core' ),
                'label_off' => __( 'Disable', 'muffle-core' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
    $this->end_controls_section();

    $this->start_controls_section(
        'drdt_hamburger_menu',
        [
            'label' => __( 'Hamburger Menu', 'muffle-core' ),
        ]
    );

    $this->add_control(
        'hamburger_menu_icon',
        [
            'label'       => __( 'Hamburger Menu Icon', 'muffle-core' ),
            'type'        => Controls_Manager::ICONS,
            'label_block' => 'true',
            'default'     => [
                'value'   => 'fas fa-align-justify',
                'library' => 'fa-solid',
            ],
            'separator' => 'before',
        ]
    );

    $this->add_control(
        'hamburger_menu_close_icon',
        [
            'label'       => __( 'Close Icon', 'muffle-core' ),
            'type'        => Controls_Manager::ICONS,
            'label_block' => 'true',
            'default'     => [
                'value'   => 'far fa-window-close',
                'library' => 'fa-regular',
            ]
        ]
    );

    $this->add_control(
        'mobile_logo',
        [
            'label' => __( 'Mobile Logo', 'muffle-core' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => '',
            ]

        ]
    );

    $this->add_control(
        'mobile_logo_sticky',
        [
            'label' => __( 'Mobile Ratina Logo', 'muffle-core' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => '',
            ]

        ]
    );

    $this->add_responsive_control(
        'mobile_logo_max_width',
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
                '{{WRAPPER}} .mobile-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
            'separator' => 'after'
        ]
    );

    $this->end_controls_section();


    /**
         * Style Tab
         * Start Menu Item Style
         */
        $this->start_controls_section(
            'menu_item_style', [
                'label' => __( 'Menu Item', 'muffle-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'menu_item_typo',
                'selector' => '
                    {{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item .drdt-menu-item
                ',
            ]
        );

        //------------------------- Start Menu Item Colors --------------------------//
        $this->start_controls_tabs(
            'menu_item_color_tabs'
        );

        // Normal Colors
        $this->start_controls_tab(
            'menu_item_normal_color', [
                'label' => __( 'Normal', 'muffle-core' ),
            ]
        );

        $this->add_control(
            'menu_item_normal_font_color',
            [
                'label' => __( 'Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item' => 'color: {{VALUE}};',
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-has-submenu-container > .drdt-menu-item' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'menu_item_normal_background_color',
            [
                'label' => __( 'Background Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item' => 'background: {{VALUE}};',
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-has-submenu-container > .drdt-menu-item' => 'background: {{VALUE}};',
                ],
            ]
        );

	    $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
			    'name' => 'menu_normal_border',
			    'label' => __( 'Border', 'muffle-core' ),
			    'selector' => '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item .drdt-menu-item',
		    ]
	    );
	    $this->add_group_control(
		    Group_Control_Text_Shadow::get_type(),
		    [
			    'name' => 'menu_normal_text_shadow',
			    'label' => __( 'Text Shadow', 'muffle-core' ),
			    'selector' => '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item .drdt-menu-item',
		    ]
	    );
	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'menu_normal_box_shadow',
			    'label' => __( 'Box Shadow', 'muffle-core' ),
			    'selector' => '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item .drdt-menu-item',
		    ]
	    );
        $this->end_controls_tab(); // End Normal Colors


        // Hover Colors
        $this->start_controls_tab(
            'menu_item_hover_color',
            [
                'label' => __( 'Hover', 'muffle-core' ),
            ]
        );

        $this->add_control(
            'menu_item_hover_text_color',
            [
                'label' => __( 'Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item:hover' => 'color: {{VALUE}};',
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-has-submenu-container > .drdt-menu-item:hover' => 'color: {{VALUE}};',
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .current-menu-parent.active > .drdt-has-submenu-container > .drdt-menu-item' => 'color: {{VALUE}};',
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .current-menu-item .active' => 'color: {{VALUE}};',
                    '.drdt-nav-menu__layout-horizontal .drdt_navmenu li:hover > .drdt-has-submenu-container a' => 'color: {{VALUE}};',
                ],
            ]
        );
	    $this->add_control(
		    'menu_hover_background_color',
		    [
			    'label' => __( 'Background Color', 'muffle-core' ),
			    'type' => Controls_Manager::COLOR,
			    'selectors' => [
				    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item:hover' => 'background: {{VALUE}};',
				    '.drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-has-submenu-container > .drdt-menu-item:hover' => 'background: {{VALUE}};',
			    ],
		    ]
	    );
	    $this->add_group_control(
		    Group_Control_Text_Shadow::get_type(),
		    [
			    'name' => 'menu_hover_text_shadow',
			    'label' => __( 'Text Shadow', 'muffle-core' ),
			    'selector' => '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .menu-item .drdt-menu-item:hover',
		    ]
	    );
	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'menu_hover_box_shadow',
			    'label' => __( 'Box Shadow', 'muffle-core' ),
			    'selector' => '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .menu-item .drdt-menu-item:hover',
		    ]
	    );

        $this->end_controls_tab(); // Hover Colors

        $this->end_controls_tabs(); // End Tabs

        $this->add_responsive_control(
            'menu_item_sec_divider',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        // Margin & Padding
        $this->add_responsive_control(
            'menu_item_margin',
            [
                'label' => __( 'Item Margin', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item .drdt-menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_item_padding',
            [
                'label' => __( 'Item Padding', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item .drdt-menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after'
            ]
        );

        $this->end_controls_section(); // End Menu Items Style


        //================================== Start Sticky Menu Options ================================//
        $this->start_controls_section(
            'sticky_menu_item_style', [
                'label' => __( 'Sticky Menu Item', 'muffle-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_sticky_menu' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'sticky_menubar_style_',
            [
                'label' => __( 'Sticky Menu Item Style', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        //============== Colors Tabs
        $this->start_controls_tabs(
            'sticky_menu_item_color_tabs'
        );

        $this->start_controls_tab(
            'sticky_menu_item_normal_color', [
                'label' => __( 'Normal', 'muffle-core' ),
            ]
        );

        $this->add_control(
            'sticky_menu_item_normal_font_color',
            [
                'label' => __( 'Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item' => 'color: {{VALUE}};',
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-has-submenu-container > .drdt-menu-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sticky_menu_item_normal_bg_color',
            [
                'label' => __( 'Background Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-has-submenu-container > .drdt-menu-item' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sticky_menu_normal_border',
                'label' => __( 'Border', 'muffle-core' ),
                'selector' => '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'sticky_menu_normal_text_shadow',
                'label' => __( 'Text Shadow', 'muffle-core' ),
                'selector' => '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sticky_menu_normal_box_shadow',
                'label' => __( 'Box Shadow', 'muffle-core' ),
                'selector' => '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'sticky_menu_item_hover_color',
            [
                'label' => __( 'Hover', 'muffle-core' ),
            ]
        );

        $this->add_control(
            'sticky_menu_item_hover_text_color',
            [
                'label' => __( 'Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item:hover > .drdt-menu-item' => 'color: {{VALUE}};',
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item:hover > .drdt-has-submenu-container > .drdt-menu-item' => 'color: {{VALUE}};',
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .current-menu-parent.active > .drdt-has-submenu-container > .drdt-menu-item' => 'color: {{VALUE}};',
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .current-menu-item .active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sticky_menu_item_hover_bg_color',
            [
                'label' => __( 'Background Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item:hover' => 'background: {{VALUE}};',
                    '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-has-submenu-container > .drdt-menu-item:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sticky_menu_hover_border',
                'label' => __( 'Border', 'muffle-core' ),
                'selector' => '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item:hover',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'sticky_menu_hover_text_shadow',
                'label' => __( 'Text Shadow', 'muffle-core' ),
                'selector' => '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item:hover',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sticky_menu_hover_box_shadow',
                'label' => __( 'Box Shadow', 'muffle-core' ),
                'selector' => '.drdt_sticky_fixed .drdt-nav-menu__layout-horizontal .drdt_navmenu > .menu-item > .drdt-menu-item:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs(); // End Colors Tabs

        $this->add_control(
            'sticky_menubar_style_settings',
            [
                'label' => __( 'Sticky Menubar Style', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'sticky_menu_item_icon_size',
            [
                'label' => __( 'Height', 'muffle-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '.drdt_sticky_fixed' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sticky_menu_item_bg_color',
            [
                'label' => __( 'Background Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt-header.drdt_sticky_fixed' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sticky_menu_item_box_shadow',
                'label' => __( 'Box Shadow', 'muffle-core' ),
                'selector' => '{{WRAPPER}} .drdt-header.drdt_sticky_fixed',
            ]
        );

        $this->end_controls_section(); // End Sticky Menu Options


        //=================================== Start Sub Menu Options ======================================//
        $this->start_controls_section(
            'submenu_item_style', [
                'label' => __( 'Submenu', 'muffle-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'submenu_item_icon_style_settings',
            [
                'label' => __( 'Submenu Icon Style', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'submenu_item_icon_margin',
            [
                'label' => __( 'Icon Margin', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} span.mobile_dropdown_icon.drdt-menu-toggle.sub-arrow.drdt-menu-child-0.ti-angle-down' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} span.mobile_dropdown_icon.drdt-menu-toggle.sub-arrow.drdt-menu-child-0.ti-plus' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_control(
            'submenu_item_icon_color',
            [
                'label' => __( 'Icon Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.mobile_dropdown_icon.drdt-menu-toggle.sub-arrow.drdt-menu-child-0.ti-angle-down' => 'color: {{VALUE}};',
                    '{{WRAPPER}} span.mobile_dropdown_icon.drdt-menu-toggle.sub-arrow.drdt-menu-child-0.ti-plus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'submenu_item_icon_typography',
                'selector' => '
                    {{WRAPPER}} span.mobile_dropdown_icon.drdt-menu-toggle.sub-arrow.drdt-menu-child-0.ti-angle-down:before, span.mobile_dropdown_icon.drdt-menu-toggle.sub-arrow.drdt-menu-child-0.ti-plus:before
                ',
            ]
        );


        $this->add_control(
            'submenu_item_style_settings',
            [
                'label' => __( 'Submenu Item Style', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'submenu_item_margin',
            [
                'label' => __( 'Margin', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .sub-menu > li .drdt-sub-menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'submenu_item_padding',
            [
                'label' => __( 'Padding', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .sub-menu > li .drdt-sub-menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => __( 'Border', 'muffle-core' ),
                'selector' => '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .sub-menu > li > a',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'submenu_menu_item_typo',
                'selector' => '
                    {{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .sub-menu li a
                ',
            ]
        );

        //============== Colors Options
        $this->start_controls_tabs(
            'submenu_item_color_tabs'
        );

        $this->start_controls_tab(
            'submenu_item_normal_color', [
                'label' => __( 'Normal', 'muffle-core' ),
            ]
        );
        $this->add_control(
            'submenu_item_normal_font_color',
            [
                'label' => __( 'Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .menu-item .drdt-sub-menu-item' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'submenu_item_normal_background',
            [
                'label' => __( 'Background', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .menu-item .drdt-sub-menu-item' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'submenu_item_hover_color',
            [
                'label' => __( 'Hover', 'muffle-core' ),
            ]
        );
        $this->add_control(
            'submenu_item_hover_text_color',
            [
                'label' => __( 'Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu li:hover > .drdt-has-submenu-container a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu li .sub-menu li:hover > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu li .sub-menu a.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'submenu_item_hover_background',
            [
                'label' => __( 'Background', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu li:hover > .drdt-has-submenu-container a' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu li .sub-menu li:hover > a' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu li .sub-menu a.active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs(); // End Colors Options

        //================ Section Margin / Padding
        $this->add_control(
            'submenu_background_settings',
            [
                'label' => __( 'Submenu Background', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'submenu_left_position',
            [
                'label' => __( 'Position', 'muffle-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt-has-submenu > .sub-menu' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'submenu_margin',
            [
                'label' => __( 'Submenu Margin', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt-has-submenu > .sub-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'submenu_padding',
            [
                'label' => __( 'Submenu Padding', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt-has-submenu > .sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'submenu_border_radius',
            [
                'label' => __( 'Border Radius', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .menu-item > .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'submenu_background',
                'label' => __( 'Background', 'muffle-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .menu-item .sub-menu',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submenu_border_box_shadow',
                'label' => __( 'Box Shadow', 'muffle-core' ),
                'selector' => '{{WRAPPER}} .drdt-nav-menu__layout-horizontal .drdt_navmenu .menu-item > .sub-menu',
            ]
        );

        $this->end_controls_section(); // End Sub Menu Options


        //===================================== Offcanvas Menu  ==============================//
        $this->start_controls_section(
            'offcanvas_menu_style', [
                'label' => __( 'Offcanvas Menu', 'muffle-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'hamburger_icon_size',
			[
				'label' => __( 'Hamburger Icon Size', 'muffle-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .drdt-nav-menu .elementor-clickable i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'offcanvas_menu_item_style',
            [
                'label' => __( 'Offcanvas Menu Item Style', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'offcanvas_menu_item_margin',
            [
                'label' => __( 'Margin', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active ul.drdt_navmenu > li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'offcanvas_menu_item_padding',
            [
                'label' => __( 'Padding', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active ul.drdt_navmenu > li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'offcanvas_menu_item_typo',
                'selector' => '
                    {{WRAPPER}} .drbt_menu_offcanvas_wrap .drdt_navmenu > li.menu-item > .drdt-menu-item,
                    {{WRAPPER}} .drbt_menu_offcanvas_wrap .drdt_navmenu > li.menu-item > .drdt-has-submenu-container > .drdt-menu-item
                ',
            ]
        );
        //====================== Item Style ======================
        $this->start_controls_tabs(
            'mobile_menu_icon_tabs'
        );

        $this->start_controls_tab(
            'mobile_menu_color_normal', [
                'label' => __( 'Normal', 'muffle-core' ),
            ]
        );
        $this->add_control(
            'mobile_menu_item_color',
            [
                'label' => __( 'Menu Item Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu .menu-item a.drdt-menu-item' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mobile_menu_item_bg',
            [
                'label' => __( 'Menu Item Background', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu .menu-item a.drdt-menu-item' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_menu_hamburger_icon_color',
            [
                'label' => __( 'Hamburger Icon Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu .elementor-clickable i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mobile_menu_hamburger_icon_color_sticky',
            [
                'label' => __( 'Hamburger Icon Color Sticky', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.drdt_sticky_fixed .drdt-nav-menu .elementor-clickable i' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mobile_menu_color_hover_tabs',
            [
                'label' => __( 'Hover', 'muffle-core' ),
            ]
        );
        $this->add_control(
            'mobile_menu_active_item_color',
            [
                'label' => __( 'Menu Item Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu li:hover > .drdt-has-submenu-container a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mobile_menu_active_item_bg',
            [
                'label' => __( 'Menu Item Background', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu li:hover > .drdt-has-submenu-container a' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hamburger_menu_hover_icon_color',
            [
                'label' => __( 'Hamburger Icon Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drdt-nav-menu__toggle > .drdt-nav-menu-icon > :hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs(); // End Color Options



        //================ Offcanvas Submenu =======================================
        $this->add_control(
            'offcanvas_submenu',
            [
                'label' => __( 'Offcanvas Submenu Style', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'offcanvas_submenu_item_margin',
            [
                'label' => __( 'Margin', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu .sub-menu > li .drdt-sub-menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'offcanvas_submenu_item_padding',
            [
                'label' => __( 'Padding', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu .sub-menu > li .drdt-sub-menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'offcanvas_submenu_item_border',
                'label' => __( 'Border', 'muffle-core' ),
                'selector' => '{{WRAPPER}} .drbt_menu_active .drdt_navmenu .sub-menu > li > a',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'offcanvas_submenu_menu_item_typo',
                'selector' => '
                    {{WRAPPER}} .drbt_menu_active .drdt_navmenu .sub-menu li a
                ',
            ]
        );

        //============== Colors Options
        $this->start_controls_tabs(
            'offcanvas_submenu_item_color_tabs'
        );
        $this->start_controls_tab(
            'offcanvas_submenu_item_normal_color', [
                'label' => __( 'Normal', 'muffle-core' ),
            ]
        );
        $this->add_control(
            'offcanvas_submenu_item_normal_font_color',
            [
                'label' => __( 'Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu .menu-item .drdt-sub-menu-item' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'offcanvas_submenu_item_normal_background',
            [
                'label' => __( 'Background', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu .menu-item .drdt-sub-menu-item' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'offcanvas_submenu_item_hover_color',
            [
                'label' => __( 'Hover', 'muffle-core' ),
            ]
        );
        $this->add_control(
            'offcanvas_submenu_item_hover_text_color',
            [
                'label' => __( 'Text Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu li:hover > .drdt-has-submenu-container a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu li .sub-menu li:hover > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu li .sub-menu a.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'offcanvas_submenu_item_hover_background',
            [
                'label' => __( 'Background', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu li:hover > .drdt-has-submenu-container a' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu li .sub-menu li:hover > a' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .drbt_menu_active .drdt_navmenu li .sub-menu a.active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs(); // End Colors Options


        $this->add_responsive_control(
            'offcanvas_submenu_margin',
            [
                'label' => __( 'Submenu Margin', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt-has-submenu > .sub-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'offcanvas_submenu_padding',
            [
                'label' => __( 'Submenu Padding', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_active .drdt-has-submenu > .sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'offcanvas_submenu_background',
                'label' => __( 'Background', 'muffle-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .drbt_menu_active .drdt_navmenu .menu-item .sub-menu',
            ]
        );
        // Submenu style end ====================================================================================




        $this->add_control(
            'mobile_menu_sec_bg',
            [
                'label' => __( 'Offcanvas Menu Wrapper', 'muffle-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'mobile_menu_sec_margin',
            [
                'label' => __( 'Margin', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_offcanvas_wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'mobile_menu_sec_padding',
            [
                'label' => __( 'Padding', 'muffle-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_offcanvas_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'mobile_menu_sec_bg_color',
            [
                'label' => __( 'Background Color', 'muffle-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .drbt_menu_offcanvas_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section(); // End Responsive Device

    }
    
    // HTML Render Function --------------------------------
    protected function render() {
    $settings         = $this->get_settings_for_display();
    extract($settings); // extract settings data

    $args = [
        'echo'        => false,
        'menu'        => $drdt_menus,
        'menu_class'  => 'drdt_navmenu',
        'fallback_cb' => '__return_empty_string',
        'container'   => '',
        'walker'      => new \Roofycore\Framework\Menu_Walker,
    ];

    $menu_html = wp_nav_menu( $args );

    $this->add_render_attribute(
        'drdt-main-menu',
        'class',
        [
            'drdt-nav-menu',
            'drdt-layout-' . $drdt_layout,
        ]
    );
    
    $this->add_render_attribute(
        'drdt-nav-menu',
        'class',
        [
            'drdt-nav-menu__layout-' . $drdt_layout,
        ]
    );
    $this->add_render_attribute(
        'drdt-nav-menu',
        'data-icon',
        [
            $submenu_icon,
        ]
    );

    if( $drdt_layout === 'flyout'){
        $this->add_render_attribute( 'drdt-flyout', 'class', 'drdt-flyout-wrapper' );
        ?>
        <div class="drdt-nav-menu__toggle elementor-clickable drdt-flyout-trigger" tabindex="0">
            <div class="drdt-nav-menu-icon">
                <?php 
                Icons_Manager::render_icon(
                    $hamburger_menu_icon,
                    [
                        'aria-hidden' => 'true',
                        'tabindex'    => '0',
                    ]
                );
                ?>
            </div>
        </div>
        <div <?php echo drdt_kses_html( $this->get_render_attribute_string( 'drdt-flyout' ) ); ?> >
            <div class="drdt-flyout-overlay elementor-clickable"></div>
            <div class="drdt-flyout-container">
                <div id="drdt-flyout-content-id-<?php echo esc_attr( $this->get_id() ); ?>" class="drdt-side drdt-flyout-<?php echo esc_attr( $drdt_layout ); ?> drdt-flyout-open">
                    <div class="drdt-flyout-content push">						
                        <nav <?php echo drdt_kses_html( $this->get_render_attribute_string( 'drdt-nav-menu' ) ); ?>>
                        
                        <?php echo $menu_html; ?>
                            
                        </nav>
                        <div class="elementor-clickable drdt-flyout-close" tabindex="0">
                            <?php 
                            Icons_Manager::render_icon(
                                $hamburger_menu_close_icon,
                                [
                                    'aria-hidden' => 'true',
                                    'tabindex'    => '0',
                                ]
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {

        $allow_html = array(
            'img' => array(
                'srcset' => array()
            )
        );
        $retina_logo = !empty($settings['mobile_logo_sticky']['url']) ? "srcset='{$settings['mobile_logo_sticky']['url']} 2x'" : '';
    ?>
    <div <?php echo $this->get_render_attribute_string( 'drdt-main-menu' ); ?>>
    <div class="offcanvus_menu_overlay"></div>
        <div class="drdt-nav-menu__toggle elementor-clickable">
            <div class="drdt-nav-menu-icon">
                <?php
                Icons_Manager::render_icon(
                    $hamburger_menu_icon,
                    [
                        'aria-hidden' => 'true',
                        'tabindex'    => '0',
                    ]
                );
                ?>
            </div>
        </div>
        <nav <?php echo $this->get_render_attribute_string( 'drdt-nav-menu' ); ?>>
            <div class="drdt_mobile_menu_logo_wrapper">
                <div class="mobile-logo"><?php if( isset($mobile_logo['url']) && !empty($mobile_logo['url']) ){?>
                    <img src="<?php echo esc_url($mobile_logo['url']);?>"  <?php echo wp_kses( $retina_logo, $allow_html ); ?>  alt="<?php echo esc_html('Logo', 'droithead');?>"><?php }?>
                </div>
              <div class="elementor-clickable drdt-flyout-close" tabindex="0">
                <?php 
                Icons_Manager::render_icon(
                    $hamburger_menu_close_icon,
                    [
                        'aria-hidden' => 'true',
                        'tabindex'    => '0',
                    ]
                );
                ?>
            </div> 
            </div>
              
            <?php echo $menu_html; ?>
            
        </nav>              
    </div>
    <?php
    }
}

    private function get_menus() {
		$menus = wp_get_nav_menus();
		$options = [];
		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		return $options;
    }

}
