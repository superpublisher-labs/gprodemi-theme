<?php
if (!defined('ABSPATH')) exit;

$version = get_theme_mod('gprodemi_index_version', 'v1');

if ($version === 'v2') {
    include get_stylesheet_directory() . '/templates/home.php';
} else {
    include get_stylesheet_directory() . '/templates/home-2.php';
}
