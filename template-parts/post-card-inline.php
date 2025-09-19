<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<article class="flex flex-col md:flex-row items-center justify-between gap-5 w-full">
    <a href="<?php the_permalink(); ?>" class="text-2xl flex-1 font-medium max-w-xl" title="<?php the_title() ?: __('Sem Título', 'gprodemi'); ?>">
        <p><?php the_title() ?: __('Sem Título', 'gprodemi'); ?></p>
    </a>
    <div class="text-gray-600 flex-1 text-lg flex flex-col gap-3">
        <p><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
        <a href="<?php the_permalink(); ?>"
            title="<?php the_title() ?: __('Sem Título', 'gprodemi'); ?>"
            class="text-[var(--color-links)] hover:!underline flex items-center gap-2 font-semibold">
            <?php _e('Read More', 'gprodemi'); ?>
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right">
                <path d="M5 12h14" />
                <path d="m12 5 7 7-7 7" />
            </svg>
        </a>
    </div>
</article>