<?php
if (! defined('ABSPATH')) {
	exit;
}

get_header(); ?>
<section id="home" class="py-8">
	<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
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
				setup_postdata($post);
				get_template_part('template-parts/post-card-with-label');
			endif;
		}
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
			$featured_post_1 = get_theme_mod("featured_post_1");
			$featured_post_2 = get_theme_mod("featured_post_2");

			$exclude = array_filter([$featured_post_1, $featured_post_2]);

			$args = [
				'post_type' => 'post',
				'posts_per_page' => 3,
				'post__not_in' => $exclude,
			];

			$query = new WP_Query($args);

			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post();
					get_template_part('template-parts/post-card-inline');
				endwhile;
				wp_reset_postdata();
			endif;
			?>

		</div>
	</div>
</section>
<?php get_template_part('template-parts/divider'); ?>

<?php
$number = get_theme_mod('related_posts_number', 3);
$section_class = get_theme_mod('related_posts_class', 'py-8');

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
			<h2 class="text-2xl font-medium mb-8"><?php _e('You might also like', 'gprodemi'); ?></h2>
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

<section id="categorias" class="py-8">
	<div class="container mx-auto">
		<h2 class="text-2xl font-medium mb-8"><?php _e('Browse by category', 'gprodemi'); ?></h2>
		<div>
			<ul class="flex flex-wrap gap-2 grid grid-cols-1 md:grid-cols-3 marker:text-[var(--color-listas)] list-disc marker:text-xl pl-4 text-lg text-gray-500">
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