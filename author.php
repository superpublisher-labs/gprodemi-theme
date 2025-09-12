<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<section id="author" class="py-8">
    <div class="container mx-auto">
        <?php
        $author = get_queried_object();
        $author_id = $author->ID;
        ?>

        <div class="flex items-center gap-4 mb-8">
            <?php echo get_avatar($author_id, 96, '', esc_attr($author->display_name), ['class' => 'w-12 h-12 rounded-full']); ?>

            <div class="flex flex-col">
                <h2 class="text-2xl font-semibold">
                    <?php echo esc_html($author->display_name); ?>
                </h2>
                <?php if (!empty($author->description)) : ?>
                    <p class="text-gray-600">
                        <?php echo esc_html($author->description); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr(get_theme_mod('related_posts_page_number', 3)%4 === 0 ? 4 : 3 ); ?>  gap-8">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('partials/post-card'); ?>
            <?php endwhile; ?>
        </div>

        <?php get_template_part('template-parts/navigation'); ?>
    </div>
</section>

<?php get_footer(); ?>