<?php
if (! defined('ABSPATH')) {
	exit;
}

get_header(); ?>

<section id="policy" class="py-8 w-full max-w-4xl mx-auto">
	<h1 class="!text-3xl font-semibold mb-4"><?php the_title(); ?></h1>
	<article class="w-full container mx-auto space-y-4 mb-8 text-lg/8 text-gray-500">
		<?php the_content(); ?>
	</article>
</section>

<?php get_footer(); ?>