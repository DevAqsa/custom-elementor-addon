# Custom Elementor Addon

A powerful WordPress plugin that extends Elementor Page Builder with custom widgets and features.

## Features

### Custom Widgets
- **CTA Widget** - Create compelling call-to-action sections with customizable buttons and animations
- **Feature Box Widget** - Display features with icons and descriptions in an elegant layout
- **Team Member Widget** - Showcase team members with their photos, bios, and social media links
- **Pricing Table Widget** - Display pricing plans with feature lists and animations
- **Testimonial Carousel Widget** - Show client testimonials in an interactive carousel
- **Blog Posts Grid Widget** - Display blog posts in a responsive grid layout
- **Portfolio Gallery Widget** - Create stunning portfolio galleries with filtering options

### Admin Features
- Comprehensive settings panel for widget configuration
- Widget management interface with grid/list views
- Detailed documentation section
- Custom CSS integration
- Multiple style presets (Modern, Classic, Minimal)

## Requirements

- WordPress 5.0 or higher
- Elementor 3.0 or higher
- PHP 7.4 or higher

## Installation

1. Download the plugin zip file
2. Go to WordPress admin > Plugins > Add New
3. Click "Upload Plugin" and choose the downloaded file
4. Click "Install Now" and then "Activate"
5. Navigate to Custom Addon in the WordPress admin menu to configure settings

## Configuration

### General Settings
1. Go to WordPress Admin > Custom Addon > Settings
2. Enable/disable specific widgets
3. Choose default style preset
4. Add custom CSS if needed

### Widget Settings
Each widget can be customized through:
- Elementor's built-in style controls
- Widget-specific options
- Global style presets

## Usage

1. Edit a page with Elementor
2. Look for the "Custom Addon" category in the Elementor widget panel
3. Drag and drop desired widgets into your layout
4. Customize widget settings using Elementor's interface


## Developer Information

### Adding Custom Styles
You can add custom styles using the plugin's CSS editor or by using WordPress hooks:

```php
add_filter('custom_elementor_addon_settings', function($settings) {
    $settings['custom_css'] = 'your custom CSS here';
    return $settings;
});
```

### Widget Categories
Widgets are organized into the following categories:
- Content
- Elements
- Marketing

## Troubleshooting

### Common Issues
1. **Plugin Not Appearing**: Ensure Elementor is installed and activated
2. **Widgets Not Loading**: Check PHP version compatibility
3. **Styling Issues**: Clear cache and regenerate CSS

## Support

For support inquiries:
1. Check the plugin documentation under Custom Addon > Documentation
2. Ensure you're using compatible versions of WordPress and Elementor
3. Contact plugin support with detailed information about your issue

## License

This plugin is licensed under the GPL v2 or later.

## Credits

Developed by Aqsa Mumtaz

## Changelog

### 1.0.0
- Initial release
- Added 7 custom widgets
- Implemented admin interface
- Added documentation section