<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <?php include get_template_directory() . '/inc/facebookpixel.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400..900&display=swap" rel="stylesheet">
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
							<a id="logo-title" href="<?php echo home_url('/'); ?>" title="<?php _e('Home', 'gprodemi'); ?>" class="text-xl md:text-2xl font-semibold <?php if (get_theme_mod('activate_border_title', false)) : ?>border-2  border-[var(--color-logo)] rounded-lg px-3<?php endif; ?>"><?php bloginfo('name'); ?></a>
						<?php endif; ?>
					</div>
					<?php
					wp_nav_menu([
						'theme_location'  => 'primary_menu',
						'container'       => 'nav',
						'container_class' => 'hidden md:flex items-center',
						'menu_class'      => 'flex space-x-2 list-none',
					]);
					?>
				</div>
				<div class="flex items-center gap-4 justify-between">
					<button id="search-btn" class="hover:text-[var(--color-links)] transition-colors cursor-pointer" title="<?php _e('Search', 'gprodemi'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
							<path d="m21 21-4.34-4.34" />
							<circle cx="11" cy="11" r="8" />
						</svg>
					</button>

					<button id="mobile-menu-btn" class="md:hidden hover:text-[var(--color-links)] transition-colors" title="<?php _e('Menu', 'gprodemi'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu">
							<path d="M4 5h16" />
							<path d="M4 12h16" />
							<path d="M4 19h16" />
						</svg>
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
						class="hover:text-[var(--color-links)] transition-all duration-300 flex w-full md:w-1/2 hover:text-[var(--color-links)]/70 justify-between items-center">
						<?php echo esc_html($item->title); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right">
							<path d="M5 12h14" />
							<path d="m12 5 7 7-7 7" />
						</svg>
					</a>
		<?php
				}
			}
		}
		?>

		<button id="close-mobile-menu"
			class="hover:text-[var(--color-links)] transition-colors transition-all mt-4">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
				<path d="M18 6 6 18" />
				<path d="m6 6 12 12" />
			</svg>
		</button>
	</div>

	<main id="primary" class="container mx-auto px-4">