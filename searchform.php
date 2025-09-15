<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>

<form class="relative mx-4" action="<?php echo home_url('/'); ?>" method="get">
	<input type="text" name="s" placeholder="<?php _e('Search articles, apps, tips...', 'textdomain'); ?>"
		class="w-full px-4 py-2 pl-12 pr-16 text-lg rounded-xl border border-gray-300 focus:outline-none transition-all duration-300 bg-white shadow-sm"
		id="search-input">
	<i data-lucide="search"
		class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-700 w-6 h-6"></i>
	<button
		title="<?php _e('Search', 'textdomain'); ?>"
		class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[var(--color-links)] hover:bg-[var(--color-links)]/80 text-white px-4 py-2 rounded-lg transition-colors duration-300 cursor-pointer">
		<i data-lucide="search" class="w-4 h-4"></i>
	</button>
</form>