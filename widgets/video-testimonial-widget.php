<?php
/**
 * Video Testimonial Widget
 */
class Custom_Video_Testimonial_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'video_testimonial';
    }

    public function get_title() {
        return esc_html__('Video Testimonial', 'custom-elementor-addon');
    }

    public function get_icon() {
        return 'eicon-video-playlist';
    }

    public function get_categories() {
        return ['custom-elementor-addon'];
    }

    public function get_keywords() {
        return ['testimonial', 'video', 'review', 'feedback'];
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
            'video_type',
            [
                'label' => esc_html__('Video Type', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__('YouTube', 'custom-elementor-addon'),
                    'vimeo' => esc_html__('Vimeo', 'custom-elementor-addon'),
                    'hosted' => esc_html__('Self Hosted', 'custom-elementor-addon'),
                ],
            ]
        );

        $this->add_control(
            'youtube_url',
            [
                'label' => esc_html__('YouTube URL', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'video_type' => 'youtube',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'vimeo_url',
            [
                'label' => esc_html__('Vimeo URL', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'video_type' => 'vimeo',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'hosted_url',
            [
                'label' => esc_html__('Video File', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'video_type' => 'hosted',
                ],
            ]
        );

        $this->add_control(
            'testimonial_image',
            [
                'label' => esc_html__('Client Image', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'client_name',
            [
                'label' => esc_html__('Client Name', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'custom-elementor-addon'),
                'placeholder' => esc_html__('Enter client name', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'client_position',
            [
                'label' => esc_html__('Client Position', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('CEO', 'custom-elementor-addon'),
                'placeholder' => esc_html__('Enter client position', 'custom-elementor-addon'),
            ]
        );

        $this->add_control(
            'testimonial_content',
            [
                'label' => esc_html__('Testimonial Content', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'custom-elementor-addon'),
                'placeholder' => esc_html__('Enter client testimonial', 'custom-elementor-addon'),
            ]
        );

        $this->end_controls_section();

        // Style Section - Video Container
        $this->start_controls_section(
            'video_style_section',
            [
                'label' => esc_html__('Video Style', 'custom-elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'video_width',
            [
                'label' => esc_html__('Width', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-testimonial-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'video_border_radius',
            [
                'label' => esc_html__('Border Radius', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .video-testimonial-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Content
        $this->start_controls_section(
            'content_style_section',
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
                    '{{WRAPPER}} .testimonial-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .testimonial-name',
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label' => esc_html__('Position Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-position' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Content Color', 'custom-elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="video-testimonial-wrapper">
            <div class="video-testimonial-container">
                <?php if ($settings['video_type'] === 'youtube' && !empty($settings['youtube_url'])) : ?>
                    <div class="video-container">
                        <iframe 
                            src="<?php echo esc_url($this->get_youtube_embed_url($settings['youtube_url'])); ?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                <?php elseif ($settings['video_type'] === 'vimeo' && !empty($settings['vimeo_url'])) : ?>
                    <div class="video-container">
                        <iframe 
                            src="<?php echo esc_url($this->get_vimeo_embed_url($settings['vimeo_url'])); ?>"
                            frameborder="0"
                            allow="autoplay; fullscreen; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                <?php elseif ($settings['video_type'] === 'hosted' && !empty($settings['hosted_url']['url'])) : ?>
                    <div class="video-container">
                        <video controls>
                            <source src="<?php echo esc_url($settings['hosted_url']['url']); ?>" type="video/mp4">
                            <?php esc_html_e('Your browser does not support the video tag.', 'custom-elementor-addon'); ?>
                        </video>
                    </div>
                <?php endif; ?>
            </div>

            <div class="testimonial-content-wrapper">
                <?php if (!empty($settings['testimonial_image']['url'])) : ?>
                    <div class="testimonial-image">
                        <img src="<?php echo esc_url($settings['testimonial_image']['url']); ?>" alt="<?php echo esc_attr($settings['client_name']); ?>">
                    </div>
                <?php endif; ?>

                <div class="testimonial-text">
                    <div class="testimonial-content">
                        <?php echo wp_kses_post($settings['testimonial_content']); ?>
                    </div>
                    <h4 class="testimonial-name"><?php echo esc_html($settings['client_name']); ?></h4>
                    <span class="testimonial-position"><?php echo esc_html($settings['client_position']); ?></span>
                </div>
            </div>
        </div>

        <style>
            .video-testimonial-wrapper {
                max-width: 100%;
                margin: 0 auto;
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                padding: 25px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .video-testimonial-wrapper:hover {
                transform: translateY(-5px);
                box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
            }

            .video-container {
                position: relative;
                padding-bottom: 56.25%;
                height: 0;
                overflow: hidden;
                margin-bottom: 30px;
                border-radius: 8px;
                box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            }

            .video-container iframe,
            .video-container video {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border-radius: 8px;
            }

            .testimonial-content-wrapper {
                display: flex;
                align-items: center;
                gap: 25px;
                margin-top: 30px;
                padding: 20px;
                background: #f8f9fa;
                border-radius: 10px;
                position: relative;
            }

            .testimonial-content-wrapper::before {
                content: '"';
                position: absolute;
                top: -15px;
                left: 20px;
                font-size: 60px;
                color: #2271b1;
                font-family: Georgia, serif;
                opacity: 0.2;
                line-height: 1;
            }

            .testimonial-image {
                flex: 0 0 120px;
                position: relative;
            }

            .testimonial-image::after {
                content: '';
                position: absolute;
                top: -3px;
                left: -3px;
                right: -3px;
                bottom: -3px;
                border: 2px solid #2271b1;
                border-radius: 50%;
                opacity: 0.2;
            }

            .testimonial-image img {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                object-fit: cover;
                border: 4px solid #ffffff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .testimonial-image img:hover {
                transform: scale(1.05);
            }

            .testimonial-text {
                flex: 1;
                position: relative;
            }

            .testimonial-content {
                margin-bottom: 20px;
                font-style: italic;
                color: #555;
                line-height: 1.8;
                font-size: 16px;
                position: relative;
                padding-left: 25px;
                border-left: 3px solid rgba(34, 113, 177, 0.2);
            }

            .testimonial-name {
                margin: 0 0 8px;
                font-size: 20px;
                font-weight: 600;
                color: #2271b1;
                letter-spacing: 0.5px;
            }

            .testimonial-position {
                display: inline-block;
                font-size: 14px;
                color: #666;
                background: rgba(34, 113, 177, 0.1);
                padding: 4px 12px;
                border-radius: 20px;
                font-weight: 500;
            }

            @media (max-width: 768px) {
                .testimonial-content-wrapper {
                    flex-direction: column;
                    text-align: center;
                    gap: 15px;
                }

                .testimonial-image {
                    margin: 0 auto;
                }

                .testimonial-content {
                    padding-left: 0;
                    border-left: none;
                    text-align: center;
                }

                .testimonial-content-wrapper::before {
                    left: 50%;
                    transform: translateX(-50%);
                }

                .video-testimonial-wrapper {
                    padding: 15px;
                }
            }
        </style>
        <?php
    }

    private function get_youtube_embed_url($url) {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        if (isset($match[1])) {
            return 'https://www.youtube.com/embed/' . $match[1];
        }
        return '';
    }

    private function get_vimeo_embed_url($url) {
        preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $match);
        if (isset($match[3])) {
            return 'https://player.vimeo.com/video/' . $match[3];
        }
        return '';
    }
}