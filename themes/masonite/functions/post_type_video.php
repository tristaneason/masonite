<?php
function post_type_video() {
    register_post_type('video', [
        'labels' => [
            'name' => __('Videos'),
            'singular_name' => __('Video')
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'video'),
        'menu_icon' => 'dashicons-video-alt2',
        'supports' => ['title'],
    ]);
}
add_action('init', 'post_type_video');
?>
