<?php
function post_type_product() {
    register_post_type('product', [
        'labels' => [
            'name' => __('Products'),
            'singular_name' => __('Product')
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'product'),
        'menu_icon' => 'dashicons-products',
        'supports' => ['title', 'thumbnail'],
    ]);
}
add_action('init', 'post_type_product');
?>
