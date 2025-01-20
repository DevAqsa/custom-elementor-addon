<?php
class Custom_Team_Member_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom_team_member';
    }

    public function get_title() {
        return esc_html__('Team Member', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-person';
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
            'image',
            [
                'label' => esc_html__('Choose Image', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium',
            ]
        );

        $this->add_control(
            'name',
            [
                'label' => esc_html__('Name', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => esc_html__('Position', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Developer', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'bio',
            [
                'label' => esc_html__('Bio', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Enter team member bio here...', 'custom-elementor-addon'),
            ]
        );

        // Social Media Repeater
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__('Icon', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-facebook',
                    'library' => 'fa-brands',
                ],
                'recommended' => [
                    'fa-brands' => [
                        'facebook',
                        'twitter',
                        'linkedin',
                        'instagram',
                        'youtube',
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'social_link',
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

        $this->add_control(
            'social_links',
            [
                'label' => esc_html__('Social Links', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'social_icon' => [
                            'value' => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                        'social_link' => [
                            'url' => '#',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
                    ],
                ],
                'title_field' => '<i class="{{{ social_icon.value }}}"></i>',
            ]
        );

        $this->end_controls_section();

        // Style Section - Image
        $this->start_controls_section(
            'style_image_section',
            [
                'label' => esc_html__('Image Style', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => esc_html__('Image Size', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-member-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .team-member-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'name_color',
            [
                'label' => esc_html__('Name Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label' => esc_html__('Position Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-position' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bio_color',
            [
                'label' => esc_html__('Bio Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-bio' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => esc_html__('Name Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .team-member-name',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'label' => esc_html__('Position Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .team-member-position',
            ]
        );

        $this->end_controls_section();

        // Style Section - Social Icons
        $this->start_controls_section(
            'style_social_section',
            [
                'label' => esc_html__('Social Icons Style', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'social_icon_size',
            [
                'label' => esc_html__('Icon Size', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_color',
            [
                'label' => esc_html__('Icon Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'social_icon_hover_color',
            [
                'label' => esc_html__('Icon Hover Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-member-social a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="team-member">
            <div class="team-member-image">
                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image'); ?>
            </div>
            
            <h3 class="team-member-name"><?php echo esc_html($settings['name']); ?></h3>
            <div class="team-member-position"><?php echo esc_html($settings['position']); ?></div>
            
            <div class="team-member-bio">
                <?php echo wp_kses_post($settings['bio']); ?>
            </div>
            
            <?php if ($settings['social_links']) : ?>
            <div class="team-member-social">
                <?php foreach ($settings['social_links'] as $item) : ?>
                    <a href="<?php echo esc_url($item['social_link']['url']); ?>"
                       <?php echo $item['social_link']['is_external'] ? 'target="_blank"' : ''; ?>
                       <?php echo $item['social_link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                        <?php \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
}