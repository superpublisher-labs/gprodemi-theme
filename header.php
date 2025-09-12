<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<title><?php bloginfo('name'); ?></title>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	wp_head();

	add_action('wp_head', function () {
	?>
		<style>
			:root {
				--color-logo: <?php echo get_theme_mod('color_logo', '!important #ff8c00'); ?>;
				--color-links: <?php echo get_theme_mod('color_links', '!important #0693e3'); ?>;
				--color-listas: <?php echo get_theme_mod('color_listas', '!important #0693e3'); ?>;
				--color-botao: <?php echo get_theme_mod('color_botao', '!important #0018cd'); ?>;
				--color-divider: <?php echo get_theme_mod('color_divider', '!important #ff8c00'); ?>;
			}
		</style>
	<?php
	});

	?>

</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header class="w-full border-b border-gray-200">
		<nav class="container mx-auto py-1 md:py-2 px-4">
			<div class="flex items-center flex-wrap justify-between gap-4">
				<div class="flex items-center gap-8">
					<div class="flex flex-row items-center text-[var(--color-logo)] gap-2">

						<?php
						$logo_id = get_theme_mod('custom_logo');
						$logo_url = wp_get_attachment_url($logo_id);

						if ($logo_url) {
							$ext = pathinfo($logo_url, PATHINFO_EXTENSION);
						?>
							<span class="logo-header w-10 h-10 md:w-14 md:h-14 flex justify-center items-center">
								<?php
								if (strtolower($ext) === 'svg') {
									$logo_path = get_attached_file($logo_id);
									if ($logo_path && file_exists($logo_path)) {
										$svg = file_get_contents($logo_path);
										$svg = preg_replace('/fill=".*?"/', 'fill="currentColor"', $svg);
										echo $svg;
									}
								} else {
									echo '<img src="' . esc_url($logo_url) . '" alt="' . get_bloginfo('name') . '">';
								}
								?>
							</span>
						<?php
						}
						?>

						<?php if (get_theme_mod('show_site_title_logo', true)) : ?>
							<a id="logo-title" href="<?php echo home_url('/'); ?>" title="<?php _e('Home', 'gprodemi'); ?>" class="text-xl md:text-2xl font-bold <?php if (get_theme_mod('activate_border_title', false)) : ?>border-2  border-[var(--color-logo)] rounded-lg px-3<?php endif; ?>"><?php bloginfo('name'); ?></a>
						<?php endif; ?>
					</div>
					<?php
					add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
						if ($args->theme_location === 'primary_menu') {
							$classes[] = 'relative group';
						}
						return $classes;
					}, 10, 4);

					add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
						if ($args->theme_location === 'primary_menu') {
							$atts['class'] = 'text-gray-600 hover:text-[var(--color-links)] transition-colors';
						}
						return $atts;
					}, 10, 4);

					// Chamada do menu
					wp_nav_menu([
						'theme_location'  => 'primary_menu',
						'container'       => 'nav',
						'container_class' => 'hidden md:flex items-center',
						'menu_class'      => 'flex space-x-6 list-none',
					]);
					?>
				</div>
				<div class="flex items-center gap-4 justify-between">
					<button id="search-btn" class="hover:text-[var(--color-links)] transition-colors cursor-pointer" title="<?php _e('Search', 'gprodemi'); ?>">
						<i data-lucide="search"></i>
					</button>

					<button id="mobile-menu-btn" class="md:hidden hover:text-[var(--color-links)] transition-colors" title="<?php _e('Menu', 'gprodemi'); ?>">
						<i data-lucide="menu"></i>
					</button>
				</div>
			</div>
		</nav>
	</header>

	<section id="search" class="hidden animate-slide-down overflow-hidden">
		<div class="container mx-auto pt-4">
			<div class="max-w-6xl mx-auto">
				<?php get_search_form(); ?>
			</div>
		</div>
	</section>

	<div id="mobile-menu"
		class="fixed top-0 left-0 right-0 z-50 bg-white p-4 flex justify-center items-center w-full h-screen transition-all duration-300 flex-col gap-4 hidden">

		<?php
		$locations = get_nav_menu_locations();
		$menu_id   = isset($locations['primary_menu']) ? $locations['primary_menu'] : 0;

		if ($menu_id) {
			$menu_items = wp_get_nav_menu_items($menu_id);
			if ($menu_items) {
				foreach ($menu_items as $item) {
		?>
					<a href="<?php echo esc_url($item->url); ?>"
						class="hover:text-[var(--color-links)] transition-all duration-300 flex w-full md:w-1/2 hover:text-blue-500 justify-between items-center">
						<?php echo esc_html($item->title); ?>
						<i data-lucide="arrow-right"></i>
					</a>
		<?php
				}
			}
		}
		?>

		<button id="close-mobile-menu"
			class="hover:text-purple-400 transition-colors transition-all mt-4">
			<i data-lucide="x"></i>
		</button>
	</div>

	<main id="primary" class="container mx-auto px-4">