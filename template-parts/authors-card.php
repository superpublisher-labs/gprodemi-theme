<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<article class="w-full container mx-auto flex items-center justify-between">
    <div class="flex flex-col items-center w-full p-8 py-15 gap-2">
        <img src="<?php echo get_avatar_url(get_the_author_meta('ID'), ['size' => 96]); ?>"
            class="w-16 h-16 rounded-xl" alt="<?php the_author(); ?>">

        <span class="text-gray-600 font-medium"><?php _e('Posted and reviewed', 'gprodemi'); ?></span>
        <span class="text-xl font-semibold">
            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                <?php the_author(); ?>
            </a>
        </span>
        <?php if (get_the_author_meta('description')): ?>
            <p class="text-gray-600 text-sm text-center max-w-md mb-2">
                <?php echo get_the_author_meta('description'); ?>
            </p>
        <?php endif; ?>
    </div>
</article>