<?php
/*
|--------------------------------------------------------------------------
| Change <html> Lang Attribute To ISO 639-1 Language Codes
|--------------------------------------------------------------------------
*/
//add_filter('language_attributes', function () {
//    return 'lang="'.explode('-', get_bloginfo('language'))[0].'"';
//}, 10, 2);

/*
|--------------------------------------------------------------------------
| Set default attachment filter for post/product image
|--------------------------------------------------------------------------
*/
/*add_action('admin_footer-post-new.php', 'wp_admin_default_media_attachment_filter');
add_action('admin_footer-post.php', 'wp_admin_default_media_attachment_filter');
function wp_admin_default_media_attachment_filter()
{
    ?>
    <script type="text/javascript">
        jQuery(document).on("DOMNodeInserted", function () {
            jQuery('select.attachment-filters [value="uploaded"]').attr('selected', true).parent().trigger('change');
        });
    </script>
    <?php
}*/
