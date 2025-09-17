<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$post = get_query_var('post');
if (!$post) return;
setup_postdata($post);
?>

<article class="bg-gray-100 rounded-xl p-6 flex flex-col justify-center items-center text-center gap-4">
    <p class="!text-xl !font-medium"><?php the_title() ?: __('Sem Título', 'gprodemi'); ?></p>
    <p class="text-gray-700 mt-2 !text-lg"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
    <a href="<?php the_permalink(); ?>"
        class="text-[var(--color-links)] hover:underline flex items-center gap-2 text-lg mt-4 font-semibold"
        title="<?php the_title() ?: __('Sem Título', 'gprodemi'); ?>">
        <?php _e('Read More', 'gprodemi'); ?><i data-lucide="arrow-right" class="w-4 h-4"></i>
    </a>
</article>

<?php wp_reset_postdata(); ?>