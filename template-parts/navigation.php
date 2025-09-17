<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<div class="w-full flex justify-between mt-20">
    <div class="nav-previous">
        <?php previous_posts_link('<button class="py-2 pl-4 pr-6 rounded-lg bg-[var(--color-botao)] text-white flex items-center gap-2 transition-colors duration-300 hover:bg-[var(--color-botao)]/70 cursor-pointer"><svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-icon lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg> Previous</button>'); ?>
    </div>
    <div class="nav-next ml-auto">
        <?php next_posts_link('<button class="py-2 pl-6 pr-4 rounded-lg bg-[var(--color-botao)] text-white flex items-center gap-2 transition-colors duration-300 hover:bg-[var(--color-botao)]/70 cursor-pointer">Next <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-icon lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></button>'); ?>
    </div>
</div>