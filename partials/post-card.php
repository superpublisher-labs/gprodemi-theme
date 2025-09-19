<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<article>
    <a href="<?php the_permalink(); ?>"
        title="<?php the_title() ?: __('Sem Título', 'gprodemi'); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php
            echo get_the_post_thumbnail(
                $post,
                'large',
                [
                    'class' => 'w-full rounded-xl flex',
                    'alt' => get_the_title($post) ?: __('Sem Título', 'gprodemi')
                ]
            );
            ?>
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" alt="<?php the_title() ?: __('Sem Título', 'gprodemi'); ?>" class="w-full rounded-xl">
        <?php endif; ?>
    </a>

    <p class="text-2xl font-semibold mt-4"><?php the_title() ?: __('Sem Título', 'gprodemi'); ?></p>
    <p class="text-gray-600 mt-2 text-lg"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>

    <a href="<?php the_permalink(); ?>"
        title="<?php the_title() ?: __('Sem Título', 'gprodemi'); ?>"
        class="text-[var(--color-links)] hover:underline flex items-center gap-2 text-lg mt-4 font-semibold">
        <?php _e('Read More', 'gprodemi'); ?><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
    </a>
</article>