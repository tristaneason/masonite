<?php
function add_product_details() {
    add_meta_box(
        'product_details', // div id containing rendered fields
        'Product Details', // section heading displayed as text
        'display_product_details', // callback function to render fields
        'product', // name of post type on which to render fields
        'advanced', // location on the screen
        'high' // placement priority
    );
}
add_action('add_meta_boxes', 'add_product_details');

function save_product_details($post_id) {
    if (isset($_POST['product_details_nonce']) && !wp_verify_nonce($_POST['product_details_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if ($_POST['post_type'] === 'product') {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    $old = get_post_meta($post_id, 'product_details', true);
    $new = $_POST['product_details'];

    if ($new && $new !== $old) {
        update_post_meta($post_id, 'product_details', $new);
    } elseif ($new && $old === '') {
        delete_post_meta($post_id, 'product_details', $old);
    }
}
add_action('save_post', 'save_product_details');

function display_product_details() {
    global $post;
    $product = get_post_meta($post->ID, 'product_details', true);

    if (is_array($product) && isset($product['title']) && !empty($product['title']))
        $title = $product['title'];

    if (is_array($product) && isset($product['link']) && !empty($product['link']))
        $link = $product['link'];

    if (is_array($product) && isset($product['image']))
        $image = $product['image'];

    if (is_array($product) && isset($product['background_color']))
        $bg_color = $product['background_color']; ?>

    <input type="hidden" name="product_details_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>">

    <div>
        <label for="product_details[title]"><strong>Title</strong></label><br>
        <input type="text" name="product_details[title]" class="regular-text" value="<?php echo $title; ?>">
    </div>

    <div>
        <label for="product_details[link]"><strong>Link</strong></label><br>
        <input type="text" name="product_details[link]" class="regular-text" value="<?php echo $link; ?>">
    </div>

    <div>
        <label for="product_details[image]"><strong>Image</strong></label><br>
        <input type="text" name="product_details[image]" class="meta-image regular-text" value="<?php echo $image; ?>">
        <input type="button" class="button image-upload" value="Browse">
    </div>

    <script>
    jQuery(document).ready(function ($) {
      // Instantiates the variable that holds the media library frame.
      var meta_image_frame;
      // Runs when the image button is clicked.
      $('.image-upload').click(function (e) {
        // Get preview pane
        var meta_image_preview = $(this).parent().parent().children('.image-preview');
        // Prevents the default action from occuring.
        e.preventDefault();
        var meta_image = $(this).parent().children('.meta-image');
        // If the frame already exists, re-open it.
        if (meta_image_frame) {
          meta_image_frame.open();
          return;
        }
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
          title: meta_image.title,
          button: {
            text: meta_image.button
          }
        });
        // Runs when an image is selected.
        meta_image_frame.on('select', function () {
          // Grabs the attachment selection and creates a JSON representation of the model.
          var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
          // Sends the attachment URL to our custom image input field.
          meta_image.val(media_attachment.url);
          meta_image_preview.children('img').attr('src', media_attachment.url);
        });
        // Opens the media library frame.
        meta_image_frame.open();
      });
    });
    </script>

    <div>
        <label for="product_details[background_color]"><strong>Background Color</strong></label><br>
        <input type="text" name="product_details[background_color]" class="regular-text" value="<?php echo $bg_color; ?>">
    </div>
    <?php
}
?>
