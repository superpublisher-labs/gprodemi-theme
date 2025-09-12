<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<article class="flex flex-col md:flex-row items-center justify-between gap-5">
    <a href="<?php the_permalink(); ?>" class="text-2xl flex-1 font-medium max-w-xl">
        <h3><?php the_title() ?: __('Sem Título', 'gprodemi'); ?></h3>
    </a>
    <div class="text-gray-600 flex-1 text-lg flex flex-col gap-3">
        <p><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
        <a href="<?php the_permalink(); ?>"
            class="text-[var(--color-links)] hover:!underline flex items-center gap-2 font-semibold">
            <?php _e('Read More', 'gprodemi'); ?><i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</article>