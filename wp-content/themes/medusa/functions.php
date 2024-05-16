<?php
// Enqueue scripts and styles
function my_custom_theme_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_style('main-style', get_template_directory_uri() . '/dist/main.min.css');
    wp_enqueue_script('main-js', get_template_directory_uri() . '/dist/main.min.js', [], false, true); // Enqueue the minified JS
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue_scripts');

// Include Timber
if (!class_exists('Timber')) {
    add_action('admin_notices', function () {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
    });
    return;
}

// Set Timber directories
Timber::$dirname = array( 'templates', 'views' );

// Extend Timber Site Class
class MyTheme extends Timber\Site {
    public function __construct() {
        add_filter('timber/context', array( $this, 'add_to_context' ));
        add_filter('timber/twig', array( $this, 'add_to_twig' ));
        parent::__construct();
    }

    public function add_to_context($context) {
        // Add global context variables here
        $context['menu'] = new Timber\Menu('primary');
        $context['site'] = $this;
        return $context;
    }

    public function add_to_twig($twig) {
        // Add custom Twig functions here
        $twig->addFunction(new Timber\Twig_Function('body_class', 'body_class'));
        $twig->addFunction(new Timber\Twig_Function('language_attributes', 'language_attributes'));
        return $twig;
    }
}

// Load Timber ACF WP Blocks utilities
require_once('utilites/timber-acf-wp-blocks.php');

// Allow .ico and .svg uploads
function custom_mime_types($mimes) {
    $mimes['ico'] = 'image/x-icon';
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'custom_mime_types');

// Initialize the MyTheme class
new MyTheme();

// Register Menus
function register_my_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu'),
        'secondary' => __('Secondary Menu'),
    ]);
}
add_action('init', 'register_my_menus');
?>
