<?php
function add_video_details() {
    add_meta_box(
        'video_details', // div id containing rendered fields
        'Video Details', // section heading displayed as text
        'display_video_details', // callback function to render fields
        'video', // name of post type on which to render fields
        'advanced', // location on the screen
        'high' // placement priority
    );
}
add_action('add_meta_boxes', 'add_video_details');

function display_video_details() {
    global $post;
    $video = get_post_meta($post->ID, 'video_details', true);

    if (is_array($video) && isset($video['name']) && !empty($video['name']))
        $name = $video['name'];

    if (is_array($video) && isset($video['youtube-id']))
        $yt_id = $video['youtube-id'];
    ?>

    <input type="hidden" name="video_details_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>">

    <div>
        <label for="video_details[name]"><strong>Name</strong></label><br>
        <input type="text" name="video_details[name]" class="regular-text" value="<?php echo $name; ?>">
    </div>

    <div>
        <label for="video_details[youtube-id]"><strong>YouTube ID</strong></label><br>
        <input type="text" name="video_details[youtube-id]" class="regular-text" value="<?php echo $yt_id; ?>">
    </div>

    <?php
}

function save_video_details($post_id) {
    if (!wp_verify_nonce($_POST['video_details_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if ($_POST['post_type'] === 'video') {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    $old = get_post_meta($post_id, 'video_details', true);
    $new = $_POST['video_details'];

    if ($new && $new !== $old) {
        update_post_meta($post_id, 'video_details', $new);
    } elseif ($new && $old === '') {
        delete_post_meta($post_id, 'video_details', $old);
    }
}
add_action('save_post', 'save_video_details');
?>
