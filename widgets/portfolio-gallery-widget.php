<?php
class Custom_Portfolio_Gallery_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'portfolio_gallery';
    }

    public function get_title() {
        return esc_html__('Portfolio Gallery', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
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

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Project Image', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Project Title', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Project Title', 'custom-elementor-addon'),
            ]
        );

        $repeater->add_control(
            'category',
            [
                'label' => esc_html__('Category', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Web Design', 'custom-elementor-addon'),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Project description goes here...', 'custom-elementor-addon'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Project Link', 'custom-elementor-addon'),
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
            'portfolio_items',
            [
                'label' => esc_html__('Portfolio Items', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Project 1', 'custom-elementor-addon'),
                        'category' => esc_html__('Web Design', 'custom-elementor-addon'),
                    ],
                    [
                        'title' => esc_html__('Project 2', 'custom-elementor-addon'),
                        'category' => esc_html__('Branding', 'custom-elementor-addon'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '2' => esc_html__('2', 'custom-elementor-addon'),
                    '3' => esc_html__('3', 'custom-elementor-addon'),
                    '4' => esc_html__('4', 'custom-elementor-addon'),
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
            'title_color',
            [
                'label' => esc_html__('Title Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__('Category Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-item-category' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .portfolio-item-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="portfolio-gallery columns-<?php echo esc_attr($settings['columns']); ?>">
            <?php foreach ($settings['portfolio_items'] as $item) : ?>
                <div class="portfolio-item">
                    <div class="portfolio-item-inner">
                        <div class="portfolio-item-image">
                            <?php
                            $target = $item['link']['is_external'] ? ' target="_blank"' : '';
                            $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
                            ?>
                            <a href="<?php echo esc_url($item['link']['url']); ?>"<?php echo $target . $nofollow; ?>>
                                <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                                <div class="portfolio-item-overlay">
                                    <div class="portfolio-item-content">
                                        <h3 class="portfolio-item-title"><?php echo esc_html($item['title']); ?></h3>
                                        <span class="portfolio-item-category"><?php echo esc_html($item['category']); ?></span>
                                        <p class="portfolio-item-description"><?php echo esc_html($item['description']); ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}