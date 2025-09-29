<?php
if (! defined('ABSPATH')) {
    exit;
}

global $post;
$displayed_posts = [];
set_query_var('displayed_posts', $displayed_posts);

get_header(); ?>

<section id="home" class="py-20">
    <div class="container mx-auto flex flex-col gap-6">
        <div class="grid md:grid-cols-1 lg:grid-cols-2 gap-8">
            <?php
            $featured_posts_query_args = [
                'post_type'      => 'post',
                'posts_per_page' => 2,
                'post__not_in'   => $displayed_posts,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ];
            
            $custom_post_ids = [];
            for ($i = 1; $i <= 2; $i++) {
                $post_id = get_theme_mod("featured_post_$i");
                if ($post_id) {
                    $custom_post_ids[] = $post_id;
                }
            }

            if (!empty($custom_post_ids)) {
                $featured_posts_query_args['post__in'] = array_unique($custom_post_ids);
                $featured_posts_query_args['orderby'] = 'post__in';
                $featured_posts_query_args['posts_per_page'] = count($custom_post_ids);
            }

            $featured_query = new WP_Query($featured_posts_query_args);

            if ($featured_query->have_posts()) :
                while ($featured_query->have_posts()) : $featured_query->the_post();

                    $displayed_posts[] = get_the_ID();

                    set_query_var('post', $post); 
                    get_template_part('template-parts/post-card-without-photo');
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
        <article id='category-cards-home2' class="flex flex-col sm:flex-row gap-6">
            <?php get_template_part('template-parts/category-card'); ?>
        </article>
    </div>
</section>

<?php get_template_part('template-parts/divider'); ?>

<?php get_template_part('template-parts/related-posts-section'); ?>

<?php get_template_part('template-parts/divider'); ?>

<?php get_template_part('template-parts/trendings-section'); ?>

<?php get_template_part('template-parts/divider'); ?>

<?php get_template_part('template-parts/category-section'); ?>

<?php get_footer(); ?>