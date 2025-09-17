<?php
if (! defined('ABSPATH')) {
	exit;
}

get_header(); ?>

<section id="artigos" class="py-8 w-full max-w-4xl mx-auto">
	<h1 class="!text-2xl md:!text-3xl !text-black font-semibold mb-4"><?php the_title(); ?></h1>
	<article id="artigo" class="w-full container mx-auto space-y-4 mb-16">
		<?php the_content(); ?>
	</article>

	<?php get_template_part('template-parts/divider'); ?>
	<?php
	if (have_posts()) :
		while (have_posts()) : the_post();
			get_template_part('template-parts/authors-card');
		endwhile;
	endif;
	?>

	<?php
	$enable_comments = get_theme_mod('enable_comments_posts', false);

	if ($enable_comments && (comments_open() || get_comments_number())) :
		comments_template();
	endif;
	?>
</section>
<?php get_template_part('template-parts/divider'); ?>

<?php
$number = get_theme_mod('related_posts_number', 3);
$section_class = get_theme_mod('related_posts_class', 'py-16');

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
			<h2 class="text-3xl font-semibold mb-8"><?php esc_html_e('You might also like', 'textdomain'); ?></h2>
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


<?php get_footer(); ?>