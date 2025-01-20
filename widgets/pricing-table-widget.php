<?php
class Custom_Pricing_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom_pricing_table';
    }

    public function get_title() {
        return esc_html__('Animated Pricing Table', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-price-table';
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
            'plan_name',
            [
                'label' => esc_html__('Plan Name', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Basic Plan', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => esc_html__('Price', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '99',
            ]
        );

        $this->add_control(
            'currency',
            [
                'label' => esc_html__('Currency', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '$',
            ]
        );

        $this->add_control(
            'period',
            [
                'label' => esc_html__('Period', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '/month',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'feature_text',
            [
                'label' => esc_html__('Feature', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Feature Item', 'custom-elementor-addon'),
            ]
        );

        $repeater->add_control(
            'is_available',
            [
                'label' => esc_html__('Feature Available', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'features_list',
            [
                'label' => esc_html__('Features', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'feature_text' => esc_html__('10GB Storage', 'custom-elementor-addon'),
                        'is_available' => 'yes',
                    ],
                    [
                        'feature_text' => esc_html__('Custom Domain', 'custom-elementor-addon'),
                        'is_available' => 'yes',
                    ],
                    [
                        'feature_text' => esc_html__('24/7 Support', 'custom-elementor-addon'),
                        'is_available' => 'no',
                    ],
                ],
                'title_field' => '{{{ feature_text }}}',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Choose Plan', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'custom-elementor-addon'),
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'highlight',
            [
                'label' => esc_html__('Highlight Plan', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
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
            'primary_color',
            [
                'label' => esc_html__('Primary Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4CAF50',
                'selectors' => [
                    '{{WRAPPER}} .pricing-table.highlight' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .pricing-table .price-value' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .pricing-table .choose-plan-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $highlight_class = $settings['highlight'] === 'yes' ? ' highlight' : '';
        ?>
        <div class="pricing-table<?php echo esc_attr($highlight_class); ?>">
            <div class="pricing-header">
                <h3 class="plan-name"><?php echo esc_html($settings['plan_name']); ?></h3>
                <div class="price">
                    <span class="currency"><?php echo esc_html($settings['currency']); ?></span>
                    <span class="price-value"><?php echo esc_html($settings['price']); ?></span>
                    <span class="period"><?php echo esc_html($settings['period']); ?></span>
                </div>
            </div>
            
            <div class="features-list">
                <?php foreach ($settings['features_list'] as $item) : ?>
                    <div class="feature-item <?php echo $item['is_available'] === 'yes' ? 'available' : 'unavailable'; ?>">
                        <i class="fas <?php echo $item['is_available'] === 'yes' ? 'fa-check' : 'fa-times'; ?>"></i>
                        <span><?php echo esc_html($item['feature_text']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="pricing-footer">
                <a href="<?php echo esc_url($settings['button_link']['url']); ?>" 
                   class="choose-plan-button"
                   <?php echo $settings['button_link']['is_external'] ? 'target="_blank"' : ''; ?>
                   <?php echo $settings['button_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                    <?php echo esc_html($settings['button_text']); ?>
                </a>
            </div>
        </div>
        <?php
    }
}