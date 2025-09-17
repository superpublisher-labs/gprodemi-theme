<?php
if (! defined('ABSPATH')) {
    exit;
}

global $post;
$displayed_posts = [];

get_header(); ?>

<section id="home" class="py-8">
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
        <article class="flex flex-col sm:flex-row gap-6">
            <?php get_template_part('template-parts/category-card'); ?>
        </article>
    </div>
</section>

<?php get_template_part('template-parts/divider'); ?>

<?php
$number_related = get_theme_mod('related_posts_number', 3);
$section_class = 'py-8';

$related_args = [
    'post_type'      => 'post',
    'posts_per_page' => $number_related,
    'post__not_in'   => $displayed_posts,
];

$related_query = new WP_Query($related_args);

if ($related_query->have_posts()) :
    $grid_class = 'grid grid-cols-1 gap-8';
    if ($number_related % 4 === 0) {
        $grid_class .= ' sm:grid-cols-2 md:grid-cols-4';
    } else {
        $grid_class .= ' md:grid-cols-3';
    }
?>
    <section id="like-also" class="<?php echo esc_attr($section_class); ?>">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-8"><?php _e('You might also like', 'gprodemi'); ?></h2>
            <div class="<?php echo esc_attr($grid_class); ?>">
                <?php
                while ($related_query->have_posts()) : $related_query->the_post();
                    $displayed_posts[] = get_the_ID();
                    get_template_part('template-parts/post-card');
                endwhile;
                ?>
            </div>
        </div>
    </section>
<?php 
endif;
wp_reset_postdata(); 
?>

<?php get_template_part('template-parts/divider'); ?>

<?php
$number_trending = get_theme_mod('related_posts_number', 3);
$section_class = 'py-8';
$trending_post_ids = [];

for ($i = 1; $i <= $number_trending; $i++) {
    $post_id = get_theme_mod("gprodemi_segundo_bloco_post_{$i}");
    if ($post_id && !in_array($post_id, $displayed_posts)) {
        $trending_post_ids[] = $post_id;
    }
}

$remaining = $number_trending - count($trending_post_ids);
if ($remaining > 0) {
    $fallback_query_args = [
        'post_type'      => 'post',
        'posts_per_page' => $remaining,
        'post__not_in'   => array_merge($displayed_posts, $trending_post_ids),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    $fallback_posts = get_posts($fallback_query_args);
    foreach ($fallback_posts as $p) {
        $trending_post_ids[] = $p->ID;
    }
}

$trending_post_ids = array_unique($trending_post_ids);

if (!empty($trending_post_ids)) :
    $displayed_posts = array_merge($displayed_posts, $trending_post_ids);

    $grid_class = 'grid grid-cols-1 gap-8';
    if ($number_trending % 4 === 0) {
        $grid_class .= ' sm:grid-cols-2 md:grid-cols-4';
    } else {
        $grid_class .= ' md:grid-cols-3';
    }
?>
    <section id="trendings" class="<?php echo esc_attr($section_class); ?>">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-8"><?php _e('Tendências', 'gprodemi'); ?></h2>
            <div class="<?php echo esc_attr($grid_class); ?>">
                <?php
                $trending_query = new WP_Query([
                    'post_type' => 'post',
                    'post__in' => $trending_post_ids,
                    'orderby' => 'post__in',
                    'posts_per_page' => count($trending_post_ids),
                ]);

                if ($trending_query->have_posts()):
                    while ($trending_query->have_posts()): $trending_query->the_post();
                        get_template_part('template-parts/post-card');
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php get_template_part('template-parts/divider'); ?>

<section id="categorias" class="py-8">
    <div class="container mx-auto">
        <h2 class="text-2xl font-semibold mb-8"><?php _e('Browse by category', 'gprodemi'); ?></h2>
        <div>
            <ul class="flex flex-wrap gap-2 grid grid-cols-1 md:grid-cols-3 marker:text-[var(--color-listas)] list-disc marker:text-xl pl-4 text-lg text-gray-700">
                <?php
                $all_cats = get_categories(['orderby' => 'name', 'hide_empty' => true]);
                foreach ($all_cats as $cat) { ?>
                    <li class="hover:underline cursor-pointer">
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>

<?php get_footer(); ?>