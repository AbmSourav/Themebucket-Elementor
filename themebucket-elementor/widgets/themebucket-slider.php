<?php
namespace Elementor;

class ThemebucketSlider extends Widget_Base {
    
    public function get_name() {
        return __( 'Slider Widget', 'themebucket-elementor' );
    }
    public function get_title() {
        return __( "Slider Widget", 'themebucket-elementor' );
    }
    public function get_icon() {
        return 'fa fa-image';
    }
    public function get_categories() {
        return array( 'themebucket' );
    }

    /**
	 * Register widget controls.
	 *
	 * @access protected
	 */
    protected function _register_controls() {

		$this->start_controls_section(
			'widget_settings',
			[
				'label' => __( 'Widget Setings', 'themebucket-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
        );

		$this->add_control(
			'before_img',
			[
                'label'   => __( 'Before Image', 'themebucket-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ]
            ]
		);
        
        $this->add_control(
			'after_img',
			[
                'label'   => __( 'After Image', 'themebucket-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src()
                ]
            ]
        );

        $this->add_control(
			'slide_option',
			[
				'label'   => __( 'Slide Options', 'themebucket-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal Slide', 'themebucket-elementor' ),
					'vertical'   => esc_html__( 'Vertical Slide', 'themebucket-elementor' )
				],
			]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'colors',
			[
				'label' => __( 'Colors', 'themebucket-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
            'border_color',
            [
                'label'     => __( 'Border Color', 'themebucket-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                                'type'  => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1
                            ],
				'default'   => '#fff',
				'selectors' => [
                                '{{WRAPPER}} .twentytwenty-handle'        => 'border-color: {{VALUE}}',
                                '{{WRAPPER}} .twentytwenty-handle:before' => 'background: {{VALUE}}',
                                '{{WRAPPER}} .twentytwenty-handle:after'  => 'background: {{VALUE}}',
                                '{{WRAPPER}} .twentytwenty-left-arrow'    => 'border-right-color: {{VALUE}}',
                                '{{WRAPPER}} .twentytwenty-right-arrow'   => 'border-left-color: {{VALUE}}',
                                '{{WRAPPER}} .twentytwenty-down-arrow'    => 'border-top-color: {{VALUE}}',
                                '{{WRAPPER}} .twentytwenty-up-arrow'      => 'border-bottom-color: {{VALUE}}',
                            ]
            ]
        );
		$this->add_control(
            'text_bg_color',
            [
                'label'     => __( 'Text Background Color', 'themebucket-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                                'type'  => Scheme_Color::get_type(),
                                'value' => Scheme_Color::COLOR_1
                            ],
				'default'   => '#ffffff33',
				'selectors' => [
                            '{{WRAPPER}} #horizontal .twentytwenty-before-label:before, #horizontal .twentytwenty-after-label:before' => 'background: {{VALUE}}',
                            '{{WRAPPER}} #vertical .twentytwenty-before-label:before, .twentytwenty-after-label:before' => 'background: {{VALUE}}'
                            ]
            ]
        );

        $this->end_controls_section();
        
    }

    /**
	 * Render widget output on the frontend.
	 *
	 * @access protected
	 */
	protected function render() {

        $settings= $this->get_settings_for_display();
        ?>
        <div 
            id="<?php echo esc_attr( $settings['slide_option'] == 'horizontal' ? 'horizontal' : 'vertical' ); ?>" 
            class="twentytwenty-container"
        >
            <?php
                echo wp_get_attachment_image( $settings['before_img']['id'], 'full', false, array( "class" => "twentytwenty-before" ) );
                echo wp_get_attachment_image( $settings['after_img']['id'], 'full', false, array( "class" => "twentytwenty-after" ) );
            ?>
        </div><!-- .twentytwenty-container -->

<?php 
    }
    
    protected function _content_template() { 
        ?>
        <div id="{{{ settings.slide_option == 'horizontal' ? 'horizontal' : 'vertical' }}}" class="twentytwenty-container">
            <img src="{{{ settings.before_img.url }}}" alt="">
            <img src="{{{ settings.after_img.url }}}" alt="">
        </div><!-- .twentytwenty-container -->

    <?php
    }

}