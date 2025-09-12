<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<article class="relative md:col-span-1 lg:col-span-2">
    <a href="<?php echo get_permalink($post); ?>">
        <?php if (has_post_thumbnail($post)) : ?>
            <?php echo get_the_post_thumbnail($post, 'large', ['class' => 'w-full rounded-xl flex', 'height' => '600', 'width' => '360']); ?>
        <?php else: ?>
            <img class="w-full rounded-xl flex" src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder.webp" alt="<?php echo get_the_title($post); ?>" />
        <?php endif; ?>
    </a>
    <h3 class="text-xl !text-white !font-medium absolute bottom-0 left-0 text-white rounded-b-xl bg-black/70 p-2 w-full">
        <a href="<?php echo get_permalink($post); ?>"><?php echo get_the_title($post) ?: __('Sem Título', 'gprodemi'); ?></a>
    </h3>
</article>