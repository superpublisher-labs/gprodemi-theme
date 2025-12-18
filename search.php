<?php
if (! defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<section id="search-results" class="py-8">
    <div class="container mx-auto">

        <?php if (have_posts()) : ?>

            <?php
            // Total de resultados
            $total_results = $wp_query->found_posts;

            // Pré-carregar thumbs para performance
            update_post_thumbnail_cache($wp_query);
            ?>

            <h2 class="text-3xl font-semibold mb-8">
                <?php printf(
                    esc_html__('%s result(s) for "%s"', 'gprodemi'),
                    esc_html($total_results),
                    esc_html(get_search_query())
                ); ?>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr(get_theme_mod('related_posts_page_number', 3) % 4 === 0 ? 4 : 3); ?>  gap-8">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    get_template_part('partials/post-card');
                    ?>
                <?php endwhile; ?>
            </div>

            <?php get_template_part('template-parts/navigation'); ?>

        <?php else : ?>
            <h2 class="text-3xl font-semibold mb-8">
                <?php esc_html_e('No results found for', 'gprodemi'); ?>
                "<?php echo esc_html(get_search_query()); ?>"
            </h2>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>