<?php
function create_product_post_type() {
    
    $labels = array(
      'name' => __( 'Товари' ),
      'singular_name' => __( 'Products' ),
      'add_new' => __( 'Нові Товари' ),
      'add_new_item' => __( 'Додати товар' ),
      'edit_item' => __( 'Редагувати товар' ),
      'new_item' => __( 'Новий товар' ),
      'view_item' => __( 'Переглянути товар' ),
      'search_items' => __( 'Шукати товари' ),
      'not_found' =>  __( 'Не знайдено товарів' ),
      'not_found_in_trash' => __( 'No Products found in Trash' ),
    );

    $args = array(
      'labels' => $labels,
      'has_archive' => true,
      'public' => true,
      'hierarchical' => false,
      'menu_position' => 5,
      'supports' => array(
        'title',
        'editor',
        'excerpt',
        'custom-fields',
        'thumbnail'
        ),

        'taxonomies' => array(
            'subject',
            'color',
            'material',
            'size'
        ),
      );
    register_post_type( 'products', $args );
    flush_rewrite_rules();
  }
  add_action( 'init', 'create_product_post_type');