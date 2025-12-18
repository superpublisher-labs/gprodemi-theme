<?php
global $displayed_posts;
if (!is_array($displayed_posts)) {
    $displayed_posts = [];
}
$number_trending = get_theme_mod('related_posts_number', 3);
$section_class = 'py-20';
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

    $grid_class = 'grid grid-cols-1 gap-20 md:gap-8';
    if ($number_trending % 4 === 0) {
        $grid_class .= ' sm:grid-cols-2 md:grid-cols-4';
    } else {
        $grid_class .= ' md:grid-cols-3';
    }
?>
    <section id="trendings" class="<?php echo esc_attr($section_class); ?>">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-8"><?php _e('Trending Posts', 'gprodemi'); ?></h2>
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