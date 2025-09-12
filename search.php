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
                    esc_html__('%s resultado(s) para "%s"', 'textdomain'),
                    esc_html($total_results),
                    esc_html(get_search_query())
                ); ?>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr(get_theme_mod('related_posts_page_number', 3)%4 === 0 ? 4 : 3 ); ?>  gap-8">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    get_template_part('partials/post-card');
                    ?>
                <?php endwhile; ?>
            </div>

            <div class="w-full flex justify-between mt-20">
                <div class="nav-previous">
                    <?php previous_posts_link('<button class="py-2 pl-4 pr-6 rounded-lg bg-[var(--color-botao)] text-white flex items-center gap-2 transition-colors duration-300 hover:bg-[var(--color-botao)]/70 cursor-pointer"><i data-lucide="arrow-left" class="w-4 h-4"></i> Previous</button>'); ?>
                </div>
                <div class="nav-next ml-auto">
                    <?php next_posts_link('<button class="py-2 pl-6 pr-4 rounded-lg bg-[var(--color-botao)] text-white flex items-center gap-2 transition-colors duration-300 hover:bg-[var(--color-botao)]/70 cursor-pointer">Next <i data-lucide="arrow-right" class="w-4 h-4"></i></button>'); ?>
                </div>
            </div>

        <?php else : ?>
            <h2 class="text-3xl font-semibold mb-8">
                <?php esc_html_e('Nenhum resultado encontrado para', 'textdomain'); ?>
                "<?php echo esc_html(get_search_query()); ?>"
            </h2>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>