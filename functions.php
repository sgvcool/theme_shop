<?php
error_reporting(E_ERROR | E_PARSE); //відключити все крім

remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );

add_action('wp_enqueue_scripts', 'styles_theme');
add_action('wp_enqueue_scripts', 'scripts_theme');

function styles_theme() {
    wp_enqueue_style( 'default', get_stylesheet_uri() );
    wp_enqueue_style( 'styles', get_template_directory_uri() .'/dist/css/style.min.css');
}

function scripts_theme(){
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, null, true );
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'libs', get_template_directory_uri() . '/dist/js/libs.min.js', ['jquery'], null, true);
    wp_enqueue_script( 'main-script', get_template_directory_uri() . '/dist/js/main.js', ['libs'], null, true );
}

apply_filters( 'the_content', get_the_content() );

add_theme_support( 'post-thumbnails' );
add_image_size( 'preview', 50, 50, true );
add_image_size( 'product', 250, 200, true );

add_theme_support( 'menus' );
add_action( 'after_setup_theme', 'setMenus' );

function setMenus(){
    register_nav_menus( [
        'header_menu'   => 'Header menu',
        'footer_menu'   => 'Footer Menu',
        'sidebar_menu'  => 'Sidebar menu'
	] );
}

/**
 * create custom post type product
 */
if (file_exists(__DIR__ . "/inc/create_custom_post_type.php")) {
    require_once(__DIR__ . "/inc/create_custom_post_type.php");
}

/**
 * create taxonomy for product
 */
if (file_exists(__DIR__ . "/inc/register_product_taxonomy.php")) {
    require_once(__DIR__ . "/inc/register_product_taxonomy.php");
}