<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<article class="w-full container mx-auto flex items-center justify-between">
    <div class="flex flex-col items-center w-full p-8 py-15 gap-2">
        <?php
        $author_id    = get_the_author_meta('ID');
        $author_bio   = get_the_author_meta('description');

        if (empty($author_bio)) {
            $transient_key = 'gravatar_bio_' . $author_id;
            $author_bio    = get_transient($transient_key);

            if (false === $author_bio) {
                $author_email = get_the_author_meta('user_email');
                $hash         = md5(strtolower(trim($author_email)));
                $response     = wp_remote_get("https://www.gravatar.com/" . $hash . ".php", ['timeout' => 2]);

                if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                    $profile = unserialize(wp_remote_retrieve_body($response));
                    $author_bio = isset($profile['entry'][0]['aboutMe']) ? $profile['entry'][0]['aboutMe'] : '';
                } else {
                    $author_bio = '';
                }

                set_transient($transient_key, $author_bio, 12 * HOUR_IN_SECONDS);
            }
        }
        ?>
        <img src="<?php echo get_avatar_url($author_id, ['size' => 96]); ?>"
            class="w-16 h-16 rounded-xl" alt="<?php the_author(); ?>">

        <span class="text-gray-600 font-medium"><?php _e('Posted and reviewed', 'gprodemi'); ?></span>
        <span class="text-xl font-semibold">
            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                <?php the_author(); ?>
            </a>
        </span>

        <?php if (!empty($author_bio)): ?>
            <p class="text-gray-600 text-sm text-center max-w-md mb-2">
                <?php echo wp_kses_post($author_bio); ?>
            </p>
        <?php endif; ?>
    </div>
</article>