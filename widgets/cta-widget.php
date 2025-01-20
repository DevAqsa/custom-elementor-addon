<?php
class Custom_CTA_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom_cta';
    }

    public function get_title() {
        return esc_html__('Custom CTA', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-call-to-action';
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
            'heading',
            [
                'label' => esc_html__('Heading', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Your Heading', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Your content goes here', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Click Here', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => esc_html__('Button URL', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'custom-elementor-addon'),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-cta-widget' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-cta-widget' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Button Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-cta-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Button Text Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-cta-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="custom-cta-widget">
            <h2><?php echo esc_html($settings['heading']); ?></h2>
            <div class="custom-cta-content">
                <?php echo wp_kses_post($settings['content']); ?>
            </div>
            <a href="<?php echo esc_url($settings['button_url']['url']); ?>" 
               class="custom-cta-button"
               <?php echo $settings['button_url']['is_external'] ? 'target="_blank"' : ''; ?>
               <?php echo $settings['button_url']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                <?php echo esc_html($settings['button_text']); ?>
            </a>
        </div>
        <?php
    }
}