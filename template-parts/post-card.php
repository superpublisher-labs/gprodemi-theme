<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<article>
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php
            // a função the_post_thumbnail já usa o post global do loop, mais simples.
            the_post_thumbnail('large', [
                'class' => 'w-full rounded-xl flex',
                'alt'   => get_the_title() ?: __('Sem Título', 'gprodemi')
            ]);
            ?>
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" alt="<?php the_title_attribute(); ?>" class="w-full rounded-xl">
        <?php endif; ?>
    </a>

    <h2 class="text-xl font-medium mt-4">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>

    <div class="text-gray-700 mt-2 text-lg">
        <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
    </div>

    <a href="<?php the_permalink(); ?>"
        class="text-[var(--color-links)] hover:underline flex items-center gap-2 text-lg mt-4 font-semibold"
        title="<?php the_title_attribute(); ?>">
        <?php _e('Read More', 'gprodemi'); ?>
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right">
            <path d="M5 12h14" />
            <path d="m12 5 7 7-7 7" />
        </svg>
    </a>
</article>