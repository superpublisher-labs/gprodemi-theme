<?php
global $displayed_posts;
if (!is_array($displayed_posts)) {
    $displayed_posts = [];
}
?>
<section id="vertical-posts" class="py-20">
    <div class="container mx-auto">
        <div class="flex flex-col items-start gap-20 w-full">
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