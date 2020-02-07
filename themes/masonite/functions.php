<?php
include __DIR__ . '/functions/add_theme_scripts.php';
include __DIR__ . '/functions/post_type_product.php';
include __DIR__ . '/functions/post_type_video.php';
include __DIR__ . '/functions/add_product_details.php';
include __DIR__ . '/functions/add_video_details.php';
include __DIR__ . '/functions/add_mime_types.php';

add_theme_support('post-thumbnails');
flush_rewrite_rules();
?>
