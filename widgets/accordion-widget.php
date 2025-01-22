<?php
class Custom_Accordion_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom_accordion';
    }

    public function get_title() {
        return esc_html__('Custom Accordion', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['custom-elementor-addon'];
    }

    public function get_keywords() {
        return ['accordion', 'toggle', 'tab', 'collapse'];
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

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__('Title', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Accordion Title', 'custom-elementor-addon'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label' => esc_html__('Content', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Accordion Content', 'custom-elementor-addon'),
                'show_label' => false,
            ]
        );

        $this->add_control(
            'accordion_items',
            [
                'label' => esc_html__('Accordion Items', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__('Accordion #1', 'custom-elementor-addon'),
                        'tab_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'custom-elementor-addon'),
                    ],
                    [
                        'tab_title' => esc_html__('Accordion #2', 'custom-elementor-addon'),
                        'tab_content' => esc_html__('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'custom-elementor-addon'),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'default_active_tab',
            [
                'label' => esc_html__('Default Active Tab', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 0,
                'description' => esc_html__('Set 0 to close all tabs by default', 'custom-elementor-addon'),
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
            'title_color',
            [
                'label' => esc_html__('Title Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background',
            [
                'label' => esc_html__('Title Background', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-accordion-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Content Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-accordion-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_background',
            [
                'label' => esc_html__('Content Background', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-accordion-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .custom-accordion-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Content Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .custom-accordion-content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $default_active = $settings['default_active_tab'];
        ?>
        <div class="custom-accordion-widget">
            <?php foreach ($settings['accordion_items'] as $index => $item) : 
                $is_active = ($index === $default_active) ? 'active' : '';
                $content_style = ($index === $default_active) ? 'display: block;' : 'display: none;';
            ?>
                <div class="custom-accordion-item">
                    <div class="custom-accordion-title <?php echo esc_attr($is_active); ?>" data-index="<?php echo esc_attr($index); ?>">
                        <?php echo esc_html($item['tab_title']); ?>
                        <span class="accordion-icon"></span>
                    </div>
                    <div class="custom-accordion-content" style="<?php echo esc_attr($content_style); ?>">
                        <?php echo wp_kses_post($item['tab_content']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <style>
            .custom-accordion-widget {
                width: 100%;
                --accordion-border-color: #e5e7eb;
                --accordion-title-bg: #ffffff;
                --accordion-title-bg-hover: #f9fafb;
                --accordion-title-bg-active: #f3f4f6;
                --accordion-content-bg: #ffffff;
                --accordion-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                --accordion-text: #374151;
                --accordion-icon-color: #6b7280;
            }

            .custom-accordion-item {
                margin-bottom: 16px;
                border-radius: 8px;
                box-shadow: var(--accordion-shadow);
                background: var(--accordion-title-bg);
                overflow: hidden;
            }

            .custom-accordion-title {
                padding: 20px 24px;
                cursor: pointer;
                position: relative;
                border: 1px solid var(--accordion-border-color);
                border-radius: 8px;
                transition: all 0.2s ease-in-out;
                color: var(--accordion-text);
                font-weight: 500;
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: var(--accordion-title-bg);
            }

            .custom-accordion-title:hover {
                background: var(--accordion-title-bg-hover);
            }

            .custom-accordion-title.active {
                background: var(--accordion-title-bg-active);
                border-radius: 8px 8px 0 0;
                border-bottom-color: transparent;
            }

            .accordion-icon {
                position: relative;
                width: 20px;
                height: 20px;
                margin-left: 16px;
                flex-shrink: 0;
            }

            .accordion-icon:before,
            .accordion-icon:after {
                content: '';
                position: absolute;
                background-color: var(--accordion-icon-color);
                transition: transform 0.25s ease-in-out;
                border-radius: 1px;
            }

            .accordion-icon:before {
                width: 2px;
                height: 12px;
                left: 9px;
                top: 4px;
            }

            .accordion-icon:after {
                width: 12px;
                height: 2px;
                left: 4px;
                top: 9px;
            }

            .custom-accordion-title.active .accordion-icon:before {
                transform: rotate(90deg) scale(0);
            }

            .custom-accordion-title.active .accordion-icon:after {
                transform: rotate(180deg);
            }

            .custom-accordion-content {
                padding: 24px;
                border: 1px solid var(--accordion-border-color);
                border-top: none;
                border-radius: 0 0 8px 8px;
                background: var(--accordion-content-bg);
                color: var(--accordion-text);
                line-height: 1.6;
                transform-origin: top;
                animation: accordionContent 0.3s ease-out;
            }

            @keyframes accordionContent {
                from {
                    opacity: 0;
                    transform: translateY(-4px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Dark mode support */
            @media (prefers-color-scheme: dark) {
                .custom-accordion-widget {
                    --accordion-border-color: #374151;
                    --accordion-title-bg: #1f2937;
                    --accordion-title-bg-hover: #2d3748;
                    --accordion-title-bg-active: #2d3748;
                    --accordion-content-bg: #1f2937;
                    --accordion-text: #e5e7eb;
                    --accordion-icon-color: #9ca3af;
                }
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            $('.custom-accordion-title').click(function() {
                var $this = $(this);
                var $content = $this.next('.custom-accordion-content');
                var $allContents = $('.custom-accordion-content');
                var $allTitles = $('.custom-accordion-title');

                if ($this.hasClass('active')) {
                    $this.removeClass('active');
                    $content.slideUp(300);
                } else {
                    $allTitles.removeClass('active');
                    $allContents.slideUp(300);
                    $this.addClass('active');
                    $content.slideDown(300);
                }
            });
        });
        </script>
        <?php
    }
}