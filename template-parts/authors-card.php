<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<article class="w-full container mx-auto flex items-center justify-between">
    <div class="flex flex-col items-center w-full p-8 gap-2">
        <img src="<?php echo get_avatar_url(get_the_author_meta('ID'), ['size' => 96]); ?>"
            class="w-16 h-16 rounded-xl" alt="<?php the_author(); ?>">

        <span class="text-stone-800 font-medium"><?php _e('Posted and reviewed', 'gprodemi'); ?></span>
        <span class="text-xl font-semibold">
            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                <?php the_author(); ?>
            </a>
        </span>
        <span class="bg-[var(--color-botao)] px-2 flex items-center rounded-full">
            <a href="<?php echo get_category_link(get_the_category()[0]->term_id); ?>" class="!text-white !text-sm !font-medium">
                <?php echo get_the_category()[0]->name; ?>
            </a>
        </span>
        <span class="text-stone-800 text-sm"><?php echo get_the_date('d/m/Y'); ?></span>
    </div>
</article>