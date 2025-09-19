<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

?>
</main>
<footer class="p-6 pb-10 bg-stone-100">
	<div class="container mx-auto">
		<div class="flex flex-col gap-8">
			<span class="text-stone-800">
				<?php echo esc_html(get_theme_mod('footer_text')); ?>
			</span>

			<div>
				<?php
				wp_nav_menu([
					'theme_location'  => 'footer_menu',
					'container'       => false,
					'menu_class'      => 'flex md:gap-2 divide-y divide-stone-300 md:divide-y-0 text-sm text-stone-800 flex-col md:flex-row list-none footer-menu',
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