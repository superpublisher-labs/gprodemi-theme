<?php
global $displayed_posts;
if (!is_array($displayed_posts)) {
    $displayed_posts = [];
}
$number_related  = get_theme_mod('related_posts_number', 3);
$section_class   = 'py-20';

// pega as categorias do post atual
$categories = wp_get_post_categories(get_the_ID());

$related_args = [
    'post_type'      => 'post',
    'posts_per_page' => $number_related,
    'post__not_in'   => array_merge([$post->ID], $displayed_posts), // exclui post atual e já exibidos
    'category__in'   => $categories, // filtra pela(s) mesma(s) categoria(s)
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$related_query = new WP_Query($related_args);

if ($related_query->have_posts()) :
    $grid_class = 'grid grid-cols-1 gap-20 md:gap-8';
    if ($number_related % 4 === 0) {
        $grid_class .= ' sm:grid-cols-2 md:grid-cols-4';
    } else {
        $grid_class .= ' md:grid-cols-3';
    }
?>
    <section id="related-posts" class="<?php echo esc_attr($section_class); ?>">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-8"><?php _e('Related Posts', 'gprodemi'); ?></h2>
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