<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
</main>
<footer class="p-6 pb-10 bg-stone-100">
	<div class="container mx-auto">
		<div class="flex flex-col gap-10">
			<span class="text-gray-600">
				<?php echo esc_html(get_theme_mod('footer_text')); ?>
			</span>

			<div>
				<?php
				wp_nav_menu([
					'theme_location'  => 'footer_menu', // slug registrado no register_nav_menus
					'container'       => false, // remove <div> extra
					'menu_class'      => 'flex gap-4 text-sm text-gray-600 flex-wrap list-none', // classe do <ul>
					'add_li_class'    => '', // não existe nativo, vou já resolver com filter abaixo
				]);

				add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
					if ($args->theme_location === 'footer_menu') {
						$classes[] = 'inline';
					}
					return $classes;
				}, 10, 4);

				add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
					if ($args->theme_location === 'footer_menu') {
						$atts['class'] = 'hover:!underline';
					}
					return $atts;
				}, 10, 4);

				?>
			</div>
		</div>
	</div>
</footer>
<?php
wp_footer();
?>
</body>

</html>