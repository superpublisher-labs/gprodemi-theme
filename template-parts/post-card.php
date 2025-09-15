<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$post = get_query_var('post');
if (!$post) return;
setup_postdata($post);
?>

<article>
    <a href="<?php echo get_permalink($post); ?>">
        <?php if (has_post_thumbnail()) : ?>
            <?php echo get_the_post_thumbnail($post, 'large', ['class' => 'w-full rounded-xl flex', 'height' => '600', 'width' => '360']); ?>
        <?php else: ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" alt="<?php the_title(); ?>" class="w-full rounded-xl">
        <?php endif; ?>
    </a>

    <h3 class="text-xl font-medium mt-4"><?php the_title() ?: __('Sem Título', 'gprodemi'); ?></h3>
    <p class="text-gray-700 mt-2 text-lg"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
    <a href="<?php the_permalink(); ?>" class="text-[var(--color-links)] hover:underline flex items-center gap-2 text-lg mt-4 font-semibold">
        <?php _e('Read More', 'gprodemi'); ?><i data-lucide="arrow-right" class="w-4 h-4"></i>
    </a>
</article>

<?php wp_reset_postdata(); ?>