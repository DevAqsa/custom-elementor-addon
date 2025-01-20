<?php
class Custom_Feature_Box_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom_feature_box';
    }

    public function get_title() {
        return esc_html__('Feature Box', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-info-box';
    }

    public function get_categories() {
        return ['custom-elementor-addon'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Feature Title', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Feature description goes here', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'custom-elementor-addon'),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Icon
        $this->start_controls_section(
            'style_icon_section',
            [
                'label' => esc_html__('Icon Style', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feature-box-icon i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .feature-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Content
        $this->start_controls_section(
            'style_content_section',
            [
                'label' => esc_html__('Content Style', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feature-box-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feature-box-description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .feature-box-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Description Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .feature-box-description',
            ]
        );

        $this->end_controls_section();

        // Box Style Section
        $this->start_controls_section(
            'style_box_section',
            [
                'label' => esc_html__('Box Style', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'box_background_color',
            [
                'label' => esc_html__('Background Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .feature-box' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'label' => esc_html__('Border', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .feature-box',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .feature-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box Shadow', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .feature-box',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $has_link = !empty($settings['link']['url']);
        ?>
        <div class="feature-box">
            <?php if ($has_link) : ?>
            <a href="<?php echo esc_url($settings['link']['url']); ?>"
               <?php echo $settings['link']['is_external'] ? 'target="_blank"' : ''; ?>
               <?php echo $settings['link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
            <?php endif; ?>
            
            <div class="feature-box-icon">
                <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
            </div>
            
            <h3 class="feature-box-title"><?php echo esc_html($settings['title']); ?></h3>
            
            <div class="feature-box-description">
                <?php echo wp_kses_post($settings['description']); ?>
            </div>
            
            <?php if ($has_link) : ?>
            </a>
            <?php endif; ?>
        </div>
        <?php
    }
}