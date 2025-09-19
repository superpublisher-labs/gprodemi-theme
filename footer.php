<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
</main>
<footer class="p-6 py-15 bg-stone-100">
	<div class="container mx-auto">
		<div class="flex flex-col gap-15">
			<span class="text-gray-600">
				<?php echo esc_html(get_theme_mod('footer_text')); ?>
			</span>

			<div>
				<?php
				wp_nav_menu([
					'theme_location'  => 'footer_menu',
					'container'       => false,
					'menu_class'      => 'flex md:gap-2 divide-y divide-stone-300 md:divide-y-0 text-sm text-gray-600 flex-col md:flex-row list-none footer-menu',
					'add_li_class'    => '',
				]);
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