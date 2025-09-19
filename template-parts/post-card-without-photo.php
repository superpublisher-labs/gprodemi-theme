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
    <p class="text-stone-800 mt-2 !text-lg"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
    <a href="<?php the_permalink(); ?>"
        class="text-[var(--color-links)] hover:underline flex items-center gap-2 text-lg mt-4 font-semibold"
        title="<?php the_title() ?: __('Sem Título', 'gprodemi'); ?>">
        <?php _e('Read More', 'gprodemi'); ?>
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right">
            <path d="M5 12h14" />
            <path d="m12 5 7 7-7 7" />
        </svg>
    </a>
</article>

<?php wp_reset_postdata(); ?>