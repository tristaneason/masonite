<?php
get_header();

$product_details_loop = new WP_Query([
    'post_type' => 'product',
    'order' => 'ASC',
]);
$video_details_loop = new WP_Query([
    'post_type' => 'video',
    'order' => 'ASC',
]);
?>

<section id="products" class="container">
    <h2 class="text-center">Get Started with SimilarWeb Products</h2>
    <div class="grid thirds">
        <?php
        while ($product_details_loop->have_posts()):
            $product_details_loop->the_post();
            $product = get_post_meta($post->ID, 'product_details', true);

            if (is_array($product)) {
                $title = (isset($product['title'])) ? $product['title'] : the_title();
                $link = (isset($product['link']) && !empty($product['link'])) ? $product['link'] : get_permalink();
                $image = (isset($product['image'])) ? $product['image'] : null;
                $bg_color = (isset($product['background_color'])) ? $product['background_color'] : 'tomato';
            } ?>

            <div class="product">
                <a href="<?php echo $link; ?>">
                    <div class="flex align-center justify-center icon" style="background: <?php echo $bg_color; ?>;">
                        <img src="<?php echo $image; ?>" alt="<?php echo $title; ?> Image">
                    </div>
                </a>
                <div class="flex aling-center justify-center title">
                    <h3><?php echo $title; ?></h3>
                </div>
            </div>

        <?php
        endwhile; ?>
    </div>
</section>

<section id="videos" class="container">
    <h2 class="text-center">Getting Started Videos</h2>
    <div class="flex column">
        <?php
        while ($video_details_loop->have_posts()):
            $video_details_loop->the_post();
            $video = get_post_meta($post->ID, 'video_details', true);

            if (is_array($video)) {
                $name = (isset($video['name'])) ? $video['name'] : null;
                $yt_id = (isset($video['youtube-id'])) ? $video['youtube-id'] : null;
            } ?>

            <div id="<?php echo $yt_id; ?>" class="video hidden">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $yt_id; ?>" frameborder="0" allowfullscreen></iframe>
                <span class="link"><?php echo $name; ?></span>
            </div>

        <?php
        endwhile; ?>
    </div>
</section>

<?php
wp_reset_query();
get_footer();
?>
