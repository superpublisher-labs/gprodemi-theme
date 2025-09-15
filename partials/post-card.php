<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<article>
    <a href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', ['class' => 'w-full rounded-xl flex']); ?>
        <?php else: ?>
            <img src="https://via.placeholder.com/400x250" alt="<?php the_title(); ?>" class="w-full rounded-xl">
        <?php endif; ?>
    </a>

    <h3 class="text-2xl font-semibold mt-4"><?php the_title(); ?></h3>
    <p class="text-gray-700 mt-2 text-lg"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>

    <a href="<?php the_permalink(); ?>"
        class="text-[var(--color-links)] hover:underline flex items-center gap-2 text-lg mt-4 font-semibold">
        <?php _e('Read More', 'gprodemi'); ?><i data-lucide="arrow-right" class="w-4 h-4"></i>
    </a>
</article>