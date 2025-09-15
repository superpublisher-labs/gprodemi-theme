<?php
if (! defined('ABSPATH')) {
    exit;
}

global $post;
$displayed_posts = [$post->ID];

get_header(); ?>
<section id="home" class="py-8">
    <div class="container mx-auto flex flex-col gap-6">
        <div class="grid md:grid-cols-1 lg:grid-cols-2 gap-8">
            <?php
            for ($i = 1; $i <= 2; $i++) {
                $post_id = get_theme_mod("featured_post_$i");
                if ($post_id) {
                    $post = get_post($post_id);
                } else {
                    $latest_posts = get_posts(['posts_per_page' => 2]);
                    $post = $latest_posts[$i - 1] ?? null;
                }

                if ($post):
                    set_query_var('post', $post);
                    get_template_part('template-parts/post-card-without-photo');
                endif;
            }
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
$number = get_theme_mod('related_posts_number', 3);
$section_class = 'py-8';

$first_post_id = get_the_ID();
$cats = wp_get_post_categories($first_post_id);

$args = [
    'post_type' => 'post',
    'posts_per_page' => $number,
    'category__in' => $cats,
    'post__not_in' => [$first_post_id],
];

$query = new WP_Query($args);

$grid_class = 'grid grid-cols-1 gap-8';

if ($number % 4 === 0) {
    $grid_class .= ' sm:grid-cols-2 md:grid-cols-4';
} else {
    $grid_class .= ' md:grid-cols-3';
}
?>

<?php if ($query->have_posts()) : ?>
    <section id="like-also" class="<?php echo esc_attr($section_class); ?>">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-8"><?php _e('You might also like', 'gprodemi'); ?></h2>
            <div class="<?php echo esc_attr($grid_class); ?>">
                <?php while ($query->have_posts()) : $query->the_post();
                    set_query_var('post', get_post());
                    get_template_part('template-parts/post-card');
                endwhile; ?>
            </div>
        </div>
    </section>
<?php endif;
wp_reset_postdata(); ?>
<?php get_template_part('template-parts/divider'); ?>

<?php
$number = get_theme_mod('related_posts_number', 3);
$section_class = 'py-8';
global $post;

$already_shown = [$post->ID]; // começa com o próprio post
$posts_to_show = [];

// pega os posts customizados
for ($i = 1; $i <= $number; $i++) {
    $post_id = get_theme_mod("gprodemi_segundo_bloco_post_{$i}");
    if ($post_id) {
        $post_obj = get_post($post_id);
        if ($post_obj && !in_array($post_obj->ID, $already_shown)) {
            $posts_to_show[] = $post_obj->ID;
            $already_shown[] = $post_obj->ID;
        }
    }
}

// se não bateu o número, pega posts recentes sem repetir
if (count($posts_to_show) < $number) {
    $remaining = $number - count($posts_to_show);
    $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => $remaining,
        'post__not_in'   => $already_shown,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();
            if (!in_array($id, $already_shown)) {
                $posts_to_show[] = $id;
                $already_shown[] = $id;
            }
        }
    }
    wp_reset_postdata();
}

// garante que não haja duplicatas
$posts_to_show = array_unique($posts_to_show);

// exibe os posts
$grid_class = 'grid grid-cols-1 gap-8';
if ($number % 4 === 0) {
    $grid_class .= ' sm:grid-cols-2 md:grid-cols-4';
} else {
    $grid_class .= ' md:grid-cols-3';
}
?>

<?php if (!empty($posts_to_show)) : ?>
    <section id="trendings" class="<?php echo esc_attr($section_class); ?>">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-8"><?php _e('Tendências', 'gprodemi'); ?></h2>
            <div class="<?php echo esc_attr($grid_class); ?>">
                <?php
                foreach ($posts_to_show as $post_id) {
                    $post_obj = get_post($post_id);
                    if ($post_obj) {
                        setup_postdata($post_obj);
                        get_template_part('template-parts/post-card');
                    }
                }
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
                $all_cats = get_categories(['orderby' => 'name', 'hide_empty' => false]);

                $featured_cats = [];
                for ($i = 1; $i <= 3; $i++) {
                    $cat_id = get_theme_mod("featured_cat_$i");
                    if ($cat_id) $featured_cats[] = $cat_id;
                }

                foreach ($all_cats as $cat) {
                    $is_featured = in_array($cat->term_id, $featured_cats);
                ?>
                    <li class="hover:underline cursor-pointer">
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>
<?php get_footer(); ?>