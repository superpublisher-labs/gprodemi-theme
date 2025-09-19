<section id="categorias" class="py-8">
    <div class="container mx-auto">
        <h2 class="text-2xl font-semibold mb-8"><?php _e('Browse by category', 'gprodemi'); ?></h2>
        <div>
            <ul class="flex flex-wrap gap-2 grid grid-cols-1 md:grid-cols-3 marker:text-[var(--color-listas)] list-disc marker:text-xl pl-5 text-lg text-stone-800">
                <?php
                $all_cats = get_categories(['orderby' => 'name', 'hide_empty' => true]);
                foreach ($all_cats as $cat) { ?>
                    <li class="hover:underline cursor-pointer">
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>