<?php
/**
 * Plugin Name: Custom Elementor Addon
 * Description: A custom addon for Elementor page builder
 * Version: 1.0.0
 * Author: Aqsa Mumtaz
 * Text Domain: custom-elementor-addon
 */

if (!defined('ABSPATH')) {
    exit;
}


// Register Custom Widget Category
function add_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'custom-elementor-addon',
        [
            'title' => esc_html__('Custom Addon', 'custom-elementor-addon'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'add_elementor_widget_categories');

// Register Widget
function register_custom_widgets($widgets_manager) {
    require_once(__DIR__ . '/widgets/cta-widget.php');
    require_once(__DIR__ . '/widgets/feature-box-widget.php');
    require_once(__DIR__ . '/widgets/team-member-widget.php');
    require_once(__DIR__ . '/widgets/pricing-table-widget.php');
    require_once(__DIR__ . '/widgets/testimonial-carousel-widget.php');
    require_once(__DIR__ . '/widgets/blog-posts-grid-widget.php');
    require_once(__DIR__ . '/widgets/portfolio-gallery-widget.php');
    require_once(__DIR__ . '/widgets/accordion-widget.php');
    require_once(__DIR__ . '/widgets/flip-box-widget.php');
    require_once(__DIR__ . '/widgets/video-testimonial-widget.php');
    $widgets_manager->register(new \Custom_Team_Member_Widget());
    $widgets_manager->register(new \Custom_CTA_Widget());
    $widgets_manager->register(new \Custom_Feature_Box_Widget());
    $widgets_manager->register(new \Custom_Pricing_Widget());
    $widgets_manager->register(new \Custom_Testimonial_Carousel_Widget());
    $widgets_manager->register(new \Custom_Blog_Posts_Grid_Widget());
    $widgets_manager->register(new \Custom_Portfolio_Gallery_Widget());
    $widgets_manager->register(new \Custom_Accordion_Widget());
    $widgets_manager->register(new \Custom_Flip_Box_Widget());
    $widgets_manager->register(new \Custom_Video_Testimonial_Widget());

}

add_action('elementor/widgets/register', 'register_custom_widgets');


// Check if Elementor is installed and activated
function check_elementor_activation() {
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function() {
            $message = sprintf(
                esc_html__('Custom Elementor Addon requires Elementor to be installed and activated.', 'custom-elementor-addon')
            );
            echo '<div class="notice notice-error"><p>' . $message . '</p></div>';
        });
        return;
    }
}
add_action('plugins_loaded', 'check_elementor_activation');

// Enqueue Styles
function enqueue_custom_elementor_styles() {
    wp_enqueue_style('custom-elementor-addon', plugins_url('style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_elementor_styles');

// ---------------------------------------------------


// Add Admin Menu
function custom_elementor_addon_admin_menu() {
    add_menu_page(
        esc_html__('Custom Elementor Addon', 'custom-elementor-addon'),
        esc_html__('Custom Addon', 'custom-elementor-addon'),
        'manage_options',
        'custom-elementor-addon',
        'custom_elementor_addon_settings_page',
        'dashicons-admin-generic',
        30
    );

    add_submenu_page(
        'custom-elementor-addon',
        esc_html__('Settings', 'custom-elementor-addon'),
        esc_html__('Settings', 'custom-elementor-addon'),
        'manage_options',
        'custom-elementor-addon',
        'custom_elementor_addon_settings_page'
    );

    add_submenu_page(
        'custom-elementor-addon',
        esc_html__('Widgets', 'custom-elementor-addon'),
        esc_html__('Widgets', 'custom-elementor-addon'),
        'manage_options',
        'custom-elementor-addon-widgets',
        'custom_elementor_addon_widgets_page'
    );

    add_submenu_page(
        'custom-elementor-addon',
        esc_html__('Documentation', 'custom-elementor-addon'),
        esc_html__('Documentation', 'custom-elementor-addon'),
        'manage_options',
        'custom-elementor-addon-docs',
        'custom_elementor_addon_docs_page'
    );
}
add_action('admin_menu', 'custom_elementor_addon_admin_menu');

// Register plugin settings
function custom_elementor_addon_register_settings() {
    // Register settings
    register_setting(
        'custom_elementor_addon_settings',
        'custom_elementor_addon_options',
        array(
            'sanitize_callback' => 'custom_elementor_addon_sanitize_options'
        )
    );


    // Add settings section
    add_settings_section(
        'custom_elementor_addon_general_section',
        esc_html__('General Settings', 'custom-elementor-addon'),
        'custom_elementor_addon_general_section_callback',
        'custom_elementor_addon_settings'
    );

    // Add settings fields
    add_settings_field(
        'enable_widgets',
        esc_html__('Enable/Disable Widgets', 'custom-elementor-addon'),
        'custom_elementor_addon_enable_widgets_callback',
        'custom_elementor_addon_settings',
        'custom_elementor_addon_general_section'
    );

    add_settings_field(
        'default_styles',
        esc_html__('Default Styles', 'custom-elementor-addon'),
        'custom_elementor_addon_default_styles_callback',
        'custom_elementor_addon_settings',
        'custom_elementor_addon_general_section'
    );

    add_settings_field(
        'custom_css',
        esc_html__('Custom CSS', 'custom-elementor-addon'),
        'custom_elementor_addon_custom_css_callback',
        'custom_elementor_addon_settings',
        'custom_elementor_addon_general_section'
    );
}
add_action('admin_init', 'custom_elementor_addon_register_settings');

// Sanitize options
function custom_elementor_addon_sanitize_options($options) {
    if (!is_array($options)) {
        return array();
    }

    $sanitized = array();

    // Sanitize enabled widgets
    if (isset($options['enabled_widgets'])) {
        $sanitized['enabled_widgets'] = array_map('sanitize_text_field', $options['enabled_widgets']);
    }

    // Sanitize default styles
    if (isset($options['default_styles'])) {
        $sanitized['default_styles'] = sanitize_text_field($options['default_styles']);
    }

    // Sanitize custom CSS
    if (isset($options['custom_css'])) {
        $sanitized['custom_css'] = wp_strip_all_tags($options['custom_css']);
    }

    return $sanitized;
}

// Section callback
function custom_elementor_addon_general_section_callback() {
    echo '<p>' . esc_html__('Configure the general settings for your Custom Elementor Addon.', 'custom-elementor-addon') . '</p>';
}

// Field callbacks
function custom_elementor_addon_enable_widgets_callback() {
    $options = get_option('custom_elementor_addon_options', array());
    $enabled_widgets = isset($options['enabled_widgets']) ? $options['enabled_widgets'] : array();

    $widgets = array(
    'cta' => 'CTA Widget',
    'feature_box' => 'Feature Box Widget',
    'team_member' => 'Team Member Widget',
    'pricing_table' => 'Pricing Table Widget',
    'testimonial_carousel' => 'Testimonial Carousel Widget',
    'blog_posts_grid' => 'Blog Posts Grid Widget',
    'portfolio_gallery' => 'Portfolio Gallery Widget'
);

    foreach ($widgets as $widget_id => $widget_name) {
        $checked = in_array($widget_id, $enabled_widgets) ? 'checked' : '';
        echo '<label style="display: block; margin-bottom: 10px;">';
        echo '<input type="checkbox" name="custom_elementor_addon_options[enabled_widgets][]" value="' . esc_attr($widget_id) . '" ' . $checked . '>';
        echo ' ' . esc_html($widget_name);
        echo '</label>';
    }
}

function custom_elementor_addon_default_styles_callback() {
    $options = get_option('custom_elementor_addon_options', array());
    $default_styles = isset($options['default_styles']) ? $options['default_styles'] : 'modern';
    ?>
    <select name="custom_elementor_addon_options[default_styles]" id="default_styles">
        <option value="modern" <?php selected($default_styles, 'modern'); ?>><?php echo esc_html__('Modern', 'custom-elementor-addon'); ?></option>
        <option value="classic" <?php selected($default_styles, 'classic'); ?>><?php echo esc_html__('Classic', 'custom-elementor-addon'); ?></option>
        <option value="minimal" <?php selected($default_styles, 'minimal'); ?>><?php echo esc_html__('Minimal', 'custom-elementor-addon'); ?></option>
    </select>
    <p class="description"><?php echo esc_html__('Select the default style for your widgets.', 'custom-elementor-addon'); ?></p>
    <?php
}

function custom_elementor_addon_custom_css_callback() {
    $options = get_option('custom_elementor_addon_options', array());
    $custom_css = isset($options['custom_css']) ? $options['custom_css'] : '';
    ?>
    <textarea name="custom_elementor_addon_options[custom_css]" id="custom_css" rows="8" cols="50" class="large-text code"><?php echo esc_textarea($custom_css); ?></textarea>
    <p class="description"><?php echo esc_html__('Add custom CSS for your widgets. This will be loaded on the frontend.', 'custom-elementor-addon'); ?></p>
    <?php
}

// Menu callback functions
function custom_elementor_addon_settings_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // Show success message if settings are saved
    if (isset($_GET['settings-updated'])) {
        add_settings_error(
            'custom_elementor_addon_messages',
            'custom_elementor_addon_message',
            esc_html__('Settings Saved', 'custom-elementor-addon'),
            'updated'
        );
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Custom Elementor Addon Settings', 'custom-elementor-addon'); ?></h1>
        <?php settings_errors('custom_elementor_addon_messages'); ?>

        <form method="post" action="options.php">
            <?php
            settings_fields('custom_elementor_addon_settings');
            do_settings_sections('custom_elementor_addon_settings');
            submit_button();
            ?>
        </form>
    </div>

    <style>
        .wrap {
            max-width: 960px;
        }
        .form-table th {
            width: 200px;
        }
        .form-table td {
            padding: 20px 10px;
        }
        .form-table textarea {
            font-family: monospace;
            resize: vertical;
        }
        .description {
            margin-top: 5px;
            color: #666;
        }
    </style>
    <?php
}

function custom_elementor_addon_widgets_page() {
     // Ensure proper security
     if (!current_user_can('manage_options')) {
        return;
    }

    // Add custom admin styles
    wp_enqueue_style('dashicons');
    ?>
    <div class="wrap custom-elementor-widgets">
        <h1><?php echo esc_html__('Available Widgets', 'custom-elementor-addon'); ?></h1>
        
        <!-- Search and View Controls -->
        <div class="widgets-filter-bar">
            <div class="search-box">
                <input type="text" id="widget-search" placeholder="<?php esc_attr_e('Search widgets...', 'custom-elementor-addon'); ?>">
                <span class="dashicons dashicons-search"></span>
            </div>
            <div class="view-controls">
                <button class="view-button active" data-view="grid"><span class="dashicons dashicons-grid-view"></span></button>
                <button class="view-button" data-view="list"><span class="dashicons dashicons-list-view"></span></button>
            </div>
        </div>

        <!-- Categories -->
        <div class="widget-categories">
            <button class="category-button active" data-category="all"><?php esc_html_e('All Widgets', 'custom-elementor-addon'); ?></button>
            <button class="category-button" data-category="content"><?php esc_html_e('Content', 'custom-elementor-addon'); ?></button>
            <button class="category-button" data-category="elements"><?php esc_html_e('Elements', 'custom-elementor-addon'); ?></button>
            <button class="category-button" data-category="marketing"><?php esc_html_e('Marketing', 'custom-elementor-addon'); ?></button>
        </div>

        <!-- Widgets Grid -->
        <div class="widgets-grid">
            <?php
            $widgets = array(
                array(
                    'name' => 'CTA Widget',
                    'description' => 'Create compelling call-to-action sections with customizable buttons and animations.',
                    'category' => 'marketing',
                    'icon' => 'megaphone',
                    'features' => array('Custom backgrounds', 'Button styling', 'Animation effects'),
                    'status' => 'active'
                ),
                array(
                    'name' => 'Feature Box Widget',
                    'description' => 'Display features with icons and descriptions in an elegant layout.',
                    'category' => 'content',
                    'icon' => 'star-filled',
                    'features' => array('Icon selection', 'Custom colors', 'Responsive design'),
                    'status' => 'active'
                ),
                array(
                    'name' => 'Team Member Widget',
                    'description' => 'Showcase team members with their photos, bios, and social media links.',
                    'category' => 'content',
                    'icon' => 'groups',
                    'features' => array('Social media integration', 'Custom styling', 'Hover effects'),
                    'status' => 'active'
                ),
                array(
                    'name' => 'Pricing Table Widget',
                    'description' => 'Display pricing plans with animations and feature lists.',
                    'category' => 'marketing',
                    'icon' => 'money-alt',
                    'features' => array('Feature lists', 'Popular plan highlight', 'Animations'),
                    'status' => 'active'
                ),
                array(
                    'name' => 'Testimonial Carousel',
                    'description' => 'Show client testimonials in an interactive carousel.',
                    'category' => 'elements',
                    'icon' => 'format-quote',
                    'features' => array('Star ratings', 'Auto-play option', 'Navigation controls'),
                    'status' => 'active'
                ),
                array(
                    'name' => 'Blog Posts Grid',
                    'description' => 'Display blog posts in a responsive grid layout.',
                    'category' => 'content',
                    'icon' => 'grid-view',
                    'features' => array('Custom grid layout', 'Excerpt options', 'Featured images'),
                    'status' => 'active'
                ),
                array(
                    'name' => 'Portfolio Gallery',
                    'description' => 'Create a stunning portfolio gallery with filtering options.',
                    'category' => 'elements',
                    'icon' => 'images-alt2',
                    'features' => array('Category filtering', 'Lightbox view', 'Hover effects'),
                    'status' => 'active'
                )
            );

            foreach ($widgets as $widget) : ?>
                <div class="widget-card" data-category="<?php echo esc_attr($widget['category']); ?>">
                    <div class="widget-card-header">
                        <span class="dashicons dashicons-<?php echo esc_attr($widget['icon']); ?>"></span>
                        <span class="widget-status <?php echo esc_attr($widget['status']); ?>">
                            <?php echo esc_html(ucfirst($widget['status'])); ?>
                        </span>
                    </div>
                    <div class="widget-card-content">
                        <h3><?php echo esc_html($widget['name']); ?></h3>
                        <p><?php echo esc_html($widget['description']); ?></p>
                        <div class="widget-features">
                            <?php foreach ($widget['features'] as $feature) : ?>
                                <span class="feature-tag"><?php echo esc_html($feature); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="widget-card-footer">
                        <a href="#" class="button button-secondary widget-settings">
                            <span class="dashicons dashicons-admin-generic"></span> <?php esc_html_e('Settings', 'custom-elementor-addon'); ?>
                        </a>
                        <a href="#" class="button button-primary widget-preview">
                            <span class="dashicons dashicons-visibility"></span> <?php esc_html_e('Preview', 'custom-elementor-addon'); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

  
    <style>
    .custom-elementor-widgets {
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header Styles */
    .custom-elementor-widgets h1 {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1e1e1e;
    }

    /* Filter Bar Styles */
    .widgets-filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 24px 0;
        padding: 16px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .search-box {
        position: relative;
        flex: 0 0 300px;
    }

    .search-box input {
        width: 100%;
        padding: 8px 12px 8px 35px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: #2271b1;
        box-shadow: 0 0 0 1px #2271b1;
    }

    .search-box .dashicons {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .view-controls {
        display: flex;
        gap: 8px;
    }

    .view-button {
        padding: 8px;
        background: #f0f0f1;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        color: #1e1e1e;
        transition: all 0.2s ease;
    }

    .view-button:hover {
        background: #2271b1;
        border-color: #2271b1;
        color: #fff;
    }

    .view-button.active {
        background: #2271b1;
        border-color: #2271b1;
        color: #fff;
    }

    /* Categories Styles */
    .widget-categories {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .category-button {
        padding: 8px 16px;
        background: #f0f0f1;
        border: 1px solid #ddd;
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
        color: #1e1e1e;
        transition: all 0.2s ease;
    }

    .category-button:hover {
        background: #2271b1;
        color: #fff;
        border-color: #2271b1;
    }

    .category-button.active {
        background: #2271b1;
        color: #fff;
        border-color: #2271b1;
    }

    /* Grid Styles */
    .widgets-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
    }

    .widget-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #ddd;
    }

    .widget-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .widget-card-header {
        padding: 20px;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }

    .widget-card-header .dashicons {
        font-size: 24px;
        width: 24px;
        height: 24px;
        color: #2271b1;
    }

    .widget-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .widget-status.active {
        background: #e6f4ea;
        color: #1e4620;
    }

    .widget-card-content {
        padding: 24px;
    }

    .widget-card-content h3 {
        margin: 0 0 12px 0;
        font-size: 18px;
        color: #1e1e1e;
        font-weight: 600;
    }

    .widget-card-content p {
        color: #50575e;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .widget-features {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 16px;
    }

    .feature-tag {
        background: #f0f0f1;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        color: #1e1e1e;
        font-weight: 500;
    }

    .widget-card-footer {
        padding: 16px 24px;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        gap: 12px;
        border-top: 1px solid #eee;
    }

    .widget-card-footer .button {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 500;
    }

    .widget-card-footer .button .dashicons {
        font-size: 16px;
        width: 16px;
        height: 16px;
    }

    /* List View Styles */
    .widgets-grid.list-view {
        display: block;
    }

    .widgets-grid.list-view .widget-card {
        display: flex;
        margin-bottom: 16px;
    }

    .widgets-grid.list-view .widget-card-header {
        width: 80px;
        flex-shrink: 0;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        border-bottom: none;
        border-right: 1px solid #eee;
    }

    .widgets-grid.list-view .widget-card-content {
        flex: 1;
        padding: 20px;
    }

    .widgets-grid.list-view .widget-card-footer {
        width: 200px;
        flex-direction: column;
        justify-content: center;
        border-top: none;
        border-left: 1px solid #eee;
    }

    /* Responsive Styles */
    @media screen and (max-width: 1200px) {
        .widgets-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media screen and (max-width: 782px) {
        .widgets-filter-bar {
            flex-direction: column;
            gap: 16px;
        }

        .search-box {
            flex: none;
            width: 100%;
        }

        .widgets-grid.list-view .widget-card {
            flex-direction: column;
        }

        .widgets-grid.list-view .widget-card-header,
        .widgets-grid.list-view .widget-card-footer {
            width: 100%;
            border: none;
        }

        .widgets-grid.list-view .widget-card-header {
            border-bottom: 1px solid #eee;
        }

        .widgets-grid.list-view .widget-card-footer {
            border-top: 1px solid #eee;
            flex-direction: row;
        }
    }

    /* Button Enhancements */
    .button-secondary {
        background: #f6f7f7;
        border-color: #2271b1;
        color: #2271b1;
    }

    .button-secondary:hover {
        background: #f0f0f1;
        border-color: #0a4b78;
        color: #0a4b78;
    }

    .button-primary {
        background: #2271b1;
        border-color: #2271b1;
        color: #fff;
    }

    .button-primary:hover {
        background: #135e96;
        border-color: #135e96;
    }

    /* Animation Effects */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .widget-card {
        animation: fadeIn 0.3s ease-out;
    }
</style>
   

    <script>
    jQuery(document).ready(function($) {
        // Search functionality
        $('#widget-search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.widget-card').each(function() {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.includes(searchTerm));
            });
        });

        // View toggle
        $('.view-button').click(function() {
            $('.view-button').removeClass('active');
            $(this).addClass('active');
            
            const view = $(this).data('view');
            if (view === 'list') {
                $('.widgets-grid').addClass('list-view');
            } else {
                $('.widgets-grid').removeClass('list-view');
            }
        });

        // Category filter
        $('.category-button').click(function() {
            $('.category-button').removeClass('active');
            $(this).addClass('active');
            
            const category = $(this).data('category');
            if (category === 'all') {
                $('.widget-card').show();
            } else {
                $('.widget-card').hide();
                $('.widget-card[data-category="' + category + '"]').show();
            }
        });
    });
    </script>
    <?php
}

function custom_elementor_addon_docs_page() {
    ?>
    <div class="wrap custom-elementor-docs">
        <h1><?php echo esc_html__('Documentation', 'custom-elementor-addon'); ?></h1>
        
        <!-- Documentation Navigation -->
        <div class="docs-navigation">
            <button class="nav-tab active" data-tab="getting-started">Getting Started</button>
            <button class="nav-tab" data-tab="widgets">Widgets</button>
            <button class="nav-tab" data-tab="customization">Customization</button>
            <button class="nav-tab" data-tab="faq">FAQ</button>
        </div>

        <!-- Documentation Content -->
        <div class="docs-content">
            <!-- Getting Started Section -->
            <div class="doc-section active" id="getting-started">
                <div class="doc-card">
                    <h2><span class="dashicons dashicons-welcome-learn-more"></span> Getting Started</h2>
                    <p class="description">Welcome to the Custom Elementor Addon documentation. Here's everything you need to know to get started.</p>
                    
                    <div class="doc-subsection">
                        <h3>Installation</h3>
                        <ol>
                            <li>Upload the plugin files to your WordPress installation</li>
                            <li>Activate the plugin through the 'Plugins' menu</li>
                            <li>Find the widgets in your Elementor editor under the 'Custom Addon' category</li>
                        </ol>
                    </div>

                    <div class="doc-subsection">
                        <h3>System Requirements</h3>
                        <ul>
                            <li>WordPress 5.0 or higher</li>
                            <li>Elementor 3.0 or higher</li>
                            <li>PHP 7.4 or higher</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Widgets Section -->
            <div class="doc-section" id="widgets">
                <div class="doc-card">
                    <h2><span class="dashicons dashicons-grid-view"></span> Available Widgets</h2>
                    
                    <div class="widget-docs-grid">
                        <div class="widget-doc-item">
                            <h3>CTA Widget</h3>
                            <p>Create engaging call-to-action sections with customizable buttons and animations.</p>
                            <ul class="feature-list">
                                <li>Custom backgrounds</li>
                                <li>Button styling options</li>
                                <li>Animation effects</li>
                            </ul>
                        </div>

                        <div class="widget-doc-item">
                            <h3>Feature Box Widget</h3>
                            <p>Display features with icons and descriptions in an elegant layout.</p>
                            <ul class="feature-list">
                                <li>Icon selection</li>
                                <li>Custom colors</li>
                                <li>Responsive design</li>
                            </ul>
                        </div>

                        <div class="widget-doc-item">
                            <h3>Team Member Widget</h3>
                            <p>Showcase team members with their photos, bios, and social media links.</p>
                            <ul class="feature-list">
                                <li>Social media integration</li>
                                <li>Custom styling options</li>
                                <li>Hover effects</li>
                            </ul>
                        </div>

                        <div class="widget-doc-item">
                            <h3>Pricing Table Widget</h3>
                            <p>Create beautiful pricing tables with animations and feature lists.</p>
                            <ul class="feature-list">
                                <li>Feature lists</li>
                                <li>Popular plan highlight</li>
                                <li>Custom animations</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customization Section -->
            <div class="doc-section" id="customization">
                <div class="doc-card">
                    <h2><span class="dashicons dashicons-admin-customizer"></span> Customization Guide</h2>
                    
                    <div class="doc-subsection">
                        <h3>Global Settings</h3>
                        <p>Learn how to customize the global settings for all widgets.</p>
                        <div class="code-block">
                            <pre><code>add_filter('custom_elementor_addon_settings', function($settings) {
    $settings['color'] = '#2271b1';
    return $settings;
});</code></pre>
                        </div>
                    </div>

                    <div class="doc-subsection">
                        <h3>Custom CSS</h3>
                        <p>Add your own custom CSS to modify widget appearances.</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="doc-section" id="faq">
                <div class="doc-card">
                    <h2><span class="dashicons dashicons-editor-help"></span> Frequently Asked Questions</h2>
                    
                    <div class="faq-item">
                        <h3>How do I update the plugin?</h3>
                        <p>The plugin can be updated through the WordPress admin panel, just like any other plugin.</p>
                    </div>

                    <div class="faq-item">
                        <h3>How can I modify widget styles?</h3>
                        <p>You can modify widget styles using the built-in Elementor controls or by adding custom CSS.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Documentation Page Styles */
        .custom-elementor-docs {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        /* Navigation Tabs */
        .docs-navigation {
            display: flex;
            gap: 4px;
            margin: 30px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 0;
        }

        .nav-tab {
            padding: 12px 24px;
            background: #f0f0f1;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 4px 4px 0 0;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #1e1e1e;
            margin-bottom: -1px;
            transition: all 0.2s ease;
        }

        .nav-tab:hover {
            background: #fff;
            color: #2271b1;
        }

        .nav-tab.active {
            background: #fff;
            color: #2271b1;
            border-bottom: 2px solid #2271b1;
        }

        /* Documentation Content */
        .docs-content {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .doc-section {
            display: none;
            animation: fadeIn 0.3s ease-out;
        }

        .doc-section.active {
            display: block;
        }

        .doc-card {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .doc-card h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1e1e1e;
            margin: 0 0 20px 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f1;
        }

        .doc-card h2 .dashicons {
            color: #2271b1;
            font-size: 24px;
            width: 24px;
            height: 24px;
        }

        .doc-subsection {
            margin: 30px 0;
        }

        .doc-subsection h3 {
            color: #1e1e1e;
            font-size: 18px;
            margin: 0 0 15px 0;
        }

        /* Widget Documentation Grid */
        .widget-docs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .widget-doc-item {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            border: 1px solid #eee;
        }

        .widget-doc-item h3 {
            color: #2271b1;
            margin: 0 0 10px 0;
        }

        .widget-doc-item p {
            color: #50575e;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .feature-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .feature-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 8px;
            font-size: 13px;
            color: #666;
        }

        .feature-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #2271b1;
        }

        /* Code Block Styles */
        .code-block {
            background: #f8f9fa;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #eee;
            overflow-x: auto;
        }

        .code-block pre {
            margin: 0;
            font-family: monospace;
            font-size: 13px;
            color: #1e1e1e;
        }

        /* FAQ Styles */
        .faq-item {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
        }

        .faq-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .faq-item h3 {
            color: #1e1e1e;
            font-size: 16px;
            margin: 0 0 10px 0;
        }

        .faq-item p {
            color: #50575e;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media screen and (max-width: 782px) {
            .docs-navigation {
                flex-wrap: wrap;
                gap: 8px;
            }

            .nav-tab {
                flex: 1 1 calc(50% - 8px);
                text-align: center;
            }

            .widget-docs-grid {
                grid-template-columns: 1fr;
            }

            .doc-card {
                padding: 20px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
    jQuery(document).ready(function($) {
        // Tab functionality
        $('.nav-tab').click(function() {
            const tabId = $(this).data('tab');
            
            // Update active tab
            $('.nav-tab').removeClass('active');
            $(this).addClass('active');
            
            // Show selected content
            $('.doc-section').removeClass('active');
            $(`#${tabId}`).addClass('active');
        });
    });
    </script>
    <?php
}
//-------------------------------------------



function custom_elementor_addon_admin_enqueue_scripts($hook) {
    if('custom-elementor-addon_page_custom-elementor-addon-widgets' !== $hook) {
        return;
    }
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'custom_elementor_addon_admin_enqueue_scripts');