<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Custom_Blog_Posts_Grid_Widget extends \Elementor\Widget_Base {
    
    public function get_name() {
        return 'custom_blog_posts_grid';
    }
    
    public function get_title() {
        return esc_html__('Blog Posts Grid', 'custom-elementor-addon');
    }
    
    public function get_icon() {
        return 'eicon-posts-grid';
    }
    
    public function get_categories() {
        return ['custom-elementor-addon'];
    }
    
    protected function register_controls() {
        // Query Settings
        $this->start_controls_section(
            'query_section',
            [
                'label' => esc_html__('Query Settings', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 24,
                'default' => 6,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
            ]
        );

        $this->add_control(
            'show_thumbnail',
            [
                'label' => esc_html__('Show Thumbnail', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 100,
                'default' => 20,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label' => esc_html__('Show Meta', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
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
                    '{{WRAPPER}} .blog-post-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'custom-elementor-addon'),
                'selector' => '{{WRAPPER}} .blog-post-title',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Meta Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-post-meta' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Excerpt Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-post-excerpt' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => esc_html__('Grid Gap', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-posts-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['posts_per_page'],
            'ignore_sticky_posts' => true,
        );
        
        $query = new \WP_Query($args);
        
        if ($query->have_posts()) :
            ?>
            <div class="blog-posts-grid" style="display: grid; grid-template-columns: repeat(<?php echo esc_attr($settings['columns']); ?>, 1fr);">
                <?php
                while ($query->have_posts()) : $query->the_post();
                    ?>
                    <article class="blog-post-item">
                        <?php if ('yes' === $settings['show_thumbnail'] && has_post_thumbnail()) : ?>
                            <div class="blog-post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="blog-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        
                        <?php if ('yes' === $settings['show_meta']) : ?>
                            <div class="blog-post-meta">
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                <span class="post-author">
                                    <?php echo esc_html__('by', 'custom-elementor-addon'); ?> 
                                    <?php echo get_the_author(); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ('yes' === $settings['show_excerpt']) : ?>
                            <div class="blog-post-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), $settings['excerpt_length']); ?>
                            </div>
                        <?php endif; ?>
                    </article>
                    <?php
                endwhile;
                ?>
            </div>
            <?php
            wp_reset_postdata();
        endif;
    }
}