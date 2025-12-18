<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>

<form class="relative mx-4" action="<?php echo home_url('/'); ?>" method="get">
	<input type="text" name="s" placeholder="<?php _e('Search articles, categories, tags...', 'gprodemi'); ?>"
		class="w-full px-4 py-2 pl-12 pr-16 text-lg rounded-xl border border-gray-300 focus:outline-none transition-all duration-300 bg-white shadow-sm"
		id="search-input">
	<svg class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-600 w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
		<path d="m21 21-4.34-4.34" />
		<circle cx="11" cy="11" r="8" />
	</svg>
	<button
		title="<?php _e('Search', 'gprodemi'); ?>"
		class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[var(--color-links)] hover:bg-[var(--color-links)]/80 text-white px-4 py-2 rounded-lg transition-colors duration-300 cursor-pointer">
		<svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search-icon lucide-search">
			<path d="m21 21-4.34-4.34" />
			<circle cx="11" cy="11" r="8" />
		</svg>
	</button>
</form>