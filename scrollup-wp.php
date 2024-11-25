<?php
/**
 * Plugin Name: Scroll up wp
 * Plugin URI:  https://wordpress.org/plugins/scrollup-wp
 * Description: A simple plugin to add a scroll-to-top functionality.
 * Version:     1.0.0
 * WP Require : 6.7.1
 * PHP Require : 8.3
 * Author:      Milon Kumar
 * Author URI:  https://wordpress.org/plugins/scrollup-wp
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:  https://github.com/milon-kumar
 * Text Domain: suw
 */

// Including Css
function suw_enqueue_styles(){
    wp_enqueue_style('suw-style', plugins_url('assets/css/suw-image.css', __FILE__));
}
add_action("wp_enqueue_scripts", 'suw_enqueue_styles');


// Including Script
function suw_enqueue_scripts(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('suw-plugin-script', plugins_url('assets/js/suw-jquery.scrollUp.min.js', __FILE__),array(),'1.0.0', true);
}
add_action("wp_enqueue_scripts", 'suw_enqueue_scripts');

//Plugin Activation
function suw_scroll_activation(){
    ?>
        <script>
            jQuery(document).ready(function($) {
                $.scrollUp();
            });
        </script>
    <?php
}
add_action("wp_footer", 'suw_scroll_activation');

// Plugin Customization Settings
add_action('customize_register', 'suw_plugin_customize');
function suw_plugin_customize($wp_customize) {
    // Adding a section for the scroll-up settings
    $wp_customize->add_section('suw_scroll_up_section', array(
        'title'       => __('Scroll Up', 'scrollup-wp'),
        'description' => __('A simple plugin to add a scroll-to-top functionality.'),
    ));

    // Adding the background color setting
    $wp_customize->add_setting('suw_bg_color', array(
        'default'           => '#000000', // Default color value
        'sanitize_callback' => 'sanitize_hex_color', // Ensure the color value is valid
    ));

    // Adding the background color control
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'suw_bg_color', array(
        'label'   => __('Background Color', 'scrollup-wp'),
        'section' => 'suw_scroll_up_section',
        'type' => 'color',
    )));

    // Adding the background color setting
    $wp_customize->add_setting('suw_border_rounded', array(
        'default' => '5px', // Ensure this is a string with 'px'
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'suw_border_rounded', array(
        'label'   => __('Border Rounded', 'scrollup-wp'),
        'section' => 'suw_scroll_up_section',
        'type' => 'number',
    )));

}

// Plugin Color Set
function suw_plugin_color_set(){
    // Get the background color and border radius value from the Customizer
    $bg_color = get_theme_mod('suw_bg_color', '#000000'); // Default color is #000000 if no setting is saved
    $border_radius = get_theme_mod('suw_border_rounded', '15px'); // Get border radius setting

    ?>
    <style>
        #scrollUp {
            background-color: <?php echo esc_attr($bg_color); ?>;
            border-radius: <?php echo esc_attr($border_radius); ?>px; /* Ensure proper border-radius value */
        }
    </style>
    <?php
}
add_action('wp_head', 'suw_plugin_color_set');
?>
