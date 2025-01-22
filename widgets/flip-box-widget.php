<?php
class Custom_Flip_Box_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom_flip_box';
    }

    public function get_title() {
        return esc_html__('Flip Box', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-flip-box';
    }

    public function get_categories() {
        return ['custom-elementor-addon'];
    }

    public function get_keywords() {
        return ['flip', 'box', 'card', 'hover', 'animation'];
    }

    protected function register_controls() {
        // Front Side Section
        $this->start_controls_section(
            'front_content_section',
            [
                'label' => esc_html__('Front Side', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'front_icon',
            [
                'label' => esc_html__('Icon', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'front_title',
            [
                'label' => esc_html__('Title', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Front Title', 'custom-elementor-addon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'front_description',
            [
                'label' => esc_html__('Description', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Add your front side description here', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'front_background_color',
            [
                'label' => esc_html__('Background Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .flip-box-front' => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->end_controls_section();

        // Back Side Section
        $this->start_controls_section(
            'back_content_section',
            [
                'label' => esc_html__('Back Side', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'back_title',
            [
                'label' => esc_html__('Title', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Back Title', 'custom-elementor-addon'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'back_description',
            [
                'label' => esc_html__('Description', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Add your back side description here', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'custom-elementor-addon'),
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
                ],
            ]
        );

        $this->add_control(
            'back_background_color',
            [
                'label' => esc_html__('Background Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2271b1',
                'selectors' => [
                    '{{WRAPPER}} .flip-box-back' => 'background-color: {{VALUE}}'
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
            'flip_direction',
            [
                'label' => esc_html__('Flip Direction', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'flip-horizontal',
                'options' => [
                    'flip-horizontal' => esc_html__('Horizontal', 'custom-elementor-addon'),
                    'flip-vertical' => esc_html__('Vertical', 'custom-elementor-addon'),
                ],
            ]
        );

        $this->add_responsive_control(
            'flip_box_height',
            [
                'label' => esc_html__('Height', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .flip-box' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Front Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'front_title_typography',
                'label' => esc_html__('Front Title Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .flip-box-front .flip-box-title',
            ]
        );

        // Back Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'back_title_typography',
                'label' => esc_html__('Back Title Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .flip-box-back .flip-box-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $target = $settings['button_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['button_link']['nofollow'] ? ' rel="nofollow"' : '';
        ?>
        <div class="flip-box-container">
            <div class="flip-box <?php echo esc_attr($settings['flip_direction']); ?>">
                <div class="flip-box-inner">
                    <!-- Front Side -->
                    <div class="flip-box-front">
                        <div class="flip-box-content">
                            <?php \Elementor\Icons_Manager::render_icon($settings['front_icon'], ['aria-hidden' => 'true']); ?>
                            <h3 class="flip-box-title"><?php echo esc_html($settings['front_title']); ?></h3>
                            <p class="flip-box-description"><?php echo esc_html($settings['front_description']); ?></p>
                        </div>
                    </div>
                    <!-- Back Side -->
                    <div class="flip-box-back">
                        <div class="flip-box-content">
                            <h3 class="flip-box-title"><?php echo esc_html($settings['back_title']); ?></h3>
                            <p class="flip-box-description"><?php echo esc_html($settings['back_description']); ?></p>
                            <?php if ($settings['button_text']) : ?>
                                <a href="<?php echo esc_url($settings['button_link']['url']); ?>" 
                                   class="flip-box-button"<?php echo $target . $nofollow; ?>>
                                    <?php echo esc_html($settings['button_text']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .flip-box-container {
                padding: 20px;
                perspective: 1000px;
            }

            .flip-box {
                position: relative;
                width: 100%;
                text-align: center;
                transition: transform 0.8s;
                transform-style: preserve-3d;
            }

            .flip-box-inner {
                position: relative;
                width: 100%;
                height: 100%;
                transition: transform 0.8s;
                transform-style: preserve-3d;
            }

            .flip-horizontal:hover .flip-box-inner {
                transform: rotateY(180deg);
            }

            .flip-vertical:hover .flip-box-inner {
                transform: rotateX(180deg);
            }

            .flip-box-front,
            .flip-box-back {
                position: absolute;
                width: 100%;
                height: 100%;
                backface-visibility: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            }

            .flip-box-front {
                background-color: #ffffff;
            }

            .flip-box-back {
                background-color: #2271b1;
                color: #ffffff;
                transform: rotateY(180deg);
            }

            .flip-vertical .flip-box-back {
                transform: rotateX(180deg);
            }

            .flip-box-content {
                max-width: 100%;
            }

            .flip-box-front .elementor-icon {
                font-size: 40px;
                margin-bottom: 20px;
            }

            .flip-box-title {
                margin: 0 0 15px;
                font-size: 24px;
                line-height: 1.3;
            }

            .flip-box-description {
                margin: 0 0 20px;
                font-size: 16px;
                line-height: 1.6;
            }

            .flip-box-button {
                display: inline-block;
                padding: 12px 24px;
                background-color: #ffffff;
                color: #2271b1;
                text-decoration: none;
                border-radius: 6px;
                transition: all 0.3s ease;
                font-weight: 500;
                margin-top: 15px;
            }

            .flip-box-button:hover {
                background-color: rgba(255, 255, 255, 0.9);
                transform: translateY(-2px);
            }

            @media (max-width: 767px) {
                .flip-box {
                    height: 400px;
                }

                .flip-box-title {
                    font-size: 20px;
                }

                .flip-box-description {
                    font-size: 14px;
                }
            }
        </style>
        <?php
    }
}