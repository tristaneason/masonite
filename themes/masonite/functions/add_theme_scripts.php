<?php
function add_theme_scripts() {
    wp_enqueue_style('style', get_stylesheet_uri(), '', date('Y-m-d'));
}
add_action('wp_enqueue_scripts', 'add_theme_scripts');
?>
