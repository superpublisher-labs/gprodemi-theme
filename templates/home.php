<?php
if (! defined('ABSPATH')) {
	exit;
}

$displayed_posts = [];
set_query_var('displayed_posts', $displayed_posts);

get_header(); ?>

<section id="home" class="py-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <?php
        $featured_ids = [];
        for ($i = 1; $i <= 2; $i++) {
            $post_id = get_theme_mod("featured_post_$i");
            if ($post_id) {
                $featured_ids[] = $post_id;
            }
        }

        $featured_args = [
            'post_type'      => 'post',
            'posts_per_page' => 2,
            'ignore_sticky_posts' => 1,
        ];

        if (!empty($featured_ids)) {
            $featured_args['post__in'] = $featured_ids;
            $featured_args['orderby'] = 'post__in';
        } else {
            $featured_args['orderby'] = 'date';
            $featured_args['order'] = 'DESC';
        }

        $featured_query = new WP_Query($featured_args);

        if ($featured_query->have_posts()) :
            while ($featured_query->have_posts()) : $featured_query->the_post();
                $displayed_posts[] = get_the_ID();
                get_template_part('template-parts/post-card-with-label');
            endwhile;
        endif;
        wp_reset_postdata();
        ?>

        <article class="col-span-1 md:col-span-2 lg:col-span-1 flex flex-col md:flex-row lg:flex-col gap-4">
            <?php get_template_part('template-parts/category-card'); ?>
        </article>
    </div>
</section>

<?php get_template_part('template-parts/divider'); ?>

<?php get_template_part('template-parts/vertical-posts-section'); ?>

<?php get_template_part('template-parts/divider'); ?>

<?php get_template_part('template-parts/like-also-section'); ?>

<?php get_template_part('template-parts/divider'); ?>

<?php get_template_part('template-parts/category-section'); ?>

<?php get_footer(); ?>