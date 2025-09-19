<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

for ($i = 1; $i <= 3; $i++) {

    // pega a categoria selecionada no Customizer
    $cat_id = get_theme_mod("featured_cat_$i", 0);

    // se não tiver categoria selecionada, pega default
    if (!$cat_id) {
        $all_cats = get_categories(['orderby' => 'name', 'hide_empty' => false]);
        $cat_id = $all_cats[$i - 1]->term_id ?? 0;
        if (!$cat_id) continue;
    }

    $cat = get_category($cat_id);
    if (!$cat || is_wp_error($cat)) continue;

    // pega texto do card
    $card_text = get_theme_mod("featured_cat_text_$i", __("Confira os melhores", "gprodemi"));
?>
    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="w-full !p-2 lg:p-0 rounded-xl bg-white/5 backdrop-blur-sm flex-1 flex flex-col items-center justify-center border border-gray-300">
        <h3 class="!text-md !font-medium"><?php echo esc_html($cat->name); ?></h3>
        <span class="text-gray-600"><?php echo esc_html($card_text); ?></span>
    </a>
<?php
}
?>