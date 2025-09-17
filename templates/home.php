<?php
if (! defined('ABSPATH')) {
	exit;
}

$displayed_posts = [];

get_header(); ?>

<section id="home" class="py-8">
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

<section id="vertical-posts" class="py-8">
    <div class="container mx-auto">
        <div class="flex flex-col items-start gap-6 w-full">
            <?php
            $vertical_args = [
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post__not_in'   => $displayed_posts,
            ];

            $vertical_query = new WP_Query($vertical_args);

            if ($vertical_query->have_posts()) :
                while ($vertical_query->have_posts()) : $vertical_query->the_post();
                    $displayed_posts[] = get_the_ID();
                    get_template_part('template-parts/post-card-inline');
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>
<?php get_template_part('template-parts/divider'); ?>

<?php
$number = get_theme_mod('related_posts_number', 3);
$section_class = get_theme_mod('related_posts_class', 'py-8');

$like_also_args = [
    'post_type'      => 'post',
    'posts_per_page' => $number,
    'post__not_in'   => $displayed_posts,
];

$like_also_query = new WP_Query($like_also_args);

if ($like_also_query->have_posts()) :
    $grid_class = 'grid grid-cols-1 gap-8';
    if ($number % 4 === 0) {
        $grid_class .= ' sm:grid-cols-2 md:grid-cols-4';
    } else {
        $grid_class .= ' md:grid-cols-3';
    }
?>
    <section id="like-also" class="<?php echo esc_attr($section_class); ?>">
        <div class="container mx-auto">
            <h2 class="text-2xl font-medium mb-8"><?php _e('You might also like', 'gprodemi'); ?></h2>
            <div class="<?php echo esc_attr($grid_class); ?>">
                <?php
                while ($like_also_query->have_posts()) : $like_also_query->the_post();
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

<section id="categorias" class="py-8">
    <div class="container mx-auto">
        <h2 class="text-2xl font-medium mb-8"><?php _e('Browse by category', 'gprodemi'); ?></h2>
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