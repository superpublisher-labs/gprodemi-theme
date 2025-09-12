<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$UpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/superpublisher-labs/gprodemi-theme',
	get_template_directory() . '/style.css',
	'gprodemi'
);

$UpdateChecker->setBranch('master');

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
		'lucide-icons',
		'https://unpkg.com/lucide@latest/dist/umd/lucide.js',
		[],
		null,
		true
	);

	wp_enqueue_script(
		'theme-main',
		get_theme_file_uri('/assets/js/main.js'),
		['lucide-icons'],
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
