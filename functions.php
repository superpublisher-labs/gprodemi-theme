<?php

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

if (!class_exists(PucFactory::class) && file_exists(get_template_directory() . '/vendor/autoload.php')) {
	require_once get_template_directory() . '/vendor/autoload.php';
}

if (class_exists(PucFactory::class)) {
	$UpdateChecker = PucFactory::buildUpdateChecker(
		'https://github.com/superpublisher-labs/gprodemi-theme',
		get_template_directory() . '/style.css',
		'gprodemi'
	);

	$UpdateChecker->setBranch('master');
}


if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_theme_support('title-tag');

function gprodemi_custom_colors_css()
{
	$handle = 'gprodemi-style';

	$custom_css = "
        :root {
            --color-logo: " . esc_attr(get_theme_mod('color_logo', '#ff8c00')) . ";
            --color-links: " . esc_attr(get_theme_mod('color_links', '#0693e3')) . ";
            --color-listas: " . esc_attr(get_theme_mod('color_listas', '#0693e3')) . ";
            --color-botao: " . esc_attr(get_theme_mod('color_botao', '#0018cd')) . ";
            --color-divider: " . esc_attr(get_theme_mod('color_divider', '#ff8c00')) . ";
        }
    ";
	wp_add_inline_style($handle, $custom_css);
}
add_action('wp_enqueue_scripts', 'gprodemi_custom_colors_css');

add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
	if ($args->theme_location === 'primary_menu') {
		$classes[] = 'relative group';
	}
	return $classes;
}, 10, 4);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
	if ($args->theme_location === 'primary_menu') {
		$atts['class'] = 'text-stone-800 border-2 border-transparent hover:border-gray-200 px-2 py-1 rounded-xl transition-colors';
	}
	return $atts;
}, 10, 4);

add_filter('nav_menu_css_class', function ($classes, $item, $args, $depth) {
	if ($args->theme_location === 'footer_menu') {
		$classes[] = 'inline';
	}
	return $classes;
}, 10, 4);

add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
	if ($args->theme_location === 'footer_menu') {
		$atts['class'] = 'hover:!underline footer-menu-item';
	}
	return $atts;
}, 10, 4);

// Adiciona parâmetros atuais em links internos do conteúdo
add_filter('the_content', function ($content) {
	$params = $_GET;
	unset($params['s']); // remove search

	if (!empty($params)) {
		$query = '?' . http_build_query($params);

		// Adiciona query em todos os links internos do conteúdo
		$content = preg_replace_callback(
			'#href="(/[^"]*)"#',
			function ($matches) use ($query) {
				return 'href="' . $matches[1] . $query . '"';
			},
			$content
		);
	}

	return $content;
});

// Adiciona o template atual na barra de admin
function admin_bar($wp_admin_bar)
{
	if (! current_user_can('manage_options')) {
		return;
	}

	$theme = wp_get_theme();

	$args = array(
		'id'    =>	'template-atual',
		'title' =>	'GProdemi v' . $theme->get('Version'),
		'href'  => 	admin_url('customize.php'),
		'meta'  =>	array(
			'title' => 'Clique para abrir o Personalizador do Tema',
		)
	);

	$wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'admin_bar', 999);

// Adiciona parâmetros atuais em menus
add_filter('wp_nav_menu', function ($nav_menu) {
	$params = $_GET;
	unset($params['s']); // remove search

	if (!empty($params)) {
		$query = '?' . http_build_query($params);

		// Adiciona query em todos os links internos do menu
		$nav_menu = preg_replace_callback(
			'#href="(/[^"]*)"#',
			function ($matches) use ($query) {
				return 'href="' . $matches[1] . $query . '"';
			},
			$nav_menu
		);
	}

	return $nav_menu;
});

/**
 * Exibe o logo do site ou retorna o HTML.
 */
function display_custom_favicon()
{
	$site_icon_id = get_option('site_icon');

	if ($site_icon_id) {
		return;
	}

	$custom_logo_id = get_theme_mod('custom_logo');
	$logo_path = get_attached_file($custom_logo_id); // caminho físico do arquivo
	$logo_url  = wp_get_attachment_url($custom_logo_id); // URL original

	$file_extension = pathinfo($logo_path, PATHINFO_EXTENSION);
	$file_extension = strtolower($file_extension);

	if ($file_extension === 'svg') {
		$svg_content = file_get_contents($logo_path);
		$svg_content = str_replace('<svg', '<svg class="corLogoHeader"', $svg_content);
		$encoded_svg = base64_encode($svg_content);

		echo '<link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,' . $encoded_svg . '">';
		echo '<link rel="alternate icon" type="image/png" href="' . get_site_icon_url() . '">';
	} else if (in_array($file_extension, ['jpg', 'jpeg', 'png'])) {
		echo '<link rel="icon" type="image/' . $file_extension . '" href="' . esc_url($logo_url) . '">';
		echo '<link rel="alternate icon" type="image/png" href="' . esc_url($logo_url) . '">';
	}
}
add_action('wp_head', 'display_custom_favicon', 100);

add_filter('get_site_icon_url', function($url){
    return $url . '?v=1';
});

// Habiltiar SVG no header
function allow_svg_upload($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'theme-tailwind',
		get_theme_file_uri('/assets/css/output.css'),
		[],
		filemtime(get_theme_file_path('/assets/css/output.css'))
	);

	wp_enqueue_script(
		'theme-main',
		get_theme_file_uri('/assets/js/main.js'),
		[],
		filemtime(get_theme_file_path('/assets/js/main.js')),
		true
	);

	wp_enqueue_style(
		'font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
		[],
		'6.5.2'
	);
});

// Setup theme
function gprodemi_setup()
{
	load_theme_textdomain('gprodemi', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'gprodemi_setup');

// Customize Header
function theme_customize_register($wp_customize)
{
	$wp_customize->add_setting('show_site_title_logo', [
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
	]);

	$wp_customize->add_control('show_site_title_logo', [
		'label'   => __('Ativar título no cabeçalho', 'gprodemi'),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	]);

	$wp_customize->add_setting('activate_border_title', [
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
	]);

	$wp_customize->add_control('activate_border_title', [
		'label'   => __('Ativar borda no título', 'gprodemi'),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	]);
}
add_action('customize_register', 'theme_customize_register');

function theme_footer_text($wp_customize)
{
	$wp_customize->add_section('footer_text_section', [
		'title'    => __('Rodapé', 'gprodemi'),
		'priority' => 70,
	]);

	$wp_customize->add_setting('footer_text', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	]);

	$wp_customize->add_control('footer_text', [
		'label'   => __('Texto do rodapé', 'gprodemi'),
		'section' => 'footer_text_section',
		'type'    => 'textarea',
	]);
}
add_action('customize_register', 'theme_footer_text');

// Register Menus
function theme_register_menus()
{
	register_nav_menus([
		'primary_menu' => __('Menu Principal', 'gprodemi'),
		'footer_menu'  => __('Menu do Rodapé', 'gprodemi'),
	]);
}
add_action('after_setup_theme', 'theme_register_menus');

// Related Posts
function theme_customize_related_posts($wp_customize)
{
	$wp_customize->add_section('related_posts_section', [
		'title'    => __('Quantidade de posts', 'gprodemi'),
		'priority' => 70,
	]);

	$wp_customize->add_setting('related_posts_number', [
		'default'           => 3,
		'sanitize_callback' => 'absint',
	]);

	$wp_customize->add_control('related_posts_number', [
		'label'   => __('Número de posts por seção', 'gprodemi'),
		'section' => 'related_posts_section',
		'type'    => 'number',
	]);

	$wp_customize->add_setting('related_posts_page_number', [
		'default'           => 3,
		'sanitize_callback' => 'absint',
	]);

	$wp_customize->add_control('related_posts_page_number', [
		'label'   => __('Número de posts por página (categorias, autores, etc)', 'gprodemi'),
		'section' => 'related_posts_section',
		'type'    => 'number',
	]);
}
add_action('customize_register', 'theme_customize_related_posts');

// Posts per page
function custom_posts_per_page($query)
{
	if (!is_admin() && $query->is_main_query()) {
		if ($query->is_category() || $query->is_author() || $query->is_search()) {
			$query->set('posts_per_page', get_theme_mod('related_posts_page_number', 3));
		}
	}
}
add_action('pre_get_posts', 'custom_posts_per_page');

// Comments settings
function gprodemi_customize_register($wp_customize)
{
	$wp_customize->add_section('gprodemi_comments', [
		'title'    => __('Configurações de Comentários', 'gprodemi'),
		'priority' => 30,
	]);

	$wp_customize->add_setting('enable_comments_posts', [
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
	]);

	$wp_customize->add_control('enable_comments_posts', [
		'label'   => __('Habilitar comentários nos posts', 'gprodemi'),
		'section' => 'gprodemi_comments',
		'type'    => 'checkbox',
	]);
}
add_action('customize_register', 'gprodemi_customize_register');

function theme_customize_colors($wp_customize)
{
	$wp_customize->add_section('theme_colors', [
		'title'    => __('Cores do Tema', 'gprodemi'),
		'priority' => 20,
	]);

	$colors = [
		'logo'    => '#ff8c00',
		'links'   => '#0693e3',
		'listas'  => '#0693e3',
		'botao'   => '#0018cd',
		'divider' => '#ff8c00',
	];

	foreach ($colors as $slug => $default) {
		$wp_customize->add_setting("color_$slug", [
			'default'           => $default,
			'sanitize_callback' => 'sanitize_hex_color',
		]);

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "color_$slug", [
			'label'    => sprintf(__('Cor %s', 'gprodemi'), ucfirst($slug)),
			'section'  => 'theme_colors',
			'settings' => "color_$slug",
		]));
	}
}
add_action('customize_register', 'theme_customize_colors');

add_action('wp_head', function () {
?>
	<style>
		:root {
			--color-logo: <?php echo get_theme_mod('color_logo', '#ff8c00'); ?>;
			--color-links: <?php echo get_theme_mod('color_links', '#0693e3'); ?>;
			--color-listas: <?php echo get_theme_mod('color_listas', '#0693e3'); ?>;
			--color-botao: <?php echo get_theme_mod('color_botao', '#0018cd'); ?>;
			--color-divider: <?php echo get_theme_mod('color_divider', '#ff8c00'); ?>;
		}
	</style>
<?php
});

add_theme_support('custom-logo', [
	'height'      => 100,
	'width'       => 400,
	'flex-height' => true,
	'flex-width'  => true,
]);

add_action('customize_register', function ($wp_customize) {
	// Seção
	$wp_customize->add_section('gprodemi_index_section', [
		'title'    => __('Configurações do Index', 'gprodemi'),
		'priority' => 30,
	]);

	// Configuração (salva em theme_mod)
	$wp_customize->add_setting('gprodemi_index_version', [
		'default'   => 'v1',
		'transport' => 'refresh',
	]);

	// Controle (dropdown)
	$wp_customize->add_control('gprodemi_index_version_control', [
		'label'    => __('Escolha a versão do Index', 'gprodemi'),
		'section'  => 'gprodemi_index_section',
		'settings' => 'gprodemi_index_version',
		'type'     => 'select',
		'choices'  => [
			'v1' => __('Versão 1', 'gprodemi'),
			'v2' => __('Versão 2', 'gprodemi'),
		],
	]);

	// Configuração (salva em theme_mod)
	for ($i = 1; $i <= 2; $i++) {
		$wp_customize->add_setting("featured_post_$i", [
			'default'           => '',
			'sanitize_callback' => 'absint',
		]);

		// translators: %d is the featured post number
		$wp_customize->add_control("featured_post_$i", [
			'label'   => sprintf(_x('Post destacado %d', 'featured post number', 'gprodemi'), $i),
			'section' => 'gprodemi_index_section',
			'type'    => 'dropdown-pages',
		]);
	}

	// Configuração (salva em theme_mod)
	for ($i = 1; $i <= 3; $i++) {
		$wp_customize->add_setting("featured_cat_$i", [
			'default'           => $i,
			'sanitize_callback' => 'absint',
		]);

		$categories = get_categories(['hide_empty' => false]);
		$choices = [0 => '— ' . __('Selecionar', 'gprodemi') . ' —']; // <-- opção de limpar

		foreach ($categories as $cat) {
			$choices[$cat->term_id] = $cat->name;
		}

		$wp_customize->add_control("featured_cat_$i", [
			'label'   => sprintf(_x('Categoria do card %d', 'featured category card number', 'gprodemi'), $i),
			'section' => 'gprodemi_index_section',
			'type'    => 'select',
			'choices' => $choices,
		]);

		$wp_customize->add_setting("featured_cat_text_$i", [
			'default'           => __('Confira os melhores', 'gprodemi'),
			'sanitize_callback' => 'sanitize_text_field',
		]);
		$wp_customize->add_control("featured_cat_text_$i", [
			'label'   => sprintf(_x('Texto do card categoria %d', 'featured category card number', 'gprodemi'), $i),
			'section' => 'gprodemi_index_section',
			'type'    => 'text',
		]);
	}
});

add_filter('wpseo_metadesc', function ($desc) {
	if (is_author()) {
		$bio = get_the_author_meta('description');
		if (!empty($bio)) {
			return $bio;
		}
		return __('Artigos publicados por este autor.', 'seutema');
	}
	return $desc;
});

//CACHE
function register_cache_cleaner_menu() {
    add_menu_page(
        __('Limpar Cache', 'gprodemi'), 
        __('Limpar Cache', 'gprodemi'), 
        'manage_options', 
        'gprodemi-cache-cleaner', 
        'render_cache_cleaner_page', 
        'dashicons-editor-removeformatting',
        100
    );
}
add_action('admin_menu', 'register_cache_cleaner_menu');

function render_cache_cleaner_page() {
    if (isset($_POST['clean_cache']) && check_admin_referer('gprodemi_clean_cache_nonce')) {
        wp_cache_flush();
        
        flush_rewrite_rules();
        
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '%_transient_%'");
        
        if (function_exists('wp_cache_flush')) {
            wp_cache_flush();
        }
        
        echo '<div class="notice notice-success"><p>' . esc_html__('Cache limpo com sucesso!', 'gprodemi') . '</p></div>';
    }
    
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Limpar Cache do WordPress', 'gprodemi'); ?></h1>
        <div class="card" style="max-width: 800px; padding: 20px; margin-top: 20px;">
            <h2><?php esc_html_e('Limpeza de Cache', 'gprodemi'); ?></h2>
            <p><?php esc_html_e('Use esta ferramenta para limpar o cache interno do WordPress. Isso pode ajudar a resolver problemas de exibição e garantir que as alterações mais recentes sejam exibidas corretamente.', 'gprodemi'); ?></p>
            
            <div class="cache-info" style="background: #f8f9fa; padding: 15px; border-radius: 4px; margin: 15px 0;">
                <h3 style="margin-top: 0;"><?php esc_html_e('O que será limpo?', 'gprodemi'); ?></h3>
                <ul style="list-style-type: disc; margin-left: 20px;">
                    <li><?php esc_html_e('Cache de Objetos do WordPress - Armazenamento temporário de consultas e dados', 'gprodemi'); ?></li>
                    <li><?php esc_html_e('Regras de Reescrita - URLs personalizadas e estruturas de permalink', 'gprodemi'); ?></li>
                    <li><?php esc_html_e('Transientes - Dados temporários armazenados no banco de dados', 'gprodemi'); ?></li>
                    <li><?php esc_html_e('Cache de Consultas - Resultados armazenados de consultas ao banco de dados', 'gprodemi'); ?></li>
                </ul>
                <p class="description" style="margin-top: 10px; color: #666;">
                    <?php esc_html_e('Após a limpeza, o WordPress irá reconstruir o cache conforme necessário. Isso pode resultar em uma leve redução temporária de velocidade até que o novo cache seja construído.', 'gprodemi'); ?>
                </p>
            </div>
            
            <form method="POST">
                <?php wp_nonce_field('gprodemi_clean_cache_nonce'); ?>
                <p>
                    <button type="submit" name="clean_cache" class="button button-primary button-large">
                        <?php esc_html_e('Limpar Cache Agora', 'gprodemi'); ?>
                    </button>
                </p>
            </form>
        </div>
    </div>
    <?php
}