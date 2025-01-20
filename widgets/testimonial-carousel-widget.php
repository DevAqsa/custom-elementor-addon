<?php
class Custom_Testimonial_Carousel_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'custom_testimonial_carousel';
    }

    public function get_title() {
        return esc_html__('Testimonial Carousel', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_categories() {
        return ['custom-elementor-addon'];
    }

    public function get_script_depends() {
        return ['swiper'];
    }

    public function get_style_depends() {
        return ['swiper'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'testimonial_image',
            [
                'label' => esc_html__('Client Image', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Client Name', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'custom-elementor-addon'),
            ]
        );

        $repeater->add_control(
            'testimonial_position',
            [
                'label' => esc_html__('Client Position', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('CEO', 'custom-elementor-addon'),
            ]
        );

        $repeater->add_control(
            'testimonial_content',
            [
                'label' => esc_html__('Testimonial Content', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'custom-elementor-addon'),
            ]
        );

        $repeater->add_control(
            'testimonial_rating',
            [
                'label' => esc_html__('Rating', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'step' => 0.5,
                'default' => 5,
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Testimonials', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'testimonial_name' => esc_html__('John Doe', 'custom-elementor-addon'),
                        'testimonial_position' => esc_html__('CEO', 'custom-elementor-addon'),
                        'testimonial_content' => esc_html__('Amazing service! Highly recommended.', 'custom-elementor-addon'),
                    ],
                    [
                        'testimonial_name' => esc_html__('Jane Smith', 'custom-elementor-addon'),
                        'testimonial_position' => esc_html__('Manager', 'custom-elementor-addon'),
                        'testimonial_content' => esc_html__('Great experience working with them.', 'custom-elementor-addon'),
                    ],
                ],
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->add_control(
            'slides_per_view',
            [
                'label' => esc_html__('Slides Per View', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 4,
                'step' => 1,
                'default' => 2,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'custom-elementor-addon'),
                'label_off' => esc_html__('No', 'custom-elementor-addon'),
                'return_value' => 'yes',
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
            'card_background_color',
            [
                'label' => esc_html__('Card Background Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-card' => 'background-color: {{VALUE}}',
                ],
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Name Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (empty($settings['testimonials'])) {
            return;
        }

        $this->add_render_attribute('carousel', 'class', 'testimonial-carousel swiper');
        ?>
        <div <?php echo $this->get_render_attribute_string('carousel'); ?>>
            <div class="swiper-wrapper">
                <?php foreach ($settings['testimonials'] as $index => $item) : ?>
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'testimonial_image'); ?>
                            </div>
                            <div class="testimonial-content">
                                <?php echo wp_kses_post($item['testimonial_content']); ?>
                            </div>
                            <div class="testimonial-rating">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <i class="fas fa-star<?php echo $i <= $item['testimonial_rating'] ? '' : '-o'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="testimonial-meta">
                                <h4 class="testimonial-name"><?php echo esc_html($item['testimonial_name']); ?></h4>
                                <span class="testimonial-position"><?php echo esc_html($item['testimonial_position']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

        <script>
            jQuery(document).ready(function($) {
                new Swiper('.testimonial-carousel', {
                    slidesPerView: <?php echo esc_js($settings['slides_per_view']); ?>,
                    spaceBetween: 30,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    <?php if ($settings['autoplay'] === 'yes') : ?>
                    autoplay: {
                        delay: 5000,
                    },
                    <?php endif; ?>
                    breakpoints: {
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: <?php echo min(2, $settings['slides_per_view']); ?>,
                            spaceBetween: 30,
                        },
                        1024: {
                            slidesPerView: <?php echo esc_js($settings['slides_per_view']); ?>,
                            spaceBetween: 30,
                        }
                    }
                });
            });
        </script>
        <?php
    }
}