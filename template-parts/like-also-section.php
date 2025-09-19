<?php
$displayed_posts = get_query_var('displayed_posts', []);
$number = get_theme_mod('related_posts_number', 3);
$section_class = get_theme_mod('related_posts_class', 'py-8');

$like_also_args = [
    'post_type'      => 'post',
    'posts_per_page' => $number,
    'post__not_in'   => $displayed_posts,
];

$like_also_query = new WP_Query($like_also_args);

if ($like_also_query->have_posts()) :
    $grid_class = 'grid grid-cols-1 gap-12 md:gap-8';
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