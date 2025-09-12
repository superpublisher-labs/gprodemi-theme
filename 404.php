<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

get_header(); ?>
<main id="primary" class="container mx-auto py-8">
	<section class="text-center max-w-3xl mx-auto h-full">
		<h1 class="text-5xl font-bold mb-4 text-gray-800">404</h1>
		<h2 class="text-3xl font-semibold mb-6 text-gray-700"><?php _e('Oops! Page not found.', 'gprodemi'); ?></h2>
		<p class="text-gray-600 mb-6">
			<?php _e('Sorry, but the page you were trying to view does not exist. You can return to the homepage or try a search below.', 'gprodemi'); ?>
		</p>
		<div class="flex justify-center gap-4 mb-8">
			<a href="<?php echo home_url('/'); ?>" class="py-3 bg-[var(--color-botao)] text-white font-semibold rounded-lg hover:bg-[var(--color-botao)]/70 transition">
				<?php _e('Go to Homepage', 'gprodemi'); ?>
			</a>
		</div>
		<?php get_search_form(); ?>
	</section>
</main>

<?php get_footer(); ?>