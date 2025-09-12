<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<div class="w-full flex justify-between mt-8">
    <div class="nav-previous">
        <?php previous_posts_link('<button class="py-2 pl-4 pr-6 rounded-lg bg-[var(--color-botao)] text-white flex items-center gap-2 transition-colors duration-300 hover:bg-[var(--color-botao)]/70 cursor-pointer"><i data-lucide="arrow-left" class="w-4 h-4"></i> Previous</button>'); ?>
    </div>
    <div class="nav-next ml-auto">
        <?php next_posts_link('<button class="py-2 pl-6 pr-4 rounded-lg bg-[var(--color-botao)] text-white flex items-center gap-2 transition-colors duration-300 hover:bg-[var(--color-botao)]/70 cursor-pointer">Next <i data-lucide="arrow-right" class="w-4 h-4"></i></button>'); ?>
    </div>
</div>